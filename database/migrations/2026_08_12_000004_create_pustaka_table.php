<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pustaka', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->string('file')->nullable(); // path storage
            $table->string('file_url')->nullable(); // URL eksternal sebagai fallback
            $table->enum('kategori', ['uu', 'adart', 'rekomendasi', 'sk', 'berita_acara', 'data_bps']);
            $table->year('tahun')->nullable();
            $table->text('deskripsi')->nullable();
            $table->unsignedBigInteger('unduhan')->default(0);
            $table->boolean('is_published')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pustaka');
    }
};
