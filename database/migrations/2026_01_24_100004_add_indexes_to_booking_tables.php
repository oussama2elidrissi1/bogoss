<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Ajouter des index pour améliorer les performances
        Schema::table('bookings', function (Blueprint $table) {
            $table->index('booking_reference');
            $table->index(['client_id', 'date']);
            $table->index('status');
            $table->index('payment_status');
        });

        Schema::table('booking_items', function (Blueprint $table) {
            $table->index(['booking_id', 'service_id']);
            $table->index('staff_id');
        });

        Schema::table('booking_item_options', function (Blueprint $table) {
            $table->index('booking_item_id');
        });

        Schema::table('service_options', function (Blueprint $table) {
            $table->index(['service_id', 'available']);
            $table->index('sort_order');
        });
    }

    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropIndex(['booking_reference']);
            $table->dropIndex(['client_id', 'date']);
            $table->dropIndex(['status']);
            $table->dropIndex(['payment_status']);
        });

        Schema::table('booking_items', function (Blueprint $table) {
            $table->dropIndex(['booking_id', 'service_id']);
            $table->dropIndex(['staff_id']);
        });

        Schema::table('booking_item_options', function (Blueprint $table) {
            $table->dropIndex(['booking_item_id']);
        });

        Schema::table('service_options', function (Blueprint $table) {
            $table->dropIndex(['service_id', 'available']);
            $table->dropIndex(['sort_order']);
        });
    }
};
