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
        Schema::table('orders', function (Blueprint $table) {
            $table->string('payment_gateway')->default('manual')->after('payment_method');
            $table->string('payment_reference')->nullable()->after('payment_gateway');
            $table->decimal('discount', 10, 2)->default(0)->after('subtotal');
            $table->string('coupon_code')->nullable()->after('discount');
            $table->timestamp('paid_at')->nullable()->after('status');
            $table->timestamp('fulfilled_at')->nullable()->after('paid_at');
        });

        Schema::table('products', function (Blueprint $table) {
            $table->string('file_path')->nullable()->after('image_url');
            $table->string('file_name')->nullable()->after('file_path');
            $table->unsignedBigInteger('file_size')->nullable()->after('file_name');
            $table->integer('stock_qty')->nullable()->after('in_stock');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['payment_gateway', 'payment_reference', 'discount', 'coupon_code', 'paid_at', 'fulfilled_at']);
        });
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['file_path', 'file_name', 'file_size', 'stock_qty']);
        });
    }
};
