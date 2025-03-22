<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->Integer("user_id")->nullable();
            $table->String("username")->nullable();
            $table->String("phone")->nullable();
            $table->Text("billing_address")->nullable();
            $table->Text("shipping_address")->nullable();
            $table->String("zip_code")->nullable();
            $table->double("total_amount")->nullable();
            $table->Integer("total_qty")->nullable();
            $table->String("status")->default("Pending");
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
        Schema::dropIfExists('orders');
    }
}
