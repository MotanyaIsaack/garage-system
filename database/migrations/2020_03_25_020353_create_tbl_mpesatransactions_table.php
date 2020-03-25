<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTblMpesatransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_mpesatransactions', function (Blueprint $table) {
            $table->bigIncrements('mpesatransaction_id');
            $table->string('MerchantRequestID');
            $table->string('CheckoutRequestID');
            $table->unsignedBigInteger('user_id');
            $table->string('status');
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
        Schema::dropIfExists('tbl_mpesatransactions');
    }
}
