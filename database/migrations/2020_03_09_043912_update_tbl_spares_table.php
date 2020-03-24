<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateTblSparesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('tbl_spares')){
            Schema::table('tbl_spares',function(Blueprint $table){
               $table->boolean('suspended')->default(0)->after('stock');
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
        if (Schema::hasTable('tbl_spares')){
            Schema::table('tbl_spares',function (Blueprint $table){
                $table->dropColumn('suspended');
            });
        }
    }
}
