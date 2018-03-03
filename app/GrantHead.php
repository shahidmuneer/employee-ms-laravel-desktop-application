<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades;

class GrantHead extends Model
{
    
    public $from;
    public $to;
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

public function getOriginalBudgetGrant($id){
    
   return $this->fetchQuery(1, $id);
}

public function getReapproSubGrant($id){
    
   return $this->fetchQuery(2, $id);
}

public function getModifiedGrant($id){
    
   return $this->fetchQuery(3, $id);
}

public function getPreviousMonthExpenses($id){
    
   return  $this->getExpense($id,"<");
}
public function getCurrentMonthExpenses($id){
    
   return  $this->getExpense($id,"=>");
}

public function getExpense($id,$expression){
    $data=$this->select(\DB::raw('SUM(credit)-SUM(debit) as total'))
            ->where("grant_id","=",$id)
            ->where("type_id","=",4)
            ->where("date",$expression,date("Y-m-01",strtotime($this->from)))
            ->where("date","<=",date("Y-m-31",strtotime($this->to)))
            ->get();
    return !empty($data[0]->total)?$data[0]->total:0;
}

public function fetchQuery($type_id,$id){
    
    $data=$this->select(\DB::raw('SUM(credit)-SUM(debit) as total'))
            ->where("grant_id","=",$id)
            ->where("type_id","=",$type_id)
            ->whereBetween("date",array($this->from,$this->to))
            ->get();
    return !empty($data[0]->total)?$data[0]->total:0;
}
    /**
    * The attributes that aren't mass assignable.
    *
    * @var array
    */
    protected $guarded = [];
}