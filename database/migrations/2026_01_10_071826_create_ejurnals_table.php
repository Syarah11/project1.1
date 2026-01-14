<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ejurnals', function (Blueprint $table) {
            $table->uuid('id_ejurnal')->primary();
            $table->uuid('id_user');
            $table->string('judul');
            $table->text('deskripsi');
            $table->timestamps();

            $table->foreign('id_user')->references('id_user')->on('users')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ejurnals');
    }
};