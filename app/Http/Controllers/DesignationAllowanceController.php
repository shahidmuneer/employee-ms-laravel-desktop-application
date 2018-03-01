<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\DesignationAllowance;

class DesignationAllowanceController extends Controller
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
        $designationAllowance =new \App\DesignationAllowance();
        $designationAllowances=$designationAllowance->with("designation")->paginate(5);
      
        return view('system-mgmt/designation_allowances/index', ['designation_allowances' => $designationAllowances]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $designations=\App\Designation::get();
   
        return view('system-mgmt/designation_allowances/create')->with("designations",$designations);
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
         DesignationAllowance::create([
            'name' => $request['name'],
             'designation_id'=>$request['designation_id'],
             'amount'=>$request['amount']
        ]);
        return redirect()->intended('system-management/designation_allowances');
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
        $designationAllowance = \App\DesignationAllowance::find($id);
        // Redirect to division list if updating division wasn't existed
        if ($designationAllowance == null || count($designationAllowance) == 0) {
            return redirect()->intended('/system-management/designation_allowances');
        }
        
        $designations=\App\Designation::get();
   
        return view('system-mgmt/designation_allowances/edit')->with(['designation_allowance' => $designationAllowance])->with("designations",$designations);
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
        $designationAllowance = DesignationAllowance::findOrFail($id);
        $this->validateInput($request);
        $input = [
            'name' => $request['name'],
            'designation_id'=>$request['designation_id'],
            'amount'=>$request['amount'],
            "date_of_allowance"=>$request['date_of_allowance']
        ];
        DesignationAllowance::where('id', $id)
            ->update($input);
        
        return redirect()->intended('system-management/designation_allowances');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DesignationAllowance::where('id', $id)->delete();
         return redirect()->intended('system-management/designation_allowances');
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

       $designationAllowances = $this->doSearchingQuery($constraints);
       return view('system-mgmt/designation_allowances/index', ['designation_allowances' => $designationAllowances, 'searchingVals' => $constraints]);
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
        'name' => 'required|max:60',
        "date_of_allowance"=>"required|date"
    ]);
    }
}
