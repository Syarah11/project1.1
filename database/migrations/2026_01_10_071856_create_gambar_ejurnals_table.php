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
            $table->foreignId('id_user')->constrained('users')->onDelete('cascade');
            $table->string('gambar', 255);
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('update_at')->useCurrent()->useCurrentOnUpdate();
            
            $table->foreign('id_ejurnal')->references('id_ejurnal')->on('ejurnals')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('gambar_ejurnals');
    }
};