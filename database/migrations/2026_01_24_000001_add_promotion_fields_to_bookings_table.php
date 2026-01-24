<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->decimal('original_price', 10, 2)->nullable()->after('price');
            $table->decimal('discount_amount', 10, 2)->default(0)->after('original_price');
            $table->foreignId('promotion_id')->nullable()->after('discount_amount')->constrained('promotions')->nullOnDelete();
            $table->string('promotion_code')->nullable()->after('promotion_id');
        });
    }

    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropConstrainedForeignId('promotion_id');
            $table->dropColumn(['original_price', 'discount_amount', 'promotion_code']);
        });
    }
};

