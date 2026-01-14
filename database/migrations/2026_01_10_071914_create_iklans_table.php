<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('iklans', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('user_id')
                  ->constrained('users')
                  ->onDelete('cascade');
            $table->string('name');                     // ← Dari 'nama'
            $table->string('thumbnail')->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->string('link')->nullable();
            $table->enum('position', ['top', 'bottom', 'sidebar'])->default('top'); // ← Dari 'posisi'
            $table->integer('priority')->default(0);    // ← Dari 'urutan'
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('iklans');
    }
};