<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateTblRequests extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('tbl_requests')){
            Schema::table('tbl_requests',function (Blueprint $table){
                $table->unsignedBigInteger('category_id')->after('mechanic_id');
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
        if (Schema::hasTable('tbl_requests')){
            Schema::table('tbl_requests',function (Blueprint $table){
                $table->dropColumn('category_id');
            });
        }
    }
}
