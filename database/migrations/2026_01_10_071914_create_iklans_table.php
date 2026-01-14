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
            $table->uuid('id_user');
            $table->string('nama');
            $table->string('thumbnail');
            $table->string('link');
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->enum('posisi', ['top', 'sidebar', 'bottom', 'popup'])->default('sidebar');
            $table->integer('urutan')->default(0);
            $table->timestamps();

            $table->foreign('id_user')->references('id_user')->on('users')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('iklans');
    }
};