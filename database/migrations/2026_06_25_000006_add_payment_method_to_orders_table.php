<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        if (Schema::hasTable('orders') && ! Schema::hasColumn('orders', 'payment_method')) {
            Schema::table('orders', function (Blueprint $table) {
                $table->string('payment_method')->default('cash')->after('status');
            });
        }
    }

    public function down()
    {
        if (Schema::hasTable('orders') && Schema::hasColumn('orders', 'payment_method')) {
            Schema::table('orders', function (Blueprint $table) {
                $table->dropColumn('payment_method');
            });
        }
    }
};
