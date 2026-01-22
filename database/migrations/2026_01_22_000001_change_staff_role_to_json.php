<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('staff', function (Blueprint $table) {
            $table->json('role_tmp')->nullable()->after('role');
        });

        DB::table('staff')->orderBy('id')->chunkById(100, function ($rows) {
            foreach ($rows as $row) {
                $role = $row->role ? [$row->role] : [];
                DB::table('staff')->where('id', $row->id)->update([
                    'role_tmp' => json_encode($role),
                ]);
            }
        });

        DB::statement('ALTER TABLE staff DROP COLUMN role');
        DB::statement('ALTER TABLE staff CHANGE role_tmp role JSON');
    }

    public function down(): void
    {
        Schema::table('staff', function (Blueprint $table) {
            $table->string('role_tmp')->nullable()->after('role');
        });

        DB::table('staff')->orderBy('id')->chunkById(100, function ($rows) {
            foreach ($rows as $row) {
                $role = json_decode($row->role ?? '[]', true);
                $firstRole = is_array($role) ? ($role[0] ?? null) : null;
                DB::table('staff')->where('id', $row->id)->update([
                    'role_tmp' => $firstRole,
                ]);
            }
        });

        DB::statement('ALTER TABLE staff DROP COLUMN role');
        DB::statement('ALTER TABLE staff CHANGE role_tmp role VARCHAR(255)');
    }
};
