<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Districts extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'districts';
public function division(){
    return $this->belongsTo(\App\Division::class);
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
