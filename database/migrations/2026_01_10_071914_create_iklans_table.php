<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('iklans', function (Blueprint $table) {
            $table->uuid('id_iklan')->primary();
            $table->foreignId('id_user')->constrained('users')->onDelete('cascade');
            $table->string('nama', 255);
            $table->string('email', 255);
            $table->string('thumbnail', 255)->nullable();
            $table->string('link', 500)->nullable();
            $table->enum('status', ['pending', 'active', 'inactive'])->default('pending');
            $table->enum('posisi', ['top', 'sidebar', 'bottom', 'popup'])->nullable();
            $table->integer('urutan')->default(0);
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('update_at')->useCurrent()->useCurrentOnUpdate();
            
            $table->index('status');
            $table->index('posisi');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('iklans');
    }
};