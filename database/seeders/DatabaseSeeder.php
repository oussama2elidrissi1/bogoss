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
                'name' => 'Youssef El Amrani',
                'email' => 'youssef@menclient.com',
                'password' => Hash::make('client123'),
                'is_admin' => false,
                'role' => 'client',
                'phone' => '+212 6 10 20 30 40',
            ],
            [
                'name' => 'Adil Bensaid',
                'email' => 'adil@menclient.com',
                'password' => Hash::make('client123'),
                'is_admin' => false,
                'role' => 'client',
                'phone' => '+212 6 11 22 33 44',
            ],
            [
                'name' => 'Karim Ouazzani',
                'email' => 'karim@menclient.com',
                'password' => Hash::make('client123'),
                'is_admin' => false,
                'role' => 'client',
                'phone' => '+212 6 12 23 34 45',
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
                'name' => 'Youssef El Amrani',
                'email' => 'youssef@menclient.com',
                'phone' => '+212 6 10 20 30 40',
                'join_date' => '2023-02-15',
                'subscription' => 'Premium',
                'total_spent' => 1420,
                'visits' => 14,
                'last_visit' => '2024-01-11',
                'preferences' => ['Coupe Homme', 'Barbe Premium'],
                'notes' => 'Préférence matin',
            ],
            [
                'name' => 'Adil Bensaid',
                'email' => 'adil@menclient.com',
                'phone' => '+212 6 11 22 33 44',
                'join_date' => '2023-05-22',
                'subscription' => 'Standard',
                'total_spent' => 820,
                'visits' => 9,
                'last_visit' => '2024-01-08',
                'preferences' => ['Massage Sportif', 'Soin Visage Homme'],
                'notes' => 'Après 18h',
            ],
            [
                'name' => 'Karim Ouazzani',
                'email' => 'karim@menclient.com',
                'phone' => '+212 6 12 23 34 45',
                'join_date' => '2023-07-05',
                'subscription' => 'Basic',
                'total_spent' => 560,
                'visits' => 6,
                'last_visit' => '2024-01-05',
                'preferences' => ['Soin Cuir Chevelu'],
                'notes' => 'Week‑end',
            ],
        ];

        foreach ($clients as $client) {
            Client::create($client);
        }

        // Services
        $services = [
            [
                'name' => 'Coupe simple',
                'category' => 'Coiffe',
                'duration' => 30,
                'price' => 30,
                'description' => 'Coupe classique.',
                'image' => 'https://images.unsplash.com/photo-1517836357463-d25dfeac3438?w=500',
                'available' => true,
            ],
            [
                'name' => 'Coupe enfant',
                'category' => 'Coiffe',
                'duration' => 30,
                'price' => 30,
                'description' => 'Coupe pour enfant.',
                'image' => 'https://images.unsplash.com/photo-1500530855697-b586d89ba3ee?w=500',
                'available' => true,
            ],
            [
                'name' => 'Barbre',
                'category' => 'Coiffe',
                'duration' => 15,
                'price' => 30,
                'description' => 'Taille barbe.',
                'image' => 'https://images.unsplash.com/photo-1503951914875-452162b0f3f1?w=500',
                'available' => true,
            ],
            [
                'name' => 'Tête + Barbre',
                'category' => 'Coiffe',
                'duration' => 45,
                'price' => 50,
                'description' => 'Coupe + barbe.',
                'image' => 'https://images.unsplash.com/photo-1521572163474-6864f9cf17ab?w=500',
                'available' => true,
            ],
            [
                'name' => "Tour d'oreilles",
                'category' => 'Coiffe',
                'duration' => 15,
                'price' => 30,
                'description' => "Nettoyage autour des oreilles.",
                'image' => 'https://images.unsplash.com/photo-1519699047748-de8e457a634e?w=500',
                'available' => true,
            ],
            [
                'name' => 'Brushing',
                'category' => 'Coiffe',
                'duration' => 10,
                'price' => 20,
                'description' => 'Brushing rapide.',
                'image' => 'https://images.unsplash.com/photo-1501004318641-b39e6451bec6?w=500',
                'available' => true,
            ],
            [
                'name' => 'Soins cheveux',
                'category' => 'Coiffe',
                'duration' => 15,
                'price' => 20,
                'description' => 'Soin capillaire.',
                'image' => 'https://images.unsplash.com/photo-1515378791036-0648a3ef77b2?w=500',
                'available' => true,
            ],
            [
                'name' => 'Coloration cheveux',
                'category' => 'Coiffe',
                'duration' => 60,
                'price' => 100,
                'description' => 'Coloration cheveux.',
                'image' => 'https://images.unsplash.com/photo-1505691938895-1758d7feb511?w=500',
                'available' => true,
            ],
            [
                'name' => 'Défrisage',
                'category' => 'Coiffe',
                'duration' => 60,
                'price' => 100,
                'description' => 'Défrisage.',
                'image' => 'https://images.unsplash.com/photo-1524504388940-b1c1722653e1?w=500',
                'available' => true,
            ],
            [
                'name' => 'Kératine',
                'category' => 'Coiffe',
                'duration' => 60,
                'price' => 300,
                'description' => 'Soin kératine.',
                'image' => 'https://images.unsplash.com/photo-1492562080023-ab3db95bfbce?w=500',
                'available' => true,
            ],
            [
                'name' => 'Protéine',
                'category' => 'Coiffe',
                'duration' => 60,
                'price' => 400,
                'description' => 'Soin protéine.',
                'image' => 'https://images.unsplash.com/photo-1521572163474-6864f9cf17ab?w=500',
                'available' => true,
            ],
            [
                'name' => 'SOIN VISAGE VAPEUR 30 MIN',
                'category' => 'Coiffe',
                'duration' => 30,
                'price' => 80,
                'description' => 'Soin visage vapeur.',
                'image' => 'https://images.unsplash.com/photo-1507537297725-24a1c029d3ca?w=500',
                'available' => true,
            ],
            [
                'name' => 'Masque',
                'category' => 'Coiffe',
                'duration' => 15,
                'price' => 30,
                'description' => 'Masque capillaire.',
                'image' => 'https://images.unsplash.com/photo-1522335789203-aabd1fc54bc9?w=500',
                'available' => true,
            ],
            [
                'name' => 'Hammam huile',
                'category' => 'Coiffe',
                'duration' => 15,
                'price' => 30,
                'description' => 'Hammam huile.',
                'image' => 'https://images.unsplash.com/photo-1559599238-308793637427?w=500',
                'available' => true,
            ],
            [
                'name' => 'Hammam Huile + Casque vapeur',
                'category' => 'Coiffe',
                'duration' => 25,
                'price' => 50,
                'description' => 'Hammam + vapeur.',
                'image' => 'https://images.unsplash.com/photo-1544161515-4ab6ce6db874?w=500',
                'available' => true,
            ],
            [
                'name' => 'coloration cheveux',
                'category' => 'Coiffe',
                'duration' => 30,
                'price' => 100,
                'description' => 'Coloration express.',
                'image' => 'https://images.unsplash.com/photo-1519699047748-de8e457a634e?w=500',
                'available' => true,
            ],
            [
                'name' => 'coloration barbe',
                'category' => 'Coiffe',
                'duration' => 20,
                'price' => 50,
                'description' => 'Coloration barbe.',
                'image' => 'https://images.unsplash.com/photo-1503951914875-452162b0f3f1?w=500',
                'available' => true,
            ],
            [
                'name' => 'SOIN VISAGE VAPEUR + COUPE + BARBE',
                'category' => 'Coiffe',
                'duration' => 60,
                'price' => 120,
                'description' => 'Pack vapeur + coupe + barbe.',
                'image' => 'https://images.unsplash.com/photo-1521572163474-6864f9cf17ab?w=500',
                'available' => true,
            ],
            [
                'name' => 'lasserre',
                'category' => 'Coiffe',
                'duration' => 15,
                'price' => 20,
                'description' => 'Service lasserre.',
                'image' => 'https://images.unsplash.com/photo-1500530855697-b586d89ba3ee?w=500',
                'available' => true,
            ],
            [
                'name' => 'SOIN VISAGE VAPEUR 30 MIN + COUPE',
                'category' => 'Coiffe',
                'duration' => 45,
                'price' => 100,
                'description' => 'Vapeur + coupe.',
                'image' => 'https://images.unsplash.com/photo-1507537297725-24a1c029d3ca?w=500',
                'available' => true,
            ],
            [
                'name' => 'Hammam normale',
                'category' => 'Hammam',
                'duration' => 45,
                'price' => 130,
                'description' => 'Hammam normale.',
                'image' => 'https://images.unsplash.com/photo-1559599238-308793637427?w=500',
                'available' => true,
            ],
            [
                'name' => 'Hammam avec Fourniture',
                'category' => 'Hammam',
                'duration' => 45,
                'price' => 150,
                'description' => 'Hammam avec fourniture.',
                'image' => 'https://images.unsplash.com/photo-1544161515-4ab6ce6db874?w=500',
                'available' => true,
            ],
            [
                'name' => 'Hammam complet',
                'category' => 'Hammam',
                'duration' => 75,
                'price' => 200,
                'description' => 'Hammam complet.',
                'image' => 'https://images.unsplash.com/photo-1559599238-308793637427?w=500',
                'available' => true,
            ],
            [
                'name' => 'Hammam simple enfant',
                'category' => 'Hammam',
                'duration' => 30,
                'price' => 50,
                'description' => 'Hammam enfant.',
                'image' => 'https://images.unsplash.com/photo-1544161515-4ab6ce6db874?w=500',
                'available' => true,
            ],
            [
                'name' => 'Hammam avec fourniture enfant',
                'category' => 'Hammam',
                'duration' => 35,
                'price' => 80,
                'description' => 'Hammam enfant avec fourniture.',
                'image' => 'https://images.unsplash.com/photo-1559599238-308793637427?w=500',
                'available' => true,
            ],
            [
                'name' => 'Service accompagné',
                'category' => 'Hammam',
                'duration' => 5,
                'price' => 20,
                'description' => 'Service accompagné.',
                'image' => 'https://images.unsplash.com/photo-1544161515-4ab6ce6db874?w=500',
                'available' => true,
            ],
            [
                'name' => 'Hammam classique avec fourniture',
                'category' => 'Hammam',
                'duration' => 45,
                'price' => 150,
                'description' => 'Hammam classique.',
                'image' => 'https://images.unsplash.com/photo-1559599238-308793637427?w=500',
                'available' => true,
            ],
            [
                'name' => 'Hammam Royal',
                'category' => 'Hammam',
                'duration' => 60,
                'price' => 250,
                'description' => 'Hammam royal.',
                'image' => 'https://images.unsplash.com/photo-1544161515-4ab6ce6db874?w=500',
                'available' => true,
            ],
            [
                'name' => 'Hammam + Coiffe',
                'category' => 'Packages',
                'duration' => 75,
                'price' => 180,
                'description' => 'Pack hammam + coiffe.',
                'image' => 'https://images.unsplash.com/photo-1559599238-308793637427?w=500',
                'available' => true,
            ],
            [
                'name' => 'Pack350=Hammam classic+1/2Massage',
                'category' => 'Packages',
                'duration' => 90,
                'price' => 350,
                'description' => 'Pack hammam + demi massage.',
                'image' => 'https://images.unsplash.com/photo-1544161515-4ab6ce6db874?w=500',
                'available' => true,
            ],
            [
                'name' => 'Pack299=Hammam + 1/4Massage + Coiff',
                'category' => 'Packages',
                'duration' => 75,
                'price' => 300,
                'description' => 'Pack hammam + quart massage + coiffe.',
                'image' => 'https://images.unsplash.com/photo-1505691938895-1758d7feb511?w=500',
                'available' => true,
            ],
            [
                'name' => 'Pack250 = Coiffe + Barbre + Mask + 1/4 Massage',
                'category' => 'Packages',
                'duration' => 90,
                'price' => 249,
                'description' => 'Pack coiffe + barbe + masque + quart massage.',
                'image' => 'https://images.unsplash.com/photo-1503951914875-452162b0f3f1?w=500',
                'available' => true,
            ],
            [
                'name' => 'Produit Gommage',
                'category' => 'Produits',
                'duration' => 5,
                'price' => 50,
                'description' => 'Produit gommage.',
                'image' => 'https://images.unsplash.com/photo-1522335789203-aabd1fc54bc9?w=500',
                'available' => true,
            ],
            [
                'name' => 'Fourniture Hammam',
                'category' => 'Produits',
                'duration' => 5,
                'price' => 30,
                'description' => 'Fourniture hammam.',
                'image' => 'https://images.unsplash.com/photo-1559599238-308793637427?w=500',
                'available' => true,
            ],
            [
                'name' => 'Gant gommage',
                'category' => 'Produits',
                'duration' => 1,
                'price' => 30,
                'description' => 'Gant gommage.',
                'image' => 'https://images.unsplash.com/photo-1522335789203-aabd1fc54bc9?w=500',
                'available' => true,
            ],
            [
                'name' => 'Massage Sportif',
                'category' => 'Soins',
                'duration' => 60,
                'price' => 400,
                'description' => 'Massage sportif.',
                'image' => 'https://images.unsplash.com/photo-1519823551278-64ac92734fb1?w=500',
                'available' => true,
            ],
            [
                'name' => 'Massage 15 minutes',
                'category' => 'Soins',
                'duration' => 15,
                'price' => 100,
                'description' => 'Massage 15 minutes.',
                'image' => 'https://images.unsplash.com/photo-1544161515-4ab6ce6db874?w=500',
                'available' => true,
            ],
            [
                'name' => 'Massage',
                'category' => 'Soins',
                'duration' => 30,
                'price' => 250,
                'description' => 'Massage classique.',
                'image' => 'https://images.unsplash.com/photo-1519823551278-64ac92734fb1?w=500',
                'available' => true,
            ],
            [
                'name' => 'Hijama',
                'category' => 'Hijama',
                'duration' => 30,
                'price' => 200,
                'description' => 'Hijama.',
                'image' => 'https://images.unsplash.com/photo-1507537297725-24a1c029d3ca?w=500',
                'available' => true,
            ],
            [
                'name' => 'Massage préparatif+Hijama+Douche',
                'category' => 'Hijama',
                'duration' => 60,
                'price' => 250,
                'description' => 'Pack hijama complet.',
                'image' => 'https://images.unsplash.com/photo-1544161515-4ab6ce6db874?w=500',
                'available' => true,
            ],
            [
                'name' => 'Douche+Hijama+Fouta naria',
                'category' => 'Hijama',
                'duration' => 60,
                'price' => 300,
                'description' => 'Hijama + douche + fouta naria.',
                'image' => 'https://images.unsplash.com/photo-1559599238-308793637427?w=500',
                'available' => true,
            ],
        ];

        foreach ($services as $service) {
            Service::create($service);
        }

        // Staff
        $staff = [
            [
                'name' => 'Hassan El Fassi',
                'role' => ['Barber Senior'],
                'specialties' => ['Barber', 'Pack'],
                'email' => 'hassan.f@bogosland.com',
                'phone' => '+212 6 70 11 22 33',
                'join_date' => '2022-03-15',
                'rating' => 4.9,
                'completed_services' => 480,
                'availability' => ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'],
                'image' => 'https://images.unsplash.com/photo-1521572163474-6864f9cf17ab?w=200',
            ],
            [
                'name' => 'Mehdi Rami',
                'role' => ['Massothérapeute Homme'],
                'specialties' => ['Massage', 'Body Care'],
                'email' => 'mehdi.r@bogosland.com',
                'phone' => '+212 6 71 22 33 44',
                'join_date' => '2022-01-10',
                'rating' => 4.8,
                'completed_services' => 530,
                'availability' => ['Monday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'],
                'image' => 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?w=200',
            ],
            [
                'name' => 'Yassine Benomar',
                'role' => ['Spécialiste Hammam Homme'],
                'specialties' => ['Hammam'],
                'email' => 'yassine.b@bogosland.com',
                'phone' => '+212 6 72 33 44 55',
                'join_date' => '2022-07-21',
                'rating' => 4.8,
                'completed_services' => 420,
                'availability' => ['Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'],
                'image' => 'https://images.unsplash.com/photo-1492562080023-ab3db95bfbce?w=200',
            ],
        ];

        foreach ($staff as $member) {
            Staff::create($member);
        }

        // Staff payout percentages per service
        $servicesByName = Service::all()->keyBy('name');
        $staffByName = Staff::all()->keyBy('name');

        $payoutMap = [
            ['service' => 'Coupe simple', 'staff' => 'Hassan El Fassi', 'percent' => 35],
            ['service' => 'Barbre', 'staff' => 'Hassan El Fassi', 'percent' => 30],
            ['service' => 'Tête + Barbre', 'staff' => 'Hassan El Fassi', 'percent' => 35],
            ['service' => 'Hammam normale', 'staff' => 'Yassine Benomar', 'percent' => 32],
            ['service' => 'Hammam complet', 'staff' => 'Yassine Benomar', 'percent' => 34],
            ['service' => 'SOIN VISAGE VAPEUR 30 MIN', 'staff' => 'Mehdi Rami', 'percent' => 28],
            ['service' => 'Massage Sportif', 'staff' => 'Mehdi Rami', 'percent' => 40],
            ['service' => 'Massage', 'staff' => 'Mehdi Rami', 'percent' => 38],
            ['service' => 'Hijama', 'staff' => 'Mehdi Rami', 'percent' => 30],
            ['service' => 'Massage préparatif+Hijama+Douche', 'staff' => 'Mehdi Rami', 'percent' => 30],
            ['service' => 'Douche+Hijama+Fouta naria', 'staff' => 'Mehdi Rami', 'percent' => 30],
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
                'name' => 'Huile à Barbe Premium',
                'category' => 'Grooming Homme',
                'price' => 24,
                'image' => 'https://images.unsplash.com/photo-1501004318641-b39e6451bec6?w=500',
                'description' => 'Nourrit la barbe et adoucit la peau.',
                'in_stock' => true,
                'rating' => 4.8,
            ],
            [
                'name' => 'Pomade Mate Forte',
                'category' => 'Coiffure Homme',
                'price' => 18,
                'image' => 'https://images.unsplash.com/photo-1519699047748-de8e457a634e?w=500',
                'description' => 'Fixation forte, finition naturelle.',
                'in_stock' => true,
                'rating' => 4.6,
            ],
            [
                'name' => 'Baume Après‑Rasage',
                'category' => 'Barbe & Rasage',
                'price' => 16,
                'image' => 'https://images.unsplash.com/photo-1521572163474-6864f9cf17ab?w=500',
                'description' => 'Apaise et hydrate après le rasage.',
                'in_stock' => true,
                'rating' => 4.7,
            ],
            [
                'name' => 'Nettoyant Visage Homme',
                'category' => 'Skincare Homme',
                'price' => 20,
                'image' => 'https://images.unsplash.com/photo-1507537297725-24a1c029d3ca?w=500',
                'description' => 'Nettoyage en profondeur sans agresser la peau.',
                'in_stock' => true,
                'rating' => 4.5,
            ],
            [
                'name' => 'Gel Anti‑Fatigue Contour',
                'category' => 'Skincare Homme',
                'price' => 22,
                'image' => 'https://images.unsplash.com/photo-1524504388940-b1c1722653e1?w=500',
                'description' => 'Réduit les signes de fatigue.',
                'in_stock' => true,
                'rating' => 4.4,
            ],
            [
                'name' => 'Kit Rasage Traditionnel',
                'category' => 'Barbe & Rasage',
                'price' => 34,
                'image' => 'https://images.unsplash.com/photo-1492562080023-ab3db95bfbce?w=500',
                'description' => 'Blaireau + savon + accessoires.',
                'in_stock' => true,
                'rating' => 4.7,
            ],
            [
                'name' => 'Gel Douche Tonifiant',
                'category' => 'Body Care',
                'price' => 14,
                'image' => 'https://images.unsplash.com/photo-1501004318641-b39e6451bec6?w=500',
                'description' => 'Fraîcheur longue durée.',
                'in_stock' => true,
                'rating' => 4.3,
            ],
            [
                'name' => 'Clay Coiffante',
                'category' => 'Coiffure Homme',
                'price' => 19,
                'image' => 'https://images.unsplash.com/photo-1515378791036-0648a3ef77b2?w=500',
                'description' => 'Texture et volume sans brillance.',
                'in_stock' => true,
                'rating' => 4.5,
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
                'name' => 'Carte 3 mois',
                'price' => 399,
                'duration' => '3 months',
                'months' => 3,
                'entries' => 12,
                'benefits' => [
                    'Carte valable 3 mois',
                    '12 entrées incluses',
                    'Priorité de réservation',
                ],
                'color' => 'primary',
                'popular' => false,
            ],
            [
                'name' => 'Carte 6 mois',
                'price' => 749,
                'duration' => '6 months',
                'months' => 6,
                'entries' => 24,
                'benefits' => [
                    'Carte valable 6 mois',
                    '24 entrées incluses',
                    'Priorité de réservation',
                ],
                'color' => 'secondary',
                'popular' => true,
            ],
            [
                'name' => 'Carte 12 mois',
                'price' => 1299,
                'duration' => '12 months',
                'months' => 12,
                'entries' => 48,
                'benefits' => [
                    'Carte valable 12 mois',
                    '48 entrées incluses',
                    'Priorité de réservation',
                    'Support VIP',
                ],
                'color' => 'accent',
                'popular' => false,
            ],
        ];

        foreach ($subscriptions as $subscription) {
            Subscription::create($subscription);
        }

        // No booking seed data
    }
}
