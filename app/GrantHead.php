<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GrantHead extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'grant_transactions';
    protected $fileable=[
        "grant_id"
        ,"debit"
        ,"credit"
        ,"description"
        ,"date",
        "type_id"];
    
public function grant(){
return $this->belongsTo(\App\Grant::class);
}
    /**
    * The attributes that aren't mass assignable.
    *
    * @var array
    */
    protected $guarded = [];
}
