<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGrantTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('grant_transactions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer("grant_id")->unsigned();
            $table->integer("debit")->unsigned()->default(0);
            $table->integer("credit")->unsigned()->default(0);
            $table->integer("type_id")-nullable();
            $table->string("description",255)->nullable();
           $table->datetime("date")->default(DB::raw('CURRENT_TIMESTAMP'));;
            $table->timestamps();
        });
        Schema::table('grant_transactions', function(Blueprint $table){
            $table->foreign('grant_id')->references('id')->on('grants');
        });
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
          Schema::table('grant_transactions', function(Blueprint $table){ 
     $table->dropForeign(['grant_id']); 
          });  
          
        Schema::dropIfExists('grant_transactions');
    }
}