<?php

namespace Database\Seeders;

use App\Models\Service;
use App\Models\ServiceOption;
use Illuminate\Database\Seeder;

class ServiceOptionsSeeder extends Seeder
{
    public function run(): void
    {
        // Options pour "Massage Relaxant" (supposons que c'est le service ID 1)
        $massageService = Service::where('name', 'like', '%Massage%')->first();
        
        if ($massageService) {
            ServiceOption::create([
                'service_id' => $massageService->id,
                'name' => 'Huile essentielle de lavande',
                'description' => 'Huile relaxante pour améliorer l\'expérience',
                'price' => 10.00,
                'duration' => 0,
                'is_required' => false,
                'available' => true,
                'max_quantity' => 1,
                'sort_order' => 1,
            ]);

            ServiceOption::create([
                'service_id' => $massageService->id,
                'name' => 'Extension 30 minutes',
                'description' => 'Prolongez votre massage de 30 minutes',
                'price' => 25.00,
                'duration' => 30,
                'is_required' => false,
                'available' => true,
                'max_quantity' => 2,
                'sort_order' => 2,
            ]);

            ServiceOption::create([
                'service_id' => $massageService->id,
                'name' => 'Pierres chaudes',
                'description' => 'Massage avec pierres volcaniques chaudes',
                'price' => 15.00,
                'duration' => 0,
                'is_required' => false,
                'available' => true,
                'max_quantity' => 1,
                'sort_order' => 3,
            ]);
        }

        // Options pour "Hammam"
        $hammamService = Service::where('category', 'Hammam')->first();
        
        if ($hammamService) {
            ServiceOption::create([
                'service_id' => $hammamService->id,
                'name' => 'Savon noir premium',
                'description' => 'Savon noir artisanal de qualité supérieure',
                'price' => 8.00,
                'duration' => 0,
                'is_required' => false,
                'available' => true,
                'max_quantity' => 1,
                'sort_order' => 1,
            ]);

            ServiceOption::create([
                'service_id' => $hammamService->id,
                'name' => 'Gommage au miel',
                'description' => 'Gommage naturel au miel et aux épices',
                'price' => 12.00,
                'duration' => 15,
                'is_required' => false,
                'available' => true,
                'max_quantity' => 1,
                'sort_order' => 2,
            ]);

            ServiceOption::create([
                'service_id' => $hammamService->id,
                'name' => 'Enveloppement d\'argile',
                'description' => 'Soin détoxifiant à l\'argile',
                'price' => 20.00,
                'duration' => 20,
                'is_required' => false,
                'available' => true,
                'max_quantity' => 1,
                'sort_order' => 3,
            ]);
        }

        // Options pour "Hijama"
        $hijamaService = Service::where('category', 'Hijama')->first();
        
        if ($hijamaService) {
            ServiceOption::create([
                'service_id' => $hijamaService->id,
                'name' => 'Points supplémentaires',
                'description' => 'Ajout de 2 points de cupping supplémentaires',
                'price' => 10.00,
                'duration' => 10,
                'is_required' => false,
                'available' => true,
                'max_quantity' => 3,
                'sort_order' => 1,
            ]);

            ServiceOption::create([
                'service_id' => $hijamaService->id,
                'name' => 'Consultation approfondie',
                'description' => 'Bilan de santé complet avant la séance',
                'price' => 15.00,
                'duration' => 15,
                'is_required' => false,
                'available' => true,
                'max_quantity' => 1,
                'sort_order' => 2,
            ]);
        }

        $this->command->info('Service options seeded successfully!');
    }
}
