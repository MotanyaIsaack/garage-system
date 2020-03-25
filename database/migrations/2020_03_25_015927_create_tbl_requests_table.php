<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTblRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_requests', function (Blueprint $table) {
            $table->bigIncrements('request_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('mechanic_id')->nullable();
            $table->text('services');
            $table->double('amount');
            $table->boolean('suspended')->default(0);
            $table->boolean('paid')->default(0);
            $table->boolean('completed')->default(0);
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
        Schema::dropIfExists('tbl_requests');
    }
}
