<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('berita_kategoris', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('berita_id')            // ← Dari 'id_berita'
                  ->constrained('beritas')
                  ->onDelete('cascade');
            $table->foreignUuid('kategori_id')          // ← Dari 'id_kategori'
                  ->constrained('kategoris')
                  ->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('berita_kategoris');
    }
};