<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('beritas', function (Blueprint $table) {
            $table->uuid('id_berita')->primary();

            $table->foreignId('user_id')->constrained()->cascadeOnDelete();

            $table->string('judul');
            $table->string('slug');
            $table->text('deskripsi');
            $table->string('thumbnail')->nullable();
            $table->enum('status', ['draft', 'publish'])->default('draft');
            $table->integer('view_count')->default(0);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('beritas');
    }
};
