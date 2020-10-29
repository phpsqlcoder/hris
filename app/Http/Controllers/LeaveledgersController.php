<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Leaveledger;
use App\EmployeeLeave;
use Session;
use App\Leave;
use App\Dtr;
use DB;

class LeaveledgersController extends Controller
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
         $request['tayp'] = 'ADD';
         $save = Leaveledger::create($request->all());

         $this->update_leave_maintenance($request->all());
         Session::flash('success','Leave has been updated!');
         return redirect ('employees/'.$request->employee_id.'#tab_1_3');
    }

  
    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }
   
    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }

    public function update_leave_maintenance($data)
    {
        $total = Leaveledger::where('leave_id', $data['leave_id'])
                            ->where('employee_id',$data['employee_id'])
                            ->sum('qty');
      
        EmployeeLeave::updateOrCreate(
            ['leave_id' => $data['leave_id'], 'employee_id' => $data['employee_id']],
            ['balance' => $total]
        );
        
    }
   

    public function getledger(Request $request, $id)
    {
        //\Log::info($request->ltype);         //return;
        $leave = Leave::where('id',$request->ltype)->first();
        $ledgers =  Leaveledger::
                    where('employee_id',$id)
                    ->where('leave_id',$request->ltype)
                    ->select('effectivityDate as dyt','qty as qty','remarks as remark')
                    ->get();
        $ledgers = $ledgers->toArray();

        $dtr_leave = Dtr::
                     where('employee_id',$id)
                     ->where('tayp',$request->ltype)
                     ->select('dtrDate as dyt',DB::raw('"-1" as qty'),'remarks as remark')
                     ->get();
        $dtr_leave = $dtr_leave->toArray();

        $ledge = array_merge($ledgers,$dtr_leave);
        $data='';
        $run_bal = 0;
        usort($ledge, array($this,"cmp"));
        foreach($ledge as $ledger){                
           $run_bal += $ledger['qty'];
            $data.='
                <tr>
                    <td>'.$leave['name'].'</td>
                    <td>'.$ledger['dyt'].'</td>
                    <td style="text-align:right">'.$ledger['qty'].'</td>
                    <td>'.$run_bal.'</td>
                    <td>'.$ledger['remark'].'</td>
                </tr>
            ';
        }
        $data.='<tr><td colspan="5" style="font-size:16px;font-weight:bold;text-align:left;">Currect Balance: '.$run_bal.'</td></tr>';
        return $data;
    }

    public function cmp($a, $b)
    {
        return strcmp($a['dyt'], $b['dyt']);
    }

}
