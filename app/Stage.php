<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Stage extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'stages';
    
    /**
    * The attributes that aren't mass assignable.
    *
    * @var array
    */
    public function bps(){
        return $this->belongsTo(\App\Bps::class);
    }
    
    public function employees(){
        return $this->hasMany(\App\Employee::class);
    }
    
    protected $guarded = [];
}
