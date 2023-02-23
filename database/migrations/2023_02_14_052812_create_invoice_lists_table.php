<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoice_lists', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_no')->nullable();
            $table->string('customer_id')->nullable();
            $table->string('seller_id')->nullable();
            $table->string('invoice_date')->nullable();
            $table->string('ammount')->nullable();
            $table->string('currancy_code')->nullable();
            $table->string('currancy_symbol')->nullable();
            $table->smallInteger('status')->default(1);
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
        Schema::dropIfExists('invoice_lists');
    }
};
