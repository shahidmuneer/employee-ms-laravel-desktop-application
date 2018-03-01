<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDivisionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('division', function (Blueprint $table) {
            $table->increments('id', true);
            
            $table->string('name', 60);
            $table->timestamps();
            $table->softDeletes();
        });
        
        Schema::table("districts",function(Blueprint $table){
           
            $table->foreign('division_id')->references('id')->on('division');
             
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
          Schema::table('districts', function(Blueprint $table){ 
     $table->dropForeign(['division_id']); 
    });  
        Schema::dropIfExists('division');
    }
}
