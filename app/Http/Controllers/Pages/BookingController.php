<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Client;
use App\Models\Promotion;
use App\Models\Service;
use App\Models\Staff;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    private function bestPromotionForService(Service $service, $promotions): array
    {
        $best = null;
        $bestDiscount = 0.0;

        foreach ($promotions as $promotion) {
            $applicable = is_array($promotion->applicable_services)
                ? $promotion->applicable_services
                : json_decode($promotion->applicable_services ?? '[]', true);
            $applicable = is_array($applicable) ? $applicable : [];

            $isApplicable = false;
            foreach ($applicable as $x) {
                if (is_numeric($x) && (int) $x === (int) $service->id) {
                    $isApplicable = true;
                    break;
                }
                if (is_string($x) && ($x === $service->category || $x === (string) $service->id)) {
                    $isApplicable = true;
                    break;
                }
            }
            if (!$isApplicable) {
                continue;
            }

            $amount = 0.0;
            if ($promotion->type === 'percentage') {
                $amount = ((float) $service->price) * ((float) $promotion->discount) / 100;
            } else {
                $amount = (float) $promotion->discount;
            }
            $amount = max(0.0, min($amount, (float) $service->price));

            if ($amount > $bestDiscount) {
                $bestDiscount = $amount;
                $best = $promotion;
            }
        }

        return [
            'promotion' => $best,
            'discount_amount' => $bestDiscount,
        ];
    }

    public function index(Request $request)
    {
        $category = $request->get('category', 'All');
        $serviceId = $request->get('service_id');
        $serviceIds = $request->input('service_ids', []);
        $date = $request->get('date', now()->toDateString());

        $selectedDate = Carbon::parse($date);

        $servicesQuery = Service::with('availableOptions')->where('available', true);
        if ($category !== 'All') {
            $servicesQuery->where('category', $category);
        }

        $services = $servicesQuery->orderBy('name')->get();
        $categories = Service::query()->select('category')->distinct()->orderBy('category')->pluck('category');

        $selectedService = null;
        if ($serviceId) {
            $selectedService = Service::with('availableOptions')->where('available', true)->find($serviceId);
        }

        $prefillServices = collect([]);
        if (is_array($serviceIds) && count($serviceIds) > 0) {
            $ids = collect($serviceIds)->map(fn ($v) => (int) $v)->filter(fn ($v) => $v > 0)->values();
            if ($ids->count() > 0) {
                $prefillServices = Service::query()
                    ->with('availableOptions')
                    ->where('available', true)
                    ->whereIn('id', $ids->all())
                    ->get()
                    ->values();
            }
        } elseif ($selectedService) {
            $prefillServices = collect([$selectedService]);
        }

        $prefillData = $prefillServices
            ->map(fn (Service $s) => [
                'id' => (string) $s->id,
                'name' => $s->name,
                'price' => (float) $s->price,
                'duration' => (int) $s->duration,
            ])
            ->values();

        $groupDefs = [
            [
                'key' => 'hammam',
                'title' => 'Hammam',
                'icon' => '🧖‍♂️',
                'variants' => $services
                    ->where('category', 'Hammam')
                    ->filter(fn ($s) => stripos($s->name, 'hammam') !== false)
                    ->load('availableOptions')
                    ->values(),
            ],
            [
                'key' => 'massage',
                'title' => 'Massage',
                'icon' => '💆‍♂️',
                'variants' => $services
                    ->where('category', 'Soins')
                    ->filter(fn ($s) => stripos($s->name, 'massage') !== false)
                    ->load('availableOptions')
                    ->values(),
            ],
            [
                'key' => 'hijama',
                'title' => 'Hijama',
                'icon' => '🩺',
                'variants' => $services
                    ->where('category', 'Hijama')
                    ->filter(fn ($s) => stripos($s->name, 'hijama') !== false)
                    ->load('availableOptions')
                    ->values(),
            ],
        ];

        $variantIds = collect($groupDefs)
            ->flatMap(fn ($g) => $g['variants']->pluck('id'))
            ->unique()
            ->values();

        $catalogServices = $services->whereNotIn('id', $variantIds->all())->values();

        $dateBookings = Booking::whereDate('date', $selectedDate)->orderBy('time')->get();

        $dayName = $selectedDate->format('l');
        $availableStaff = Staff::all()->filter(function ($staff) use ($dayName) {
            $availability = is_array($staff->availability) ? $staff->availability : json_decode($staff->availability ?? '[]', true);
            return in_array($dayName, $availability ?? [], true);
        });

        $timeSlots = [
            '09:00', '09:30', '10:00', '10:30', '11:00', '11:30',
            '12:00', '12:30', '14:00', '14:30', '15:00', '15:30',
            '16:00', '16:30', '17:00', '17:30', '18:00', '18:30',
        ];

        return view('pages.booking-new', [
            'services' => $catalogServices,
            'categories' => $categories,
            'selectedCategory' => $category,
            'selectedService' => $selectedService,
            'selectedDate' => $selectedDate,
            'dateBookings' => $dateBookings,
            'availableStaff' => $availableStaff,
            'timeSlots' => $timeSlots,
            'serviceGroups' => $groupDefs,
            'prefillServices' => $prefillServices,
            'prefillData' => $prefillData,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'service_id' => ['nullable', 'exists:services,id'],
            'service_ids' => ['nullable', 'array'],
            'service_ids.*' => ['exists:services,id'],
            'date' => ['required', 'date', 'after_or_equal:today'],
            'time' => ['required'],
            'staff_id' => ['nullable', 'exists:staff,id'],
            'notes' => ['nullable', 'string', 'max:1000'],
        ]);

        $serviceIds = $request->input('service_ids', []);
        if (empty($serviceIds) && $request->filled('service_id')) {
            $serviceIds = [$request->service_id];
        }
        if (empty($serviceIds)) {
            return back()->withErrors(['service_ids' => 'Please select at least one service.']);
        }

        $services = Service::whereIn('id', $serviceIds)->get();
        if ($services->count() !== count($serviceIds)) {
            return back()->withErrors(['service_ids' => 'Some selected services are invalid.']);
        }

        $today = now()->toDateString();
        $activePromotions = Promotion::query()
            ->where('status', 'active')
            ->whereDate('valid_from', '<=', $today)
            ->whereDate('valid_until', '>=', $today)
            ->get();

        $staff = $request->staff_id ? Staff::find($request->staff_id) : null;
        $user = Auth::user();
        $client = Client::firstOrCreate(
            ['email' => $user->email],
            [
                'name' => $user->name,
                'phone' => $user->phone ?? 'N/A',
                'join_date' => now()->toDateString(),
            ]
        );

        foreach ($services as $service) {
            $promoCalc = $this->bestPromotionForService($service, $activePromotions);
            $promotion = $promoCalc['promotion'];
            $discountAmount = (float) $promoCalc['discount_amount'];
            $originalPrice = (float) $service->price;
            $finalPrice = max(0.0, $originalPrice - $discountAmount);

            $staffPayoutPercent = 0;
            $staffPayoutAmount = 0;
            if ($staff) {
                $staffPayoutPercent = $service->staff()
                    ->where('staff_id', $staff->id)
                    ->first()
                    ?->pivot
                    ?->payout_percentage ?? 0;
                $staffPayoutAmount = round(($finalPrice * $staffPayoutPercent) / 100, 2);
            }

            Booking::create([
                'client_id' => $client->id,
                'client_name' => $client->name,
                'service_id' => $service->id,
                'service' => $service->name,
                'staff_id' => $staff?->id,
                'staff_name' => $staff?->name,
                'date' => $request->date,
                'time' => $request->time,
                'duration' => $service->duration,
                'price' => $finalPrice,
                'original_price' => $originalPrice,
                'discount_amount' => $discountAmount,
                'promotion_id' => $promotion?->id,
                'promotion_code' => $promotion?->code,
                'status' => 'pending',
                'notes' => $request->notes,
                'staff_payout_percentage' => $staffPayoutPercent,
                'staff_payout_amount' => $staffPayoutAmount,
            ]);
        }

        return redirect()->route('booking', [
            'date' => $request->date,
        ])->with('success', 'Booking request submitted successfully.');
    }
}
