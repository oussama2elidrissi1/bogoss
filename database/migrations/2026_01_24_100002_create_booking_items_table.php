<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('booking_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('booking_id')->constrained()->onDelete('cascade');
            $table->foreignId('service_id')->constrained()->onDelete('cascade');
            $table->string('service_name'); // Dénormalisé pour historique
            $table->foreignId('staff_id')->nullable()->constrained()->onDelete('set null');
            $table->string('staff_name')->nullable();
            $table->integer('quantity')->default(1); // Pour gérer plusieurs fois le même service
            $table->decimal('unit_price', 10, 2); // Prix unitaire du service
            $table->integer('duration'); // Durée du service (en minutes)
            $table->decimal('options_total', 10, 2)->default(0); // Total des options
            $table->decimal('subtotal', 10, 2); // (unit_price + options_total) * quantity
            $table->decimal('discount_amount', 10, 2)->default(0); // Réduction appliquée
            $table->decimal('total', 10, 2); // Subtotal - discount_amount
            $table->foreignId('promotion_id')->nullable()->constrained()->onDelete('set null');
            $table->string('promotion_code')->nullable();
            $table->decimal('staff_payout_percentage', 5, 2)->default(0);
            $table->decimal('staff_payout_amount', 10, 2)->default(0);
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('booking_items');
    }
};
