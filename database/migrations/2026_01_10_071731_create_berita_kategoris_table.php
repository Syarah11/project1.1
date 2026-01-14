<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// Migration untuk berita_kategoris
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('berita_kategoris', function (Blueprint $table) {
            $table->uuid('id_berita_kategori')->primary();
            $table->uuid('id_berita');
            $table->uuid('id_kategori');
            $table->timestamps();

            $table->foreign('id_berita')->references('id_berita')->on('beritas')->onDelete('cascade');
            $table->foreign('id_kategori')->references('id_kategori')->on('kategoris')->onDelete('cascade');
            
            $table->unique(['id_berita', 'id_kategori']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('berita_kategoris');
    }
};