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
        Schema::create('ejurnals', function (Blueprint $table) {
            // Primary Key
            $table->uuid('id')->primary();
            
            // Foreign Key - User
            $table->foreignUuid('user_id')
                  ->constrained('users')
                  ->onDelete('cascade');
            
            // Content Fields
            $table->string('title', 500);
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            
            // Media Fields
            $table->string('thumbnail')->nullable();
            
            // Status
            $table->enum('status', ['draft', 'published'])->default('published');
            
            // Timestamps
            $table->timestamps();
            
            // Indexes untuk performance
            $table->index('status');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ejurnals');
    }
};