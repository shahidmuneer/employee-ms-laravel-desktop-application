<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bps extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'bps';
    
    /**
    * The attributes that aren't mass assignable.
    *
    * @var array
    */
    public function stages(){
        return $this->hasMany(\App\Stage::class);
    }
    
    protected $guarded = [];
}
