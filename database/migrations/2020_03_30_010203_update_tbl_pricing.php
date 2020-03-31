<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateTblPricing extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('tbl_pricing')){
            Schema::table('tbl_pricing',function (Blueprint $table){
               $table->boolean('suspended')->default(0)->after('amount');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasTable('tbl_pricing')){
            Schema::table('tbl_pricing',function (Blueprint $table){
                $table->dropColumn('suspended');
            });
        }
    }
}
