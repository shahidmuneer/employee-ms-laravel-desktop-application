<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->increments('id', true)->unsigned();
            $table->string('lastname', 60);
            $table->string('firstname', 60);
            
            $table->string('address', 120);
            
            $table->char('zip', 10);
            $table->integer('age')->unsigned();
            $table->date('birthdate');
            $table->date('date_hired');
            $table->integer('department_id')->unsigned();
            
            $table->integer('district_id')->unsigned();  
            $table->foreign('department_id')->references('id')->on('department');
            $table->foreign('district_id')->references('id')->on('districts');  
           
            $table->string('picture', 60);
            $table->string("cnic",60);
            $table->integer("bps_stage_id")->unsigned();
          $table->integer("designation_id")->unsigned();
          
            $table->foreign('designation_id')->references('id')->on('designations');  
           
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employees');
    }
}
