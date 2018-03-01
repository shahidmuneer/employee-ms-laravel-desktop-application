<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Designation extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'designations';
public function employees(){
        return $this->hasMany(\App\Employee::class);
    }
   
    /**
    * The attributes that aren't mass assignable.
    *
    * @var array
    */
    protected $guarded = [];
}
