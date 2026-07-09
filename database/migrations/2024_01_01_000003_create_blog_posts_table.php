<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('blog_posts', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('excerpt')->nullable();
            $table->longText('content')->nullable();
            $table->string('author')->default('Arcane Sanctum');
            $table->string('author_avatar')->nullable();
            $table->string('image_url')->nullable();
            $table->json('tags')->nullable();
            $table->boolean('featured')->default(false);
            $table->timestamp('published_at')->nullable();
            $table->integer('reading_time')->default(5);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('blog_posts');
    }
};
