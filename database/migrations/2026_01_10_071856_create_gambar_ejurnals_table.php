<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('gambar_ejurnals', function (Blueprint $table) {
            // Primary Key
            $table->id();
            
            // Foreign Keys
            $table->uuid('ejurnal_id');
            $table->foreignUuid('user_id')
                  ->constrained('users')
                  ->onDelete('cascade');
            
            // Image Path
            $table->string('image')->nullable();
            
            // Timestamps
            $table->timestamps();
            
            // Foreign Key Constraint untuk ejurnal_id
            $table->foreign('ejurnal_id')
                  ->references('id')
                  ->on('ejurnals')
                  ->onDelete('cascade');
            
            // Indexes
            $table->index('ejurnal_id');
            $table->index('user_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gambar_ejurnals');
    }
};