<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Vérifier les contraintes de clés étrangères existantes
        $foreignKeys = DB::select("
            SELECT CONSTRAINT_NAME 
            FROM information_schema.TABLE_CONSTRAINTS 
            WHERE TABLE_SCHEMA = DATABASE() 
            AND TABLE_NAME = 'bookings' 
            AND CONSTRAINT_TYPE = 'FOREIGN KEY'
        ");
        
        $foreignKeyNames = array_map(fn($fk) => $fk->CONSTRAINT_NAME, $foreignKeys);
        
        Schema::table('bookings', function (Blueprint $table) use ($foreignKeyNames) {
            // Supprimer les contraintes de clés étrangères si elles existent
            if (in_array('bookings_service_id_foreign', $foreignKeyNames)) {
                $table->dropForeign(['service_id']);
            }
            if (in_array('bookings_staff_id_foreign', $foreignKeyNames)) {
                $table->dropForeign(['staff_id']);
            }
        });
        
        // Supprimer les colonnes spécifiques à un service unique
        Schema::table('bookings', function (Blueprint $table) {
            $columnsToCheck = [
                'service_id', 
                'service', 
                'staff_id', 
                'staff_name',
                'duration', 
                'price', 
                'original_price', 
                'discount_amount',
                'commission_rate',
                'commission_amount',
                'staff_payout_percentage',
                'staff_payout_amount',
                'commission_paid_at'
            ];
            
            $columnsToDrop = [];
            foreach ($columnsToCheck as $column) {
                if (Schema::hasColumn('bookings', $column)) {
                    $columnsToDrop[] = $column;
                }
            }
            
            if (!empty($columnsToDrop)) {
                $table->dropColumn($columnsToDrop);
            }
        });
    }

    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->foreignId('service_id')->constrained()->onDelete('cascade');
            $table->string('service');
            $table->foreignId('staff_id')->nullable()->constrained()->onDelete('set null');
            $table->string('staff_name')->nullable();
            $table->integer('duration');
            $table->decimal('price', 10, 2);
            $table->decimal('original_price', 10, 2)->nullable();
            $table->decimal('discount_amount', 10, 2)->nullable();
            
            $table->dropColumn([
                'booking_reference',
                'subtotal',
                'discount_total',
                'total',
                'total_duration',
                'payment_status',
                'payment_method'
            ]);
        });
    }
};
