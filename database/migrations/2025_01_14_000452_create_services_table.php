<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->Integer("category_id")->nullable();
            $table->Integer("vendor_id")->nullable();
            $table->String("name")->nullable();
            $table->double("price")->nullable();
            $table->String("location")->nullable();
            $table->String("lat")->nullable();
            $table->String("lng")->nullable();
            $table->String("duration")->nullable();
            $table->Text("detail")->nullable();
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
        Schema::dropIfExists('services');
    }
}
