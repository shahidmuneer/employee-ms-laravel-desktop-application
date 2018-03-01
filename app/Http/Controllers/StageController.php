<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Stage;

class StageController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $stage =new Stage();
        $stages=$stage->with("bps")->paginate(5);
      
        return view('system-mgmt/stage/index', ['stages' => $stages]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $bpss=\App\Bps::get();
   $years=[];
   for($i=date("Y");$i>1980;$i--){
       $years[]=$i;
   }
        return view('system-mgmt/stage/create')->with("bpss",$bpss)->with('years',$years);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validateInput($request);
         Stage::create([
            'name' => $request['name'],
             'bps_id'=>$request['bps_id'],
             'basic_pay'=>$request['basic_pay'],
             'year'=>$request['year']
             
        ]);

        return redirect()->intended('system-management/stage');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $stage = Stage::find($id);
         $bpss=\App\Bps::get();
         $years=[];
   for($i=date("Y");$i>1980;$i--){
       $years[]=$i;
   }
        // Redirect to division list if updating division wasn't existed
        if ($stage == null || count($stage) == 0) {
            return redirect()->intended('/system-management/stage');
        }

        return view('system-mgmt/stage/edit', ['stage' => $stage])
                ->with('bpss',$bpss)
                ->with('years',$years);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $stage = Stage::findOrFail($id);
        $this->validateInput($request);
        $input = [
            'name' => $request['name'],
             'bps_id'=>$request['bps_id'],
             'basic_pay'=>$request['basic_pay'],
             'year'=>$request['year']
             ];
        Stage::where('id', $id)
            ->update($input);
        
        return redirect()->intended('system-management/stage');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Stage::where('id', $id)->delete();
         return redirect()->intended('system-management/stage');
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

       $stage = $this->doSearchingQuery($constraints);
       return view('system-mgmt/stage/index', ['stages' => $stage, 'searchingVals' => $constraints]);
    }

    private function doSearchingQuery($constraints) {
        $query = \App\Stage::query();
        $fields = array_keys($constraints);
        $index = 0;
        foreach ($constraints as $constraint) {
            if ($constraint != null) {
                $query = $query->where( $fields[$index], 'like', '%'.$constraint.'%');
            }

            $index++;
        }
        return $query->paginate(5);
    }
    private function validateInput($request) {
        $this->validate($request, [
        'name' => 'required|max:60',
        "basic_pay"=>'integer'
    ]);
    }
}
