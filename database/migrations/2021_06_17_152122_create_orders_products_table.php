<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders_products', function (Blueprint $table) {
            $table->id();
            $table
            ->foreignId('order_id')
            ->constrained('orders')
            ->onDelete('restrict')
            ->onUpdate('cascade');
            $table
            ->foreignId('product_id')
            ->constrained('products')
            ->onDelete('restrict')
            ->onUpdate('cascade');
            $table->integer('quantity');
            $table->double('price', 8, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders_products');
    }
}
