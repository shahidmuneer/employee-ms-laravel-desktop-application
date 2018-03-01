<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGrantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        
        Schema::create('grants', function (Blueprint $table) {
            $table->increments('id');
            $table->string("code",64);
            $table->string("name",155);
            $table->integer("grant_id")->unsigned()->nullable();
            $table->timestamps();
        });
        
       Schema::table('grants', function(Blueprint $table){
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
         Schema::table('grants', function(Blueprint $table){ 
     $table->dropForeign(['parent_id']); 
    });  
    
        Schema::dropIfExists('grants');
    }
}
