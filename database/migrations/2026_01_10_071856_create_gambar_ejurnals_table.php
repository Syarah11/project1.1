<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('gambar_ejurnals', function (Blueprint $table) {
            $table->uuid('id_gambar_ejurnal')->primary();
            $table->uuid('id_ejurnal');
            $table->uuid('id_user');
            $table->string('gambar');
            $table->timestamps();

            $table->foreign('id_ejurnal')->references('id_ejurnal')->on('ejurnals')->onDelete('cascade');
            $table->foreign('id_user')->references('id_user')->on('users')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('gambar_ejurnals');
    }
};