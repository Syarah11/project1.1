<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
      Schema::create('gambar_ejurnals', function (Blueprint $table) {
    $table->id();
    $table->uuid('ejurnal_id'); // ⬅️ pakai uuid bukan foreignId
    $table->string('image')->nullable();
    $table->timestamps();

    $table->foreign('ejurnal_id')
        ->references('id')
        ->on('ejurnals')
        ->cascadeOnDelete();
});

    }

    public function down(): void
    {
        Schema::dropIfExists('gambar_ejurnals');
    }
};
