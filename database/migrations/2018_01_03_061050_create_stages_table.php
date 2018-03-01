<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stages', function (Blueprint $table) {
            
            $table->increments('id',true)->unsigned();
            $table->string('name',10);
            $table->integer('basic_pay');
            $table->integer('bps_id')->unsigned();
            $table->integer('year');
            $table->timestamps();
            
        });
        
          Schema::table('stages', function(Blueprint $table){
            $table->foreign('bps_id')->references('id')->on('bps');
               });
               
                 Schema::table("employees",function(Blueprint $table){
                     $table->foreign('bps_stage_id')->references('id')->on('stages');
               });
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('stages', function(Blueprint $table){ 
     $table->dropForeign(['bps_id']); 
    });
        
    Schema::table('employees', function(Blueprint $table){ 
     $table->dropForeign(['bps_stage_id']); 
    });
        Schema::dropIfExists('stages');
    }
}
