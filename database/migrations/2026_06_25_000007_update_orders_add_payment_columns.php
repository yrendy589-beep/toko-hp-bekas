<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        if (!Schema::hasColumn('orders', 'payment_method')) {
            Schema::table('orders', function (Blueprint $table) {
                $table->string('payment_method')->default('cash')->after('status');
            });
        }

        if (!Schema::hasColumn('orders', 'payment_proof_path')) {
            Schema::table('orders', function (Blueprint $table) {
                $table->string('payment_proof_path')->nullable()->after('payment_method');
            });
        }

        // Expand enum status support with new values if the column exists and uses enum
        Schema::table('orders', function (Blueprint $table) {
            $table->enum('status', ['pending', 'paid', 'shipped', 'completed', 'cancelled', 'waiting_verification', 'verified'])
                  ->default('waiting_verification')
                  ->change();
        });
    }

    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['payment_method', 'payment_proof_path']);
        });
        Schema::table('orders', function (Blueprint $table) {
            $table->enum('status', ['pending','paid','shipped','completed','cancelled'])
                  ->default('pending')
                  ->change();
        });
    }
};
