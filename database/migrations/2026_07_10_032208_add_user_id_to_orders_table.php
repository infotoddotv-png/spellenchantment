<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->foreignId('user_id')->nullable()->after('id')->constrained()->nullOnDelete();
        });

        // Backfill: link existing orders to users that share the same email.
        DB::table('orders')->select('id', 'email')->orderBy('id')->each(function ($order) {
            $userId = DB::table('users')->where('email', $order->email)->value('id');
            if ($userId) {
                DB::table('orders')->where('id', $order->id)->update(['user_id' => $userId]);
            }
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropConstrainedForeignId('user_id');
        });
    }
};
