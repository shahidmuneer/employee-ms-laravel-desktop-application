<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BpsAllowance extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'bps_allowances';
public function bps(){
    return $this->belongsTo(\App\Bps::class);
}
    /**
    * The attributes that aren't mass assignable.
    *
    * @var array
    */
    protected $guarded = [];
}
