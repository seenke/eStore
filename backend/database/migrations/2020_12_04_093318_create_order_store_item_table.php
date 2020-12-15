<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderStoreItemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_store_item', function (Blueprint $table) {


            $table->unsignedBigInteger('order_id');
            $table->unsignedBigInteger('store_item_id');
            $table->integer('quantity');
            //Saving primary price in order to track orders whose storeItems price have been updated ...
            $table->decimal('primary_price');
            $table->primary(['order_id', 'store_item_id']);
            $table->timestamps();
            $table->foreign('order_id')
                ->references('id')
                ->on('order');
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
        Schema::dropIfExists('order_store_item');
    }
}
