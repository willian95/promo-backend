<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContactUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contact_users', function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->string("email");
            $table->string("password");
            $table->boolean("seller")->nullable();
            $table->boolean("buyer")->nullable();
            $table->boolean("category1")->nullable();
            $table->boolean("category2")->nullable();
            $table->boolean("category3")->nullable();
            $table->boolean("category4")->nullable();
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
        Schema::dropIfExists('contact_users');
    }
}
