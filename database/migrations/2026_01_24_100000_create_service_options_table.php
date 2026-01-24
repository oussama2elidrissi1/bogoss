<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('service_options', function (Blueprint $table) {
            $table->id();
            $table->foreignId('service_id')->constrained()->onDelete('cascade');
            $table->string('name'); // Ex: "Huile essentielle", "Zone supplémentaire"
            $table->text('description')->nullable();
            $table->decimal('price', 10, 2)->default(0); // Prix additionnel
            $table->integer('duration')->default(0); // Durée additionnelle en minutes
            $table->boolean('is_required')->default(false); // Option obligatoire ?
            $table->boolean('available')->default(true);
            $table->integer('max_quantity')->default(1); // Quantité max sélectionnable
            $table->integer('sort_order')->default(0); // Ordre d'affichage
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('service_options');
    }
};
