<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('berita_tags', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('berita_id')
                  ->constrained('beritas')
                  ->onDelete('cascade');
            $table->foreignUuid('tag_id')
                  ->constrained('tags')
                  ->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('berita_tags');
    }
};