<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Grant;

class grantController extends Controller {

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
        $grant = new \App\Grant();
        $grants = $grant->with(["main"])->paginate(5);
        
        return view('budget-management/grant/index', ['grants' => $grants]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $grants = \App\Grant::get();

        return view('budget-management/grant/create')->with("grants", $grants);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $this->validateInput($request);
        Grant::create($request->all());
        return redirect()->intended('budget-management/grant');
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
    public function edit($id) {
        $grant = \App\Grant::find($id);
        // Redirect to division list if updating division wasn't existed
        if ($grant == null || count($grant) == 0) {
            return redirect()->intended('/system-management/designation_allowances');
        }

        $grants = \App\Grant::get();


        return view('budget-management/grant/edit', ['grant' => $grant])->with("grants", $grants);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        $grant = Grant::findOrFail($id);
        $this->validateInput($request);
        $input=$request->all();
     $grant->fill($input)->save();

        return redirect()->intended('budget-management/grant');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
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
