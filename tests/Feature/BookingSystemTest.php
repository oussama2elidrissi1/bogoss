<?php

namespace Tests\Feature;

use App\Models\Client;
use App\Models\Service;
use App\Models\ServiceOption;
use App\Models\Staff;
use App\Models\User;
use App\Services\BookingService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookingSystemTest extends TestCase
{
    use RefreshDatabase;

    private User $user;
    private Client $client;
    private Service $service1;
    private Service $service2;
    private ServiceOption $option1;
    private ServiceOption $option2;
    private Staff $staff;

    protected function setUp(): void
    {
        parent::setUp();

        // Créer un utilisateur
        $this->user = User::factory()->create([
            'email' => 'test@example.com',
            'name' => 'Test User',
        ]);

        // Créer un client
        $this->client = Client::create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'phone' => '1234567890',
            'join_date' => now()->toDateString(),
        ]);

        // Créer des services
        $this->service1 = Service::create([
            'name' => 'Massage Relaxant',
            'category' => 'Soins',
            'description' => 'Un massage relaxant',
            'price' => 50.00,
            'duration' => 60,
            'available' => true,
        ]);

        $this->service2 = Service::create([
            'name' => 'Hammam Traditionnel',
            'category' => 'Hammam',
            'description' => 'Hammam traditionnel',
            'price' => 40.00,
            'duration' => 45,
            'available' => true,
        ]);

        // Créer des options
        $this->option1 = ServiceOption::create([
            'service_id' => $this->service1->id,
            'name' => 'Huile essentielle',
            'price' => 10.00,
            'duration' => 0,
            'is_required' => false,
            'available' => true,
            'max_quantity' => 1,
        ]);

        $this->option2 = ServiceOption::create([
            'service_id' => $this->service1->id,
            'name' => 'Extension 30min',
            'price' => 25.00,
            'duration' => 30,
            'is_required' => false,
            'available' => true,
            'max_quantity' => 2,
        ]);

        // Créer un staff
        $this->staff = Staff::create([
            'name' => 'Marie Leblanc',
            'email' => 'marie@example.com',
            'phone' => '0987654321',
            'specialization' => 'Massage',
            'availability' => ['Monday', 'Tuesday', 'Wednesday'],
        ]);

        // Associer le staff au service avec un payout
        $this->service1->staff()->attach($this->staff->id, ['payout_percentage' => 60]);
    }

    /** @test */
    public function it_can_calculate_cart_totals_without_options()
    {
        $bookingService = app(BookingService::class);

        $totals = $bookingService->calculateCartTotals([
            [
                'service_id' => $this->service1->id,
                'quantity' => 1,
            ],
        ]);

        $this->assertEquals(50.00, $totals['subtotal']);
        $this->assertEquals(50.00, $totals['total']);
        $this->assertEquals(60, $totals['total_duration']);
    }

    /** @test */
    public function it_can_calculate_cart_totals_with_options()
    {
        $bookingService = app(BookingService::class);

        $totals = $bookingService->calculateCartTotals([
            [
                'service_id' => $this->service1->id,
                'quantity' => 1,
                'options' => [
                    ['option_id' => $this->option1->id, 'quantity' => 1],
                    ['option_id' => $this->option2->id, 'quantity' => 1],
                ],
            ],
        ]);

        // 50 (service) + 10 (option1) + 25 (option2) = 85
        $this->assertEquals(85.00, $totals['subtotal']);
        $this->assertEquals(85.00, $totals['total']);
        // 60 (service) + 0 (option1) + 30 (option2) = 90
        $this->assertEquals(90, $totals['total_duration']);
    }

    /** @test */
    public function it_can_create_a_booking_with_multiple_items()
    {
        $bookingService = app(BookingService::class);

        $booking = $bookingService->createBooking([
            'date' => now()->addDays(3)->toDateString(),
            'time' => '14:00',
            'notes' => 'Test booking',
            'items' => [
                [
                    'service_id' => $this->service1->id,
                    'staff_id' => $this->staff->id,
                    'quantity' => 1,
                    'options' => [
                        ['option_id' => $this->option1->id, 'quantity' => 1],
                    ],
                ],
                [
                    'service_id' => $this->service2->id,
                    'quantity' => 1,
                ],
            ],
        ], $this->client);

        $this->assertNotNull($booking);
        $this->assertNotNull($booking->booking_reference);
        $this->assertEquals(2, $booking->items->count());
        
        // Premier item
        $item1 = $booking->items->first();
        $this->assertEquals(50.00, $item1->unit_price);
        $this->assertEquals(10.00, $item1->options_total);
        $this->assertEquals(60.00, $item1->subtotal);
        $this->assertEquals(1, $item1->options->count());
        
        // Staff payout (60% de 50€ = 30€)
        $this->assertEquals(30.00, $item1->staff_payout_amount);

        // Deuxième item
        $item2 = $booking->items->last();
        $this->assertEquals(40.00, $item2->unit_price);
        $this->assertEquals(0, $item2->options->count());

        // Totaux de la réservation
        $this->assertEquals(100.00, $booking->subtotal); // 60 + 40
        $this->assertEquals(100.00, $booking->total);
    }

    /** @test */
    public function it_validates_that_options_belong_to_service()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage("n'appartient pas au service");

        $bookingService = app(BookingService::class);

        // Essayer d'ajouter l'option du service1 au service2
        $bookingService->createBooking([
            'date' => now()->addDays(3)->toDateString(),
            'time' => '14:00',
            'items' => [
                [
                    'service_id' => $this->service2->id,
                    'quantity' => 1,
                    'options' => [
                        ['option_id' => $this->option1->id, 'quantity' => 1],
                    ],
                ],
            ],
        ], $this->client);
    }

    /** @test */
    public function it_can_retrieve_services_with_options_via_api()
    {
        $response = $this->actingAs($this->user)
            ->getJson('/api/services');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'name',
                        'category',
                        'price',
                        'duration',
                        'available',
                        'options' => [
                            '*' => [
                                'id',
                                'name',
                                'price',
                                'duration',
                                'is_required',
                                'max_quantity',
                            ],
                        ],
                    ],
                ],
            ]);
    }

    /** @test */
    public function it_can_calculate_cart_via_api()
    {
        $response = $this->actingAs($this->user)
            ->postJson('/api/bookings/calculate', [
                'items' => [
                    [
                        'service_id' => $this->service1->id,
                        'quantity' => 1,
                        'options' => [
                            ['option_id' => $this->option1->id, 'quantity' => 1],
                        ],
                    ],
                ],
            ]);

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
            ])
            ->assertJsonStructure([
                'data' => [
                    'subtotal',
                    'discount_total',
                    'total',
                    'total_duration',
                    'items',
                ],
            ]);

        $data = $response->json('data');
        $this->assertEquals(60.00, $data['subtotal']);
    }

    /** @test */
    public function it_can_create_booking_via_api()
    {
        $response = $this->actingAs($this->user)
            ->postJson('/api/bookings', [
                'date' => now()->addDays(5)->toDateString(),
                'time' => '15:00',
                'notes' => 'API test booking',
                'items' => [
                    [
                        'service_id' => $this->service1->id,
                        'staff_id' => $this->staff->id,
                        'quantity' => 1,
                        'options' => [
                            ['option_id' => $this->option1->id, 'quantity' => 1],
                        ],
                    ],
                ],
            ]);

        $response->assertStatus(201)
            ->assertJson([
                'success' => true,
            ])
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'booking_reference',
                    'client',
                    'date',
                    'time',
                    'totals',
                    'items',
                ],
            ]);

        $this->assertDatabaseHas('bookings', [
            'client_id' => $this->client->id,
            'date' => now()->addDays(5)->toDateString(),
            'time' => '15:00',
        ]);
    }

    /** @test */
    public function it_requires_authentication_for_booking_creation()
    {
        $response = $this->postJson('/api/bookings', [
            'date' => now()->addDays(3)->toDateString(),
            'time' => '14:00',
            'items' => [
                ['service_id' => $this->service1->id, 'quantity' => 1],
            ],
        ]);

        $response->assertStatus(401);
    }

    /** @test */
    public function it_validates_required_fields()
    {
        $response = $this->actingAs($this->user)
            ->postJson('/api/bookings', [
                // Manque date, time, items
            ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['date', 'time', 'items']);
    }

    /** @test */
    public function it_validates_service_availability()
    {
        // Rendre le service indisponible
        $this->service1->update(['available' => false]);

        $response = $this->actingAs($this->user)
            ->postJson('/api/bookings', [
                'date' => now()->addDays(3)->toDateString(),
                'time' => '14:00',
                'items' => [
                    ['service_id' => $this->service1->id, 'quantity' => 1],
                ],
            ]);

        $response->assertStatus(422);
    }

    /** @test */
    public function it_calculates_multiple_quantities_correctly()
    {
        $bookingService = app(BookingService::class);

        $totals = $bookingService->calculateCartTotals([
            [
                'service_id' => $this->service1->id,
                'quantity' => 2,
                'options' => [
                    ['option_id' => $this->option1->id, 'quantity' => 2],
                ],
            ],
        ]);

        // (50 + 10) * 2 = 120
        $this->assertEquals(120.00, $totals['subtotal']);
        $this->assertEquals(120, $totals['total_duration']); // 60 * 2
    }
}
