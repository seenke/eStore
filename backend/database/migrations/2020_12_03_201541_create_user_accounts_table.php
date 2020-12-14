<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_account', function (Blueprint $table) {

            $table->bigIncrements('id');
            $table->timestamps();
            $table->string('name');
            $table->string('lastname');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('confirmation_code');
            $table->boolean('confirmed')->default(false);
            $table->string("api_token", 80)->unique()
                ->nullable()
                ->default(null);
            $table->unsignedBigInteger('role_id');
            $table->unsignedBigInteger('user_id') -> nullable();
            $table->foreign('role_id')
                ->references('id')
                ->on('role');
            $table->foreign('user_id')
                ->references('id')
                ->on('user');
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
        Schema::dropIfExists('user_account');
    }
}
