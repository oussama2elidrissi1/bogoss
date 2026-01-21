<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->decimal('staff_payout_percentage', 5, 2)->nullable()->after('commission_amount');
            $table->decimal('staff_payout_amount', 10, 2)->nullable()->after('staff_payout_percentage');
        });
    }

    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn(['staff_payout_percentage', 'staff_payout_amount']);
        });
    }
};
