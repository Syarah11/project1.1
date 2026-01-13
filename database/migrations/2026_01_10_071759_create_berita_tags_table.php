<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('berita_tags', function (Blueprint $table) {
            $table->uuid('id_berita_tag')->primary();
            $table->uuid('id_berita');
            $table->uuid('id_tag');
            
            $table->foreign('id_berita')->references('id_berita')->on('beritas')->onDelete('cascade');
            $table->foreign('id_tag')->references('id_tag')->on('tags')->onDelete('cascade');
            
            $table->unique(['id_berita', 'id_tag']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('berita_tags');
    }
};