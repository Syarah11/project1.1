<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
       Schema::create('berita_kategoris', function (Blueprint $table) {
    $table->foreignUuid('berita_id')->constrained('beritas')->cascadeOnDelete();
    $table->foreignUuid('kategori_id')->constrained('kategoris')->cascadeOnDelete();
    $table->primary(['berita_id','kategori_id']);
});

    }

    public function down(): void
    {
        Schema::dropIfExists('berita_kategoris');
    }
};