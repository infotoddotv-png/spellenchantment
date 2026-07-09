<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->text('lore')->nullable();
            $table->decimal('price', 10, 2);
            $table->decimal('original_price', 10, 2)->nullable();
            $table->string('type')->default('physical');
            $table->foreignId('category_id')->nullable()->constrained()->nullOnDelete();
            $table->string('image_url')->nullable();
            $table->json('tags')->nullable();
            $table->decimal('rating', 3, 1)->default(0);
            $table->integer('review_count')->default(0);
            $table->boolean('in_stock')->default(true);
            $table->boolean('featured')->default(false);
            $table->boolean('is_new')->default(false);
            $table->boolean('is_bestseller')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
