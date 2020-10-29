<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Employee;
use App\Violation;
use Session;
use App\Cutoff;
use App\Dtr;

class ViolationsController extends Controller
{
    
    public function index()
    {
        //
    }

   
    public function create()
    {
        //
    }

    
    public function store(Request $request)
    {

        Violation::create($request->all());
        if($request->suspendDateStart<>''){
            $start_date = $request->suspendDateStart;
            $end_date = $request->suspendDateEnd;
            for ( $x = strtotime($start_date); $x <= strtotime($end_date); $x += 86400 ){
                $dyt=date('Y-m-d',$x);            
                $emp = Dtr::where('employee_id','=',$request->employee_id)->where('dtrDate','=',$dyt)->first();

                if($emp === null){
                    $cutoff = new Cutoff();
                    $dtr = Dtr::Create([
                            'employee_id' => $request->employee_id,
                            'dtrDate' => $dyt,
                            'cutoff_id' =>  $cutoff->getCutoffId($dyt),
                            'shift_id' =>  '0',
                            'tayp' =>  'Suspended',
                            'isSuspended' => '1'
                        ]);    
                }
                
                else{
                    $dtr = Dtr::findOrFail($emp->id)->Update([                        
                            'tayp' =>  'Suspended',
                            'isSuspended' => '1'
                        ]);   
                }              
            }
        }      
        Session::flash('success','Violation has been added!');
        return redirect('/violations/'.$request->employee_id.'/create');        
    }

   
    public function show($id)
    {
        //
    }

    
    public function edit($id)
    {
        $violation_e = Violation::findOrFail($id);
        $employee = Employee::findOrFail($violation_e->employee_id);
        $violations = Violation::where('employee_id',$violation_e->employee_id)->get();

        return view('employees.violations',compact('violation_e','employee','violations'));
    }

    
    public function update(Request $request, $id)
    {        
        Violation::findOrFail($id)->update($request->all());

        Session::flash('success','Violation has been updated!');

        return redirect('/violations/'.$id.'/edit');
    }

   
    public function destroy($id)
    {
        //
    }

    public function createFromEmployee($id)
    {
        $last_cutoff = app('App\Http\Controllers\CutoffsController')->getLastCutoffDate();
        //$last_cutoff = Cutoff::Lastclosedcutoff();
        $employee = Employee::findOrFail($id);
        $violations = Violation::where('employee_id',$id)->get();
        return view('employees.violations',compact('employee','violations','last_cutoff'));
    }
}
