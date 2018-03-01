<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Districts;

class DistrictsController extends Controller
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
        $district =new Districts();
        $districts=$district->with("division")->paginate(5);
      
        return view('system-mgmt/districts/index', ['districts' => $districts]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $divisions=\App\Division::get();
   
        return view('system-mgmt/districts/create')->with("divisions",$divisions);
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
         Districts::create([
            'name' => $request['name'],
             'division_id'=>$request['division_id']
        ]);

        return redirect()->intended('system-management/districts');
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
        $district = \App\Districts::find($id);
        // Redirect to division list if updating division wasn't existed
        if ($district == null || count($district) == 0) {
            return redirect()->intended('/system-management/districts');
        }
        
        $divisions=\App\Division::get();
   

        return view('system-mgmt/districts/edit', ['district' => $district])->with("divisions",$divisions);
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
        $district = Districts::findOrFail($id);
        $this->validateInput($request);
        $input = [
            'name' => $request['name'],
            'division_id'=>$request['division_id']
        ];
        Districts::where('id', $id)
            ->update($input);
        
        return redirect()->intended('system-management/districts');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Districts::where('id', $id)->delete();
         return redirect()->intended('system-management/districts');
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

       $districts = $this->doSearchingQuery($constraints);
       return view('system-mgmt/districts/index', ['districts' => $districts, 'searchingVals' => $constraints]);
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
        'name' => 'required|max:60|unique:division'
    ]);
    }
}
