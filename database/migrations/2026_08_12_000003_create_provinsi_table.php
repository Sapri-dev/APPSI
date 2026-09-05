<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('provinsi', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('ibu_kota')->nullable();
            $table->string('gubernur')->nullable();
            $table->string('lambang')->nullable(); // path storage
            $table->string('pulau')->nullable(); // Jawa, Sumatera, Kalimantan, dll
            $table->unsignedSmallInteger('urutan')->default(0);
            $table->string('website')->nullable(); // URL website resmi provinsi
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('provinsi');
    }
};
