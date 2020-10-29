<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\leave;
use App\EmployeeLeave;
use App\Dtr;
use App\Cutoff;
use App\Leaveledger;
use Session;

class LeavesController extends Controller
{
    
    public function index()
    {
        $leaves=Leave::all();
        return view('leaves.index',compact('leaves'));
    }

  
    public function create()
    {
        return view('leaves.add');
    }

  
    public function store(Request $request)
    {
        $save = Leave::create($request->all());
        return redirect('/leaves');
    }

   
    public function show($id)
    {
        //
    }

  
    public function edit($id)
    {
        $leave=Leave::find($id);
        return view('leaves.edit',compact('leave'));
    }

  
    public function update(Request $request, $id)
    {
        Leave::find($id)->update($request->all());
        return redirect('/leaves');
    }

 
    public function destroy($id)
    {
        //
    }

    public function getdates(Request $request, $id)
    {
        //\Log::info($request->ltype);         //return;
        $get_leave_balance = EmployeeLeave::where('employee_id',$id)->where('leave_id',$request->leaveid)->first();
        $leave_balance = ($get_leave_balance === null ? '0' : $get_leave_balance['balance']);
        $data='<br><br><div class="note note-danger">
       
        '.csrf_field().'
        <table class="table"  width="50%" style="font-size:14px;">';
        $start_date = $request->start;
        $end_date = $request->end;
        for ( $x = strtotime($start_date); $x <= strtotime($end_date); $x += 86400 ){
            $dyt=date('Y-m-d',$x); 
            $data.='<tr>
                        <td>'.$request->leavetype.'</td>
                        <td>                   
                              '.date('l Y-m-d',$x).'                                  
                        </td>
                        <td><input type="checkbox" onchange="return checkIfSobraSaBalance('.number_format($leave_balance).');" name="lv'.$x.'" class="leavedateselected" value="'.$dyt.'" id="'.date('Ymd',$x).'">   </td>
                    </tr>';
        }
        $data.='
        <tr>
            <td colspan="3" style="text-align:right;"><input type="submit" class="btn purple">
            <input type="hidden" name="leavestartdate" id="leavestartdate" value="'.$start_date.'">
            <input type="hidden" name="leaveenddate" id="leaveenddate" value="'.$end_date.'">
            <input type="hidden" name="leavetype" id="leavetype" value="'.$request->leaveid.'">
            <input type="hidden" name="leavebal" id="leavebal" value="'.number_format($leave_balance).'">
            </td>
        </tr>
        
        </table>
     
        </div>';
        return $data;           
    }

    public function submitfileleave(Request $request, $id)
    {
        $start_date = $request->leavestartdate;
        $end_date = $request->leaveenddate;
        for ( $x = strtotime($start_date); $x <= strtotime($end_date); $x += 86400 ){
            $dyt=date('Y-m-d',$x); 
            if($request->input('lv'.$x) == $dyt){
                $emp = Dtr::where('employee_id','=',$id)->where('dtrDate','=',$dyt)->first();

                if($emp === null){
                    $cutoff = new Cutoff();
                    $dtr = Dtr::Create([
                            'employee_id' => $id,
                            'dtrDate' => $dyt,
                            'cutoff_id' =>  $cutoff->getCutoffId($dyt),
                            'shift_id' =>  '0',
                            'tayp' =>  $request->leavetype,
                            'isLeave' => 1,
                        ]);    
                }
                
                else{
                    $dtr = Dtr::findOrFail($emp->id)->Update([                        
                            'tayp' =>  $request->leavetype,
                            'isLeave' => 1,
                        ]);   
                }            
            }
            
        }
        //return $data;
        $leaveledger = new Leaveledger();
        $leaveledger->update_leave_maintenance_per_employee_and_leave($id,$request->leavetype);
        Session::flash('success','Leave has been successfully filed!');
        return redirect('/employees/'.$id.'/');   
    }
}
