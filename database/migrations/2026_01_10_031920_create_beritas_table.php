<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('beritas', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('user_id')              // ← Dari 'id_user'
                  ->constrained('users')
                  ->onDelete('cascade');
            $table->string('title');                    // ← Dari 'judul'
            $table->string('slug')->unique();
            $table->text('description');                // ← Dari 'deskripsi'
            $table->string('thumbnail')->nullable();
            $table->enum('status', ['published', 'draft'])->default('draft');
            $table->integer('view_count')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('beritas');
    }
    
};