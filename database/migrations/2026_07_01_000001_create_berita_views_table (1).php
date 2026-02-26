<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('berita_views', function (Blueprint $table) {
            $table->id();

            // Pakai uuid() biasa TANPA ->constrained()
            // Alasan: foreignUuid()->constrained() menyebabkan error jika
            // urutan migration tidak tepat, yang mengakibatkan semua migration
            // setelahnya (kategori, tag, dll) ikut gagal / rollback.
            $table->uuid('berita_id');

            $table->timestamp('viewed_at')->useCurrent();

            $table->index(['viewed_at']);
            $table->index(['berita_id', 'viewed_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('berita_views');
    }
};
