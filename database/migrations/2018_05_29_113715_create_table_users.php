<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('username', 30)->unique();
            $table->string('email', 60)->unique()->nullable();
            //$table->string('country_code')->default('+1');
            $table->string('phone', 50)->unique()->nullable();
            $table->string('password', 180);
            $table->text('intro', 180)->nullable();
            $table->text('avatar_url')->nullable();

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
        Schema::dropIfExists('users');
    }
}
