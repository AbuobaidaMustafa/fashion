<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stores', function (Blueprint $table) {
            $table->id();
            $table->bigInteger("category_id")->unsigned();
            $table->mediumInteger("area_id")->unsigned();
            $table->string('name_local', 50);
            $table->string("phone");
            $table->string("image");
            $table->string("location");
            $table->timestamps();
            $table->foreign('area_id')->references('id')->on('areas');
            $table->foreign('category_id')->references('id')->on('categories');


            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('stores');
    }
}
