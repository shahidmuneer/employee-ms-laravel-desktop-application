<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\GrantHead;

class grantHeadController extends Controller {

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $grantHead = new \App\GrantHead();
        $grantHeads = $grantHead->with(["grant"])->paginate(30);
        return view('budget-management/grant-head/index', ['grantHeads' => $grantHeads]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $grants = \App\Grant::get();

        return view('budget-management/grant-head/create')->with("grants", $grants);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
       $data=$request->all();
       \App\GrantHead::where("date","=",date("Y-m-d",strtotime($data["date"])))->where("type_id","=",$data["type_id"])->delete();
       $input_data=[];
        foreach($data['grant_id'] as $key=>$value){
          if(!empty($data['amount'][$key])){
            $input_data[]=[
              "grant_id"=>$value,
               "credit"=>$data['doc'][$key]==1?$data["amount"][$key]:0,
               "debit"=>$data['doc'][$key]==0?$data["amount"][$key]:0,
                "date"=>$data['date'],
                "type_id"=>$data['type_id']
            ];
          }
        }
        \App\GrantHead::insert($input_data);
        return redirect()->intended('budget-management/grant-head');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request,$id) {
       
        
        $ids=explode(",",$request->input("id"));
        array_push( $ids,$id);
        $grantHeads = \App\GrantHead::find(array_values($ids));

        // Redirect to division list if updating division wasn't existed
        
        
        if ($grantHeads == null || count($grantHeads) == 0) {
            return redirect()->intended('/budget-management/grant-head');
        }

        $grants = \App\Grant::get();
      

        return view('budget-management/grant-head/edit', ['grant_heads' => $grantHeads])->with("grants", $grants);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        $data=$request->all();
        
       
       $ids=[];
        foreach($data['id'] as $key=>$value){
//            array_push($ids,$value);
            $input_data=[
              "grant_id"=>$data['grant_id'][$key],
               "credit"=>empty($data['credit'][$key])?(!empty($data["amount"][$key])?$data["amount"][$key]:0):0,
               "debit"=>!empty($data['credit'][$key]) && $data['credit'][$key] =="on"?$data["amount"][$key]:0,
                "date"=>$data['date'][$key]
            ];
             \App\GrantHead::where('id', $value)
                ->update($input_data);
        }
       
        return redirect()->intended('budget-management/grant-head');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        \App\GrantHead::where('id', $id)->delete();
        return redirect()->intended('budget-management/grant-head');
    }

    /**
     * Search division from database base on some specific constraints
     *
     * @param  \Illuminate\Http\Request  $request
     *  @return \Illuminate\Http\Response
     */
    public function search(Request $request) {
        $constraints = [
            'name' => $request['name']
        ];
        $grantHead= $this->doSearchingQuery($constraints);
        return view('grant-management/grant/index', ['grant_heads' => $grantHead, 'searchingVals' => $constraints]);
    }

    private function doSearchingQuery($constraints) {
        $query = Division::query();
        $fields = array_keys($constraints);
        $index = 0;
        foreach ($constraints as $constraint) {
            if ($constraint != null) {
                $query = $query->where($fields[$index], 'like', '%' . $constraint . '%');
            }

            $index++;
        }
        return $query->paginate(5);
    }

    private function validateInput($request) {
        $this->validate($request, [
            'code' => 'required|max:64',
            'name' => 'required|max:64',
        ]);
    }

}
