<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    /**
    * The attributes that aren't mass assignable.
    *
    * @var array
    */
    protected $table="employees";
    
    
    public function District(){
        return $this->belongsTo(\App\Districts::class);
    }
    
    
    public function Designation(){
        return $this->belongsTo(\App\Designation::class);
    }
    
    public function Stage(){
        return $this->belongsTo(\App\Stage::class);
    }
    
     public function Department(){
        return $this->belongsTo(\App\Department::class);
    }
    
    protected $guarded = [];
}
