<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Client;
use App\Models\Service;
use App\Models\Staff;
use App\Models\Booking;
use App\Models\Inventory;
use App\Models\Product;
use App\Models\Promotion;
use App\Models\Subscription;
use App\Models\Partner;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        Booking::query()->delete();
        DB::table('partner_users')->delete();
        Partner::query()->delete();
        Promotion::query()->delete();
        Product::query()->delete();
        Inventory::query()->delete();
        Staff::query()->delete();
        Service::query()->delete();
        Subscription::query()->delete();
        Client::query()->delete();
        User::query()->delete();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        // Users (same logins as before)
        $adminUser = User::create([
            'name' => 'Admin',
            'email' => 'admin@bogosland.com',
            'password' => Hash::make('admin123'),
            'is_admin' => true,
            'role' => 'admin',
        ]);

        $clientUsers = [
            [
                'name' => 'Sarah Johnson',
                'email' => 'sarah.j@email.com',
                'password' => Hash::make('client123'),
                'is_admin' => false,
                'role' => 'client',
                'phone' => '+1 234 567 8901',
            ],
            [
                'name' => 'Michael Chen',
                'email' => 'mchen@email.com',
                'password' => Hash::make('client123'),
                'is_admin' => false,
                'role' => 'client',
                'phone' => '+1 234 567 8902',
            ],
        ];

        foreach ($clientUsers as $userData) {
            User::create($userData);
        }

        $partnerUser = User::create([
            'name' => 'Hotel Atlas',
            'email' => 'partner@hotel-atlas.com',
            'password' => Hash::make('partner123'),
            'role' => 'partner',
            'is_admin' => false,
        ]);

        $partner = Partner::create([
            'name' => 'Hotel Atlas',
            'type' => 'Hotel',
            'contact_name' => 'Youssef Karim',
            'contact_email' => 'partner@hotel-atlas.com',
            'contact_phone' => '+212 6 12 34 56 78',
            'commission_rate' => 12.5,
            'active' => true,
        ]);

        $partner->users()->attach($partnerUser->id);

        // Clients
        $clients = [
            [
                'name' => 'Sarah Johnson',
                'email' => 'sarah.j@email.com',
                'phone' => '+1 234 567 8901',
                'join_date' => '2023-01-15',
                'subscription' => 'Premium',
                'total_spent' => 1250,
                'visits' => 15,
                'last_visit' => '2024-01-10',
                'preferences' => ['Aromatherapy', 'Hot Stone Massage'],
                'notes' => 'Prefers morning appointments',
            ],
            [
                'name' => 'Michael Chen',
                'email' => 'mchen@email.com',
                'phone' => '+1 234 567 8902',
                'join_date' => '2023-03-22',
                'subscription' => 'Basic',
                'total_spent' => 680,
                'visits' => 8,
                'last_visit' => '2024-01-08',
                'preferences' => ['Deep Tissue Massage'],
                'notes' => 'Athlete - focus on recovery',
            ],
            [
                'name' => 'Lina Ahmed',
                'email' => 'lina.a@email.com',
                'phone' => '+1 234 567 8903',
                'join_date' => '2023-06-05',
                'subscription' => 'Standard',
                'total_spent' => 940,
                'visits' => 11,
                'last_visit' => '2024-01-12',
                'preferences' => ['Facial', 'Manicure'],
                'notes' => 'Prefers afternoon appointments',
            ],
        ];

        foreach ($clients as $client) {
            Client::create($client);
        }

        // Services
        $services = [
            [
                'name' => 'Classic Haircut',
                'category' => 'Hair Salon',
                'duration' => 45,
                'price' => 35,
                'description' => 'Professional haircut with styling consultation',
                'image' => 'https://images.unsplash.com/photo-1519699047748-de8e457a634e?w=500',
                'available' => true,
            ],
            [
                'name' => 'Traditional Hammam',
                'category' => 'Hammam',
                'duration' => 90,
                'price' => 75,
                'description' => 'Authentic Turkish bath experience with exfoliation',
                'image' => 'https://images.unsplash.com/photo-1544161515-4ab6ce6db874?w=500',
                'available' => true,
            ],
            [
                'name' => 'Deep Tissue Massage',
                'category' => 'Massage',
                'duration' => 60,
                'price' => 80,
                'description' => 'Therapeutic massage for muscle tension relief',
                'image' => 'https://images.unsplash.com/photo-1519823551278-64ac92734fb1?w=500',
                'available' => true,
            ],
            [
                'name' => 'Aromatherapy Massage',
                'category' => 'Massage',
                'duration' => 60,
                'price' => 90,
                'description' => 'Relaxing massage with essential oils and calming aromas',
                'image' => 'https://images.unsplash.com/photo-1544161515-4ab6ce6db874?w=500',
                'available' => true,
            ],
            [
                'name' => 'Luxury Hammam Package',
                'category' => 'Hammam',
                'duration' => 120,
                'price' => 120,
                'description' => 'Complete hammam ritual with mask and hydration',
                'image' => 'https://images.unsplash.com/photo-1559599238-308793637427?w=500',
                'available' => true,
            ],
            [
                'name' => 'Hydrating Facial',
                'category' => 'Skincare',
                'duration' => 50,
                'price' => 65,
                'description' => 'Deep cleansing facial with hydration boost',
                'image' => 'https://images.unsplash.com/photo-1524504388940-b1c1722653e1?w=500',
                'available' => true,
            ],
            [
                'name' => 'Luxury Manicure',
                'category' => 'Nail Care',
                'duration' => 40,
                'price' => 35,
                'description' => 'Nail shaping, cuticle care, and polish',
                'image' => 'https://images.unsplash.com/photo-1522335789203-aabd1fc54bc9?w=500',
                'available' => true,
            ],
            [
                'name' => 'Deluxe Pedicure',
                'category' => 'Nail Care',
                'duration' => 50,
                'price' => 45,
                'description' => 'Foot soak, exfoliation, and polish',
                'image' => 'https://images.unsplash.com/photo-1515378791036-0648a3ef77b2?w=500',
                'available' => true,
            ],
            [
                'name' => 'Signature Facial',
                'category' => 'Skincare',
                'duration' => 60,
                'price' => 85,
                'description' => 'Customized facial treatment tailored to your skin type',
                'image' => 'https://images.unsplash.com/photo-1522335789203-aabd1fc54bc9?w=500',
                'available' => true,
            ],
            [
                'name' => 'Scalp Massage',
                'category' => 'Hair Salon',
                'duration' => 25,
                'price' => 25,
                'description' => 'Relaxing scalp massage with nourishing oils',
                'image' => 'https://images.unsplash.com/photo-1519699047748-de8e457a634e?w=500',
                'available' => true,
            ],
            [
                'name' => 'Body Wrap Detox',
                'category' => 'Body Care',
                'duration' => 70,
                'price' => 95,
                'description' => 'Detoxifying body wrap with natural minerals',
                'image' => 'https://images.unsplash.com/photo-1544161515-4ab6ce6db874?w=500',
                'available' => true,
            ],
            [
                'name' => 'Express Manicure',
                'category' => 'Nail Care',
                'duration' => 25,
                'price' => 20,
                'description' => 'Quick nail shaping and polish refresh',
                'image' => 'https://images.unsplash.com/photo-1522335789203-aabd1fc54bc9?w=500',
                'available' => true,
            ],
        ];

        foreach ($services as $service) {
            Service::create($service);
        }

        // Staff
        $staff = [
            [
                'name' => 'Amina Hassan',
                'role' => 'Hammam Specialist',
                'specialties' => ['Hammam', 'Luxury Hammam Package'],
                'email' => 'amina.h@bogosland.com',
                'phone' => '+1 234 567 9001',
                'join_date' => '2022-03-15',
                'rating' => 4.9,
                'completed_services' => 450,
                'availability' => ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'],
                'image' => 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?w=200',
            ],
            [
                'name' => 'Maria Santos',
                'role' => 'Massage Therapist',
                'specialties' => ['Massage', 'Aromatherapy Massage'],
                'email' => 'maria.s@bogosland.com',
                'phone' => '+1 234 567 9003',
                'join_date' => '2022-01-10',
                'rating' => 4.9,
                'completed_services' => 520,
                'availability' => ['Monday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'],
                'image' => 'https://images.unsplash.com/photo-1524504388940-b1c1722653e1?w=200',
            ],
            [
                'name' => 'Olivia Reed',
                'role' => 'Hair Stylist',
                'specialties' => ['Hair Salon', 'Coloring'],
                'email' => 'olivia.r@bogosland.com',
                'phone' => '+1 234 567 9005',
                'join_date' => '2022-07-21',
                'rating' => 4.8,
                'completed_services' => 410,
                'availability' => ['Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'],
                'image' => 'https://images.unsplash.com/photo-1524504388940-b1c1722653e1?w=200',
            ],
        ];

        foreach ($staff as $member) {
            Staff::create($member);
        }

        // Staff payout percentages per service
        $servicesByName = Service::all()->keyBy('name');
        $staffByName = Staff::all()->keyBy('name');

        $payoutMap = [
            ['service' => 'Classic Haircut', 'staff' => 'Olivia Reed', 'percent' => 35],
            ['service' => 'Traditional Hammam', 'staff' => 'Amina Hassan', 'percent' => 30],
            ['service' => 'Deep Tissue Massage', 'staff' => 'Maria Santos', 'percent' => 40],
            ['service' => 'Aromatherapy Massage', 'staff' => 'Maria Santos', 'percent' => 40],
            ['service' => 'Luxury Hammam Package', 'staff' => 'Amina Hassan', 'percent' => 32],
            ['service' => 'Hydrating Facial', 'staff' => 'Maria Santos', 'percent' => 28],
            ['service' => 'Luxury Manicure', 'staff' => 'Olivia Reed', 'percent' => 25],
            ['service' => 'Deluxe Pedicure', 'staff' => 'Olivia Reed', 'percent' => 25],
        ];

        foreach ($payoutMap as $row) {
            $service = $servicesByName->get($row['service']);
            $staffMember = $staffByName->get($row['staff']);
            if ($service && $staffMember) {
                $service->staff()->syncWithoutDetaching([
                    $staffMember->id => ['payout_percentage' => $row['percent']],
                ]);
            }
        }

        // Inventory
        $inventory = [
            [
                'name' => 'Argan Oil',
                'category' => 'Oils',
                'quantity' => 18,
                'min_quantity' => 10,
                'unit' => 'bottles',
                'price' => 12.50,
                'supplier' => 'Morocco Naturals',
                'last_restocked' => '2024-01-10',
                'status' => 'in-stock',
            ],
            [
                'name' => 'Hammam Black Soap',
                'category' => 'Hammam',
                'quantity' => 6,
                'min_quantity' => 10,
                'unit' => 'bars',
                'price' => 6.00,
                'supplier' => 'Traditional Supplies',
                'last_restocked' => '2024-01-05',
                'status' => 'low-stock',
            ],
            [
                'name' => 'Massage Towels',
                'category' => 'Linen',
                'quantity' => 3,
                'min_quantity' => 8,
                'unit' => 'sets',
                'price' => 25.00,
                'supplier' => 'Spa Essentials Co.',
                'last_restocked' => '2023-12-28',
                'status' => 'critical',
            ],
        ];

        foreach ($inventory as $item) {
            Inventory::create($item);
        }

        // Products
        $products = [
            [
                'name' => 'Relaxation Candle Set',
                'category' => 'Home Spa',
                'price' => 25,
                'image' => 'https://images.unsplash.com/photo-1519681393784-d120267933ba?w=500',
                'description' => 'Set of 3 aromatherapy candles for relaxation.',
                'in_stock' => true,
                'rating' => 4.8,
            ],
            [
                'name' => 'Hydrating Face Mask',
                'category' => 'Skincare',
                'price' => 18,
                'image' => 'https://images.unsplash.com/photo-1501004318641-b39e6451bec6?w=500',
                'description' => 'Deep hydration mask with botanical extracts.',
                'in_stock' => true,
                'rating' => 4.6,
            ],
            [
                'name' => 'Organic Body Scrub',
                'category' => 'Body Care',
                'price' => 22,
                'image' => 'https://images.unsplash.com/photo-1522335789203-aabd1fc54bc9?w=500',
                'description' => 'Exfoliating scrub with natural oils.',
                'in_stock' => false,
                'rating' => 4.7,
            ],
            [
                'name' => 'Herbal Bath Salts',
                'category' => 'Home Spa',
                'price' => 16,
                'image' => 'https://images.unsplash.com/photo-1501004318641-b39e6451bec6?w=500',
                'description' => 'Soothing bath salts infused with herbs.',
                'in_stock' => true,
                'rating' => 4.5,
            ],
            [
                'name' => 'Silk Pillowcase',
                'category' => 'Wellness',
                'price' => 32,
                'image' => 'https://images.unsplash.com/photo-1522335789203-aabd1fc54bc9?w=500',
                'description' => 'Smooth silk pillowcase for hair and skin care.',
                'in_stock' => true,
                'rating' => 4.4,
            ],
            [
                'name' => 'Rejuvenating Serum',
                'category' => 'Skincare',
                'price' => 28,
                'image' => 'https://images.unsplash.com/photo-1524504388940-b1c1722653e1?w=500',
                'description' => 'Lightweight serum for glowing, hydrated skin.',
                'in_stock' => true,
                'rating' => 4.7,
            ],
            [
                'name' => 'Massage Oil Blend',
                'category' => 'Body Care',
                'price' => 20,
                'image' => 'https://images.unsplash.com/photo-1519681393784-d120267933ba?w=500',
                'description' => 'Premium oil blend for relaxation massage.',
                'in_stock' => true,
                'rating' => 4.6,
            ],
            [
                'name' => 'Herbal Tea Collection',
                'category' => 'Wellness',
                'price' => 14,
                'image' => 'https://images.unsplash.com/photo-1501004318641-b39e6451bec6?w=500',
                'description' => 'Curated herbal teas for calm and balance.',
                'in_stock' => true,
                'rating' => 4.3,
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }

        // Promotions
        $promotions = [
            [
                'title' => 'New Year Glow',
                'description' => '20% off all skincare services this month.',
                'discount' => 20,
                'type' => 'percentage',
                'valid_from' => '2024-01-01',
                'valid_until' => '2024-01-31',
                'applicable_services' => ['Skincare'],
                'status' => 'active',
                'code' => 'GLOW20',
            ],
            [
                'title' => 'Weekend Hammam',
                'description' => 'Save $15 on all Hammam packages.',
                'discount' => 15,
                'type' => 'fixed',
                'valid_from' => '2023-12-01',
                'valid_until' => '2023-12-31',
                'applicable_services' => ['Hammam'],
                'status' => 'expired',
                'code' => 'HAMMAM15',
            ],
        ];

        foreach ($promotions as $promotion) {
            Promotion::create($promotion);
        }

        // Subscriptions
        $subscriptions = [
            [
                'name' => 'Basic',
                'price' => 49,
                'duration' => 'monthly',
                'benefits' => [
                    '10% discount on all services',
                    '1 free classic service per month',
                    'Priority booking',
                ],
                'color' => 'primary',
                'popular' => false,
            ],
            [
                'name' => 'Standard',
                'price' => 89,
                'duration' => 'monthly',
                'benefits' => [
                    '15% discount on all services',
                    '2 free services per month',
                    'Priority booking',
                ],
                'color' => 'secondary',
                'popular' => true,
            ],
            [
                'name' => 'Premium',
                'price' => 129,
                'duration' => 'monthly',
                'benefits' => [
                    '20% discount on all services',
                    '4 free services per month',
                    'VIP concierge booking',
                    'Exclusive events access',
                ],
                'color' => 'accent',
                'popular' => false,
            ],
        ];

        foreach ($subscriptions as $subscription) {
            Subscription::create($subscription);
        }

        // Bookings
        $serviceClassic = Service::where('name', 'Classic Haircut')->first();
        $serviceHammam = Service::where('name', 'Traditional Hammam')->first();
        $serviceMassage = Service::where('name', 'Deep Tissue Massage')->first();
        $clientSarah = Client::where('email', 'sarah.j@email.com')->first();
        $clientMichael = Client::where('email', 'mchen@email.com')->first();
        $staffAmina = Staff::where('name', 'Amina Hassan')->first();
        $staffMaria = Staff::where('name', 'Maria Santos')->first();

        $bookingSeed = [
            [
                'client' => $clientSarah,
                'service' => $serviceHammam,
                'staff' => $staffAmina,
                'date' => Carbon::now()->addDays(2)->toDateString(),
                'time' => '10:00',
                'status' => 'confirmed',
            ],
            [
                'client' => $clientMichael,
                'service' => $serviceMassage,
                'staff' => $staffMaria,
                'date' => Carbon::now()->addDays(5)->toDateString(),
                'time' => '15:30',
                'status' => 'pending',
            ],
            [
                'client' => $clientSarah,
                'service' => $serviceClassic,
                'staff' => null,
                'date' => Carbon::now()->subDays(3)->toDateString(),
                'time' => '11:30',
                'status' => 'confirmed',
            ],
            [
                'client' => $clientMichael,
                'service' => $serviceMassage,
                'staff' => $staffMaria,
                'date' => Carbon::now()->addDays(1)->toDateString(),
                'time' => '14:00',
                'status' => 'pending',
                'partner' => $partner,
            ],
        ];

        foreach ($bookingSeed as $entry) {
            if (!$entry['client'] || !$entry['service']) {
                continue;
            }

            $partnerEntry = $entry['partner'] ?? null;
            $commissionRate = $partnerEntry?->commission_rate;
            $commissionAmount = $commissionRate ? round(($entry['service']->price * $commissionRate) / 100, 2) : null;
            $staffPayoutPercent = 0;
            $staffPayoutAmount = 0;
            if ($entry['staff']) {
                $payout = $entry['service']
                    ->staff()
                    ->where('staff_id', $entry['staff']->id)
                    ->first()
                    ?->pivot
                    ?->payout_percentage ?? 0;
                $staffPayoutPercent = $payout;
                $staffPayoutAmount = round(($entry['service']->price * $staffPayoutPercent) / 100, 2);
            }

            Booking::create([
                'client_id' => $entry['client']->id,
                'client_name' => $entry['client']->name,
                'service_id' => $entry['service']->id,
                'service' => $entry['service']->name,
                'staff_id' => $entry['staff']?->id,
                'staff_name' => $entry['staff']?->name,
                'date' => $entry['date'],
                'time' => $entry['time'],
                'duration' => $entry['service']->duration,
                'price' => $entry['service']->price,
                'status' => $entry['status'],
                'notes' => 'Seeded booking',
                'partner_id' => $partnerEntry?->id,
                'partner_name' => $partnerEntry?->name,
                'commission_rate' => $commissionRate,
                'commission_amount' => $commissionAmount,
                'staff_payout_percentage' => $staffPayoutPercent,
                'staff_payout_amount' => $staffPayoutAmount,
            ]);
        }
    }
}
