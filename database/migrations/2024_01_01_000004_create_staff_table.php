<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('staff', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('role');
            $table->json('specialties');
            $table->string('email')->unique();
            $table->string('phone');
            $table->date('join_date');
            $table->decimal('rating', 3, 1)->default(0);
            $table->integer('completed_services')->default(0);
            $table->json('availability');
            $table->string('image')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('staff');
    }
};
