<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained()->onDelete('cascade');
            $table->string('client_name');
            $table->foreignId('service_id')->constrained()->onDelete('cascade');
            $table->string('service');
            $table->foreignId('staff_id')->nullable()->constrained()->onDelete('set null');
            $table->string('staff_name')->nullable();
            $table->date('date');
            $table->time('time');
            $table->integer('duration');
            $table->decimal('price', 10, 2);
            $table->string('status')->default('pending');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
