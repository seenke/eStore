<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShoppingCartStoreItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shopping_cart_store_item', function (Blueprint $table) {
            $table->integer('quantity');
            $table->unsignedBigInteger('shopping_cart_id');
            $table->unsignedBigInteger('store_item_id');
            $table->primary(['shopping_cart_id', 'store_item_id']);
            $table->timestamps();
            $table->foreign('shopping_cart_id')
                ->references('id')
                ->on('shopping_cart');
            $table->foreign('store_item_id')
                ->references('id')
                ->on('store_item');
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('shopping_cart_store_items');
    }
}
