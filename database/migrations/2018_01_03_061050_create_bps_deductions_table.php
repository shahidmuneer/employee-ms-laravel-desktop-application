<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBpsDeductionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bps_deductions', function (Blueprint $table) {
            $table->increments('id',true)->unsigned();
            $table->string('name',10);
            $table->integer('amount');
            $table->integer('bps_id')->unsigned();
            $table->timestamp('date_of_deduction')->useCurrent();
            $table->timestamps();
        });
        
          Schema::table('bps_deductions', function(Blueprint $table){
            $table->foreign('bps_id')->references('id')->on('bps');
               });
             
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bps_deductions', function(Blueprint $table){ 
     $table->dropForeign(['bps_id']); 
    });  

        Schema::dropIfExists('bps_deductions');
    }
}
