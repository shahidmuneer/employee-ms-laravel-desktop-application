<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\BpsAllowance;

class BpsAllowanceController extends Controller
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
        $bpsAllowance =new \App\BpsAllowance();
        $bpsAllowances=$bpsAllowance->with("bps")->paginate(5);
      
        return view('system-mgmt/bps_allowances/index', ['bps_allowances' => $bpsAllowances]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $bpss=\App\Bps::get();
   
        return view('system-mgmt/bps_allowances/create')->with("bpss",$bpss);
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
         BpsAllowance::create([
            'name' => $request['name'],
             'bps_id'=>$request['bps_id'],
             'amount'=>$request['amount']
        ]);
        return redirect()->intended('system-management/bps_allowances');
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
        $bpsAllowance = \App\BpsAllowance::find($id);
        // Redirect to division list if updating division wasn't existed
        if ($bpsAllowance == null || count($bpsAllowance) == 0) {
            return redirect()->intended('/system-management/bps_allowances');
        }
        
        $bpss=\App\Bps::get();
   

        return view('system-mgmt/bps_allowances/edit', ['bps_allowance' => $bpsAllowance])->with("bpss",$bpss);
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
        $bpsAllowance = BpsAllowance::findOrFail($id);
        $this->validateInput($request);
        $input = [
            'name' => $request['name'],
            'bps_id'=>$request['bps_id'],
            'amount'=>$request['amount'],
            "date_of_allowance"=>$request['date_of_allowance']
        ];
        BpsAllowance::where('id', $id)
            ->update($input);
        
        return redirect()->intended('system-management/bps_allowances');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        BpsAllowance::where('id', $id)->delete();
         return redirect()->intended('system-management/bps_allowances');
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

       $bpsAllowances = $this->doSearchingQuery($constraints);
       return view('system-mgmt/bps_allowances/index', ['bps_allowances' => $bpsAllowances, 'searchingVals' => $constraints]);
    }

    private function doSearchingQuery($constraints) {
        $query = Division::query();
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
        'name' => 'required|max:60'
    ]);
    }
}
