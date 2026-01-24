<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('booking_item_options', function (Blueprint $table) {
            $table->id();
            $table->foreignId('booking_item_id')->constrained()->onDelete('cascade');
            $table->foreignId('service_option_id')->constrained()->onDelete('cascade');
            $table->string('option_name'); // Dénormalisé pour historique
            $table->integer('quantity')->default(1); // Quantité de cette option
            $table->decimal('unit_price', 10, 2); // Prix unitaire de l'option
            $table->integer('duration')->default(0); // Durée additionnelle de l'option
            $table->decimal('total', 10, 2); // unit_price * quantity
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('booking_item_options');
    }
};
