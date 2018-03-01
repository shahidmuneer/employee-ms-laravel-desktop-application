<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\BpsDeduction;

class BpsDeductionController extends Controller
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
        $bpsDeduction =new \App\BpsDeduction();
        $bpsDeductions=$bpsDeduction->with("bps")->paginate(5);
      
        return view('system-mgmt/bps_deductions/index', ['bps_deductions' => $bpsDeductions]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $bpss=\App\Bps::get();
   
        return view('system-mgmt/bps_deductions/create')->with("bpss",$bpss);
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
         BpsDeduction::create([
            'name' => $request['name'],
             'bps_id'=>$request['bps_id'],
             'amount'=>$request['amount']
        ]);
        return redirect()->intended('system-management/bps_deduction');
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
        $bpsDeduction = \App\BpsDeduction::find($id);
        // Redirect to division list if updating division wasn't existed
        if ($bpsDeduction == null || count($bpsDeduction) == 0) {
            return redirect()->intended('/system-management/bps_deduction');
        }
        
        $bpss=\App\Bps::get();
   

        return view('system-mgmt/bps_deductions/edit', ['bps_deduction' => $bpsDeduction])->with("bpss",$bpss);
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
        $bpsDeduction = BpsDeduction::findOrFail($id);
        $this->validateInput($request);
        $input = [
            'name' => $request['name'],
            'bps_id'=>$request['bps_id'],
            'amount'=>$request['amount'],
            "date_of_deduction"=>$request['date_of_deduction']
        ];
        BpsDeduction::where('id', $id)
            ->update($input);
        
        return redirect()->intended('system-management/bps_deduction');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        BpsDeduction::where('id', $id)->delete();
         return redirect()->intended('system-management/bps_deduction');
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

       $bpsDeductions = $this->doSearchingQuery($constraints);
       return view('system-mgmt/bps_deductions/index', ['bps_deductions' => $bpsDeductions, 'searchingVals' => $constraints]);
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
