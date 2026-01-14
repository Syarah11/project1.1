<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('beritas', function (Blueprint $table) {
            $table->uuid('id_berita')->primary();
            $table->uuid('id_user');
            $table->string('judul');
            $table->string('slug')->unique();
            $table->text('deskripsi');
            $table->string('thumbnail');
            $table->enum('status', ['draft', 'published', 'archived'])->default('draft');
            $table->integer('view_count')->default(0);
            $table->timestamps();

            $table->foreign('id_user')->references('id_user')->on('users')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('beritas');
    }
};