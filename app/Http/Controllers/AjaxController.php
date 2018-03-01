<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AjaxController extends Controller
{
    public function __construct() {

//        if(!\Request::ajax()){
//        echo "we don't allowed you doing this";
//        exit;
//        }
    }
    
    public function get(Request $request){
        
        $grantHeads= \App\GrantHead::where("date","=",date("Y-m-d",strtotime($request->date)))->where("type_id","=",$request->type_id)->get();
        return \response()->json(array("grantHeads"=>$grantHeads),200);
    }
    public function getGrants(){
        $grants= \App\Grant::get();
              return \response()->json(array("grants"=>$grants),200);
   
    }
}
