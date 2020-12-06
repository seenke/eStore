<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('address', function (Blueprint $table) {

            $table->bigIncrements('id');
            $table->timestamps();
            $table->string("street");
            $table->string("street_number");
            $table->unsignedBigInteger('post_office_id');
            $table->unsignedBigInteger("user_id");
            $table->foreign('post_office_id')
                ->references('id')
                ->on('post_office');
            $table->softDeletes();
            $table->foreign('user_id')
                ->references('id')
                ->on('user');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('address');
    }
}
