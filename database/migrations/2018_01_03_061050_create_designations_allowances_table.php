<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDesignationsAllowancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('designations_allowances', function (Blueprint $table) {
            $table->increments('id',true)->unsigned();
            $table->string('name',64);
            $table->integer('amount');
            $table->integer('designation_id')->unsigned();
            $table->timestamp('date_of_allowance')->useCurrent();
            $table->timestamps();
        });
        
          Schema::table('designations_allowances', function(Blueprint $table){
            $table->foreign('designation_id')->references('id')->on('designations');
               });
             
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('designations_allowances', function(Blueprint $table){ 
     $table->dropForeign(['designation_id']); 
    });  

        Schema::dropIfExists('designations_allowances');
    }
}
