<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('library_entries', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('category')->default('Spells');
            $table->text('excerpt')->nullable();
            $table->longText('content')->nullable();
            $table->enum('difficulty', ['Beginner', 'Intermediate', 'Advanced'])->default('Beginner');
            $table->json('tags')->nullable();
            $table->boolean('featured')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('library_entries');
    }
};
