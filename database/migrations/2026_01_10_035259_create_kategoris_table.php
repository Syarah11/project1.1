<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kategoris', function (Blueprint $table) {
            $table->uuid('id_kategori')->primary();
            $table->string('nama_kategori', 255);
            $table->string('slug', 255)->unique();
            $table->text('deskripsi')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('update_at')->useCurrent()->useCurrentOnUpdate();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kategoris');
    }
};