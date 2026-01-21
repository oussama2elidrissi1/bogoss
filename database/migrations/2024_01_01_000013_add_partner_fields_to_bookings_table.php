<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->foreignId('partner_id')->nullable()->after('client_id')->constrained('partners')->nullOnDelete();
            $table->string('partner_name')->nullable()->after('partner_id');
            $table->decimal('commission_rate', 5, 2)->nullable()->after('price');
            $table->decimal('commission_amount', 10, 2)->nullable()->after('commission_rate');
            $table->timestamp('commission_paid_at')->nullable()->after('notes');
        });
    }

    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn(['partner_id', 'partner_name', 'commission_rate', 'commission_amount', 'commission_paid_at']);
        });
    }
};
