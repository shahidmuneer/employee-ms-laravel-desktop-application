<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Division extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'division';

    public function districts(){
        return $this->hasMany(\App\Districts::class);
    }
    
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
