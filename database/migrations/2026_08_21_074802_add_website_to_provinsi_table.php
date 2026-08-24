<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('provinsi', function (Blueprint $table) {
            $table->string('website')->nullable()->after('urutan'); // URL website resmi provinsi
        });
    }

    public function down(): void
    {
        Schema::table('provinsi', function (Blueprint $table) {
            $table->dropColumn('website');
        });
    }
};
