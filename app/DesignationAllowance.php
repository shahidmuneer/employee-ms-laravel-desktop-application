<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DesignationAllowance extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'designations_allowances';
public function designation(){
    return $this->belongsTo(\App\Designation::class);
}
    /**
    * The attributes that aren't mass assignable.
    *
    * @var array
    */
    protected $guarded = [];
}
