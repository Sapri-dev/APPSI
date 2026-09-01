<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        try {
            DB::statement('ALTER TABLE pustaka MODIFY COLUMN kategori VARCHAR(255) NOT NULL');
        } catch (\Throwable $e) {
            // Fallback for sqlite / other drivers
            Schema::table('pustaka', function (Blueprint $table) {
                $table->string('kategori')->change();
            });
        }
    }

    public function down(): void
    {
        //
    }
};
