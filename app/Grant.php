<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Grant extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'grants';
    protected $fileable=["code","name","grant_id"];
public function main(){
    return $this->belongsTo(Self::class,"grant_id");
}
    /**
    * The attributes that aren't mass assignable.
    *
    * @var array
    */
    protected $guarded = [];
}
