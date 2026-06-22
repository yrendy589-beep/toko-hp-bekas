<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        if (!Schema::hasTable('products')) {
            Schema::create('products', function (Blueprint $table) {
                $table->id('product_id');
                $table->foreignId('brand_id')->constrained('brands')->cascadeOnDelete();
                $table->string('model_name', 150);
                $table->decimal('price', 12, 2);
                $table->string('image')->nullable();
                $table->integer('stock')->default(0);
                $table->year('release_year')->nullable();
            });
        }
    }

    public function down()
    {
        Schema::dropIfExists('products');
    }
};
