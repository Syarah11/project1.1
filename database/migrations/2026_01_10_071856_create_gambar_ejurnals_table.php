<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('gambar_ejurnals', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('ejurnal_id')
                  ->constrained('ejurnals')
                  ->onDelete('cascade');
            $table->foreignUuid('user_id')
                  ->constrained('users')
                  ->onDelete('cascade');
            $table->string('image');                    // ← Dari 'gambar'
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('gambar_ejurnals');
    }
};