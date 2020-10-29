<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Dtr;
use App\Shift;
use App\Leave;
use App\Cutoff;
use App\Payroll;
use App\Loans;
use DB;
use Auth;
use App\Employee;
use Excel;
use App\Violation;

class ReportsController extends Controller
{
    public function index(){

    }

    public function tss_filter(){
        $cutoffs = Cutoff::orderBy('id','desc')->get();
        $teamleaders = Dtr::distinct()->select('teamleader')->where('tayp','PRESENT')->orderBy('teamleader')->get();
        return view('reports.tss_filter',compact('cutoffs','teamleaders'));
    }

    public function tss_range_filter(){
        $cutoffs = Cutoff::orderBy('id','desc')->get();
        return view('reports.tss_range_filter',compact('cutoffs'));
    }
    
    public function payroll_filter(){
        $cutoffs = Cutoff::where('isDtrClosed','1')->orderBy('id','desc')->get();
        $teamleaders = Payroll::distinct()->select('teamleader')->where('present','>',0)->orderBy('teamleader')->get();
        $locations = Payroll::distinct()->select('location')->where('present','>',0)->orderBy('location')->get();
        //dd($locations);

        //\Log::info($locations);
        return view('reports.payroll_filter',compact('cutoffs','teamleaders','locations'));
    }

    public function payslip_filter(){
        $cutoffs = Cutoff::where('isDtrClosed','1')->orderBy('id','desc')->get();
        $teamleaders = Payroll::distinct()->select('teamleader')->where('present','>',0)->orderBy('teamleader')->get();
        $locations = Payroll::distinct()->select('location')->where('present','>',0)->orderBy('location')->get();
        return view('reports.payslip_filter',compact('cutoffs','teamleaders','locations'));
    }

    public function deductions_filter(){
        $cutoffs = Cutoff::where('isDtrClosed','1')->orderBy('id','desc')->get();
        $teamleaders = Payroll::distinct()->select('teamleader')->where('present','>',0)->orderBy('teamleader')->get();
        $locations = Payroll::distinct()->select('location')->where('present','>',0)->orderBy('location')->get();
        return view('reports.deductions_filter',compact('cutoffs','teamleaders','locations'));
    }

    public function masterlist_filter(){
        $cutoffs = Cutoff::where('isDtrClosed','1')->orderBy('id','desc')->get();
        return view('reports.masterlist_filter',compact('cutoffs'));
    }

    public function ppe_schedule_filter(){
        $cutoffs = Cutoff::where('isDtrClosed','1')->orderBy('id','desc')->get();
        $teamleaders = Payroll::distinct()->select('teamleader')->where('present','>',0)->orderBy('teamleader')->get();
        return view('reports.ppe_schedule_filter',compact('cutoffs','teamleaders'));
    }

    public function statutories_filter(){
        $cutoffs = Cutoff::where('isDtrClosed','1')->orderBy('id','desc')->get();
        $teamleaders = Payroll::distinct()->select('teamleader')->where('present','>',0)->orderBy('teamleader')->get();
        return view('reports.statutories_filter',compact('cutoffs','teamleaders'));
    }

    public function resigned_filter(){   
        return view('reports.resigned_filter');
    }

    public function tss(Request $request, $id){
        $idd = explode("|",$id);
        $id = $idd[0];
        $teamleader = $idd[1];
        $data='';
        $totalPresent = 0;
        $totalAbsent = 0;
        $totalLeave = 0;
        $totalDelinquent = 0;
        $totalIncentive = 0;
        $total = 0;
        $user_role = Auth::user()->role;
        
        $employees = DB::table('dtr')
                    ->leftJoin('employees','dtr.employee_id','=','employees.id')
                    ->distinct()
                    ->select('dtr.employee_id','employees.fullName','employees.empid','dtr.teamleader','dtr.location')
                    ->where('dtr.tayp','PRESENT')
                    ->where('dtr.cutoff_id','=',$id);
        if($user_role <> 'admin'){
            $employees=$employees->where('employees.contractor',$user_role);
        }
        if($teamleader <> 'ALL'){
            $employees=$employees->where('dtr.teamleader',$teamleader);
        }        
        $employees = $employees->get();
        $collection = collect($employees);
        $unique = $collection->unique('teamleader');
        $unique->values()->toArray();
        foreach($unique as $uniqued){

            $employeed = collect($employees);
            $employee_per_teamleader = $employeed->where('teamleader',$uniqued->teamleader)->sortBy('location');
            $employee_per_teamleader->toArray();
            // $data.= '<tr><td colspan="16" style="color:blue;font-size:20px;">Teamleader: '.$uniqued->teamleader.'</td></tr>'; 
                foreach($employee_per_teamleader as $ee){
                    //$data.=$ee->fullName."<br>";
                    $leave = DB::table('dtr')->where('isLeave','=','1')->where('employee_id','=',$ee->employee_id)->where('cutoff_id','=',$id)->count();
                    $present = DB::table('dtr')->where('tayp','=','PRESENT')->where('employee_id','=',$ee->employee_id)->where('cutoff_id','=',$id)->count();
                    $absent = DB::table('dtr')->where('tayp','=','ABSENT')->where('employee_id','=',$ee->employee_id)->where('cutoff_id','=',$id)->count();
                    $delinquent = DB::table('dtr')->where('isSuspended','=','1')->where('employee_id','=',$ee->employee_id)->where('cutoff_id','=',$id)->count();
                    $payroll_d = DB::table('payrolls')->where('employee_id','=',$ee->employee_id)->where('cutoff_id','=',$id)->first();
                    if($payroll_d === null){
                        $payroll_adjustment = 0;
                    }
                    else{
                        $payroll_adjustment = $payroll_d->adjustment_days;
                    }
                    $totalPerEmployee = $leave + $present + $absent + $delinquent + $payroll_adjustment;
                    $totalIncentive = $payroll_adjustment;
                    $totalPresent += $present;
                    $totalAbsent += $absent;
                    $totalLeave += $leave;
                    $totalDelinquent += $delinquent;

                    $total += $totalPerEmployee;
                    
                    $data.= '<tr>
                                <td>'.$ee->empid.'</td>
                                <td>'.$ee->fullName.'</td>
                                <td>'.$ee->location.'</td>
                                <td>'.$present.'</td>
                                <td>'.$absent.'</td>
                                <td>'.$leave.'</td>
                                <td>'.$delinquent.'</td>
                                <td>'.$payroll_adjustment.'</td>
                                <td>'.$totalPerEmployee.'</td>
                            </tr>';
                }
        }
        $header= '<thead>
                    <tr>
                        <th>ID</th>
                        <th>Employee</th>
                        <th>Location</th>
                        <th>Present</th>
                        <th>Absent</th>
                        <th>Leave</th>
                        <th>Suspended</th>
                        <th>Adjustment</th>
                        <th>Total</th>
                    </tr>
                </thead>';
        $footer= '<tfoot>
                    <tr>
                        <th>Total</th>
                        <th colspan="2">&nbsp;</th>
                        <th>'.$totalPresent.'</th>
                        <th>'.$totalAbsent.'</th>
                        <th>'.$totalLeave.'</th>
                        <th>'.$totalDelinquent.'</th>
                        <th>'.$totalIncentive.'</th>
                        <th>'.$total.'</th>
                    </tr>
                </tfoot>';
        $cutoff = Cutoff::where('id',$id)->first();
        $title = 'Time Sheet Summary<br><small>'.$cutoff->start.' to '.$cutoff->end.'</small>';
        $report = [
            'header' => $header,
            'data' => $data,
            'footer' => $footer,
            'title' => $title
        ];
        return view('reports.tss',compact('report'));
    }

    public function tss_range(Request $request, $id){
        $idd = explode("|",$id);
        $start = $idd[0];
        $end = $idd[1];
        $data='';
        $totalPresent = 0;
        $total = 0;
        $user_role = Auth::user()->role;
        
        $employees = DB::table('dtr')
                    ->leftJoin('employees','dtr.employee_id','=','employees.id')
                    ->distinct()
                    ->select('dtr.employee_id','employees.fullName','employees.empid','dtr.teamleader','dtr.location','dtr.cutoff_id')
                    ->where('dtr.tayp','PRESENT')
                    ->where('dtr.cutoff_id','>=',$start)
                    ->where('dtr.cutoff_id','<=',$end)
                    ;
            
        $employees = $employees->get();
        $collection = collect($employees);
        $unique = $collection->unique('employee_id');
        $unique->values()->toArray();
        foreach($unique as $uniqued){

            $employeed = collect($employees);           
            $cutoff = $employeed->unique('cutoff_id')->sortBy('cutoff_id');
            $cutoff->values()->toArray();
            $ee = DB::table('employees')->where('id','=',$uniqued->employee_id)->first();
            $data.= '<tr><td colspan="16" style="color:blue;font-size:20px;">'.$ee->fullName.'</td>'; 
                foreach($employee_per_teamleader as $ee){
                    //$data.=$ee->fullName."<br>";
                    $leave = DB::table('dtr')->where('isLeave','=','1')->where('employee_id','=',$ee->employee_id)->where('cutoff_id','=',$id)->count();
                    $present = DB::table('dtr')->where('tayp','=','PRESENT')->where('employee_id','=',$ee->employee_id)->where('cutoff_id','=',$id)->count();
                    $absent = DB::table('dtr')->where('tayp','=','ABSENT')->where('employee_id','=',$ee->employee_id)->where('cutoff_id','=',$id)->count();
                    $delinquent = DB::table('dtr')->where('isSuspended','=','1')->where('employee_id','=',$ee->employee_id)->where('cutoff_id','=',$id)->count();
                    $payroll_d = DB::table('payrolls')->where('employee_id','=',$ee->employee_id)->where('cutoff_id','=',$id)->first();
                    if($payroll_d === null){
                        $payroll_adjustment = 0;
                    }
                    else{
                        $payroll_adjustment = $payroll_d->adjustment_days;
                    }
                    $totalPerEmployee = $leave + $present + $absent + $delinquent + $payroll_adjustment;
                    $totalIncentive = $payroll_adjustment;
                    $totalPresent += $present;
                    $totalAbsent += $absent;
                    $totalLeave += $leave;
                    $totalDelinquent += $delinquent;

                    $total += $totalPerEmployee;
                    
                    $data.= '<tr>
                                <td>'.$ee->empid.'</td>
                                <td>'.$ee->fullName.'</td>
                                <td>'.$ee->location.'</td>
                                <td>'.$present.'</td>
                                <td>'.$absent.'</td>
                                <td>'.$leave.'</td>
                                <td>'.$delinquent.'</td>
                                <td>'.$payroll_adjustment.'</td>
                                <td>'.$totalPerEmployee.'</td>
                            </tr>';
                }
            $data.='</tr>';
        }
        $header= '<thead>
                    <tr>
                        <th>ID</th>
                        <th>Employee</th>
                        <th>Location</th>
                        <th>Present</th>
                        <th>Absent</th>
                        <th>Leave</th>
                        <th>Suspended</th>
                        <th>Adjustment</th>
                        <th>Total</th>
                    </tr>
                </thead>';
        $footer= '<tfoot>
                    <tr>
                        <th>Total</th>
                        <th colspan="2">&nbsp;</th>
                        <th>'.$totalPresent.'</th>
                        <th>'.$totalAbsent.'</th>
                        <th>'.$totalLeave.'</th>
                        <th>'.$totalDelinquent.'</th>
                        <th>'.$totalIncentive.'</th>
                        <th>'.$total.'</th>
                    </tr>
                </tfoot>';
        $cutoff = Cutoff::where('id',$id)->first();
        $title = 'Time Sheet Summary<br><small>'.$cutoff->start.' to '.$cutoff->end.'</small>';
        $report = [
            'header' => $header,
            'data' => $data,
            'footer' => $footer,
            'title' => $title
        ];
        return view('reports.tss',compact('report'));
    }

    public function payroll(Request $request, $id){
        $idd = explode("|",$id);
        $id = $idd[0];
        $teamleader = $idd[1];
        $location = str_replace("qqqqq", "/", $idd[2]);

        $user_role = Auth::user()->role;
        $payrolls = DB::table('payrolls')                   
                    ->where('payrolls.cutoff_id','=',$id);
        if($user_role <> 'admin'){
            $payrolls=$payrolls->where('payrolls.contractor',$user_role);
        }
        if($teamleader <> 'ALL'){
            $payrolls=$payrolls->where('payrolls.teamleader',$teamleader);
        }
        if($location <> 'ALL'){
            $payrolls=$payrolls->where('payrolls.location',$location);
        }
                
        $data='';
       
        $header= '<thead>
                    <tr style="font-weight:bold;font-size:14px style="text-align:right;">
                        <th>#</th>                   
                        <th>Employee&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
                        <td>Location</td>
                        <td>Present</td>
                        <td>Absent</td>
                        <td>Adjustment</td>
                        <td>Rate</td>
                        <td>Gross</td>
                        
                        <td>Adjustment</td>
                        <td>SSS</td>
                        <td>HDMF</td>
                        <td>Philhealth</td>
                        <td>SSS Loan</td>
                        <td>HDMF Loan</td>                   
                        <td>Net</td>
                        <td>Signature</td>                      
                    </tr>
                </thead>';

        $payrolls = $payrolls->orderBy('teamleader')->orderBy('location')->orderBy('fullName')->get();
        //$payrolls->
        $collection = collect($payrolls);
        $unique = $collection->unique('teamleader');
        $unique->values()->toArray();
        $x=0;
        $seqn=0;
        $seqarray=[];
        foreach($unique as $uniqued){
            $x++;
            $data_excel[$x]=array();
            $data_excel['tl'.$x] = $uniqued->teamleader;
            array_push($data_excel[$x],array('Employee','Teamleader','Location','Present','Absent','Leave','Suspended','Adjustment','Rate','Gross','Cola','Adjustment','SSS','HDMF','Philhealth','SSS Loan','HDMF Loan','Net','Signature'));
            $payrolled = collect($payrolls);
            $payroll_per_teamleader = $payrolled->where('teamleader',$uniqued->teamleader);
            $payroll_per_teamleader->toArray();
            $data.= '<tr><td colspan="19" style="color:blue;font-size:20px;">Teamleader: '.$uniqued->teamleader.'</td></tr>'; 
            $t_present = 0;
            $t_absent = 0;
            $t_leave = 0;
            $t_suspended = 0;
            $t_present_amount = 0;
            $t_adjustment = 0;
            $t_cola = 0;
            $t_sss_amount = 0;
            $t_hdmf_amount = 0;
            $t_philhealth_amount = 0;
            $t_sss_loan_amount = 0;
            $t_hdmf_loan_amount = 0;
            $t_13thmonth = 0;
            $t_incentive = 0;
            $t_amount = 0;
            foreach($payroll_per_teamleader as $payroll){                             
                if (!in_array($payroll->fullName, $seqarray))
                {
                    $seqn++;
                    $seqdisplay=$seqn;   
                    array_push($seqarray,$payroll->fullName);
                }
                else{
                    $seqdisplay="";   
                }
                $t_present += $payroll->present;
                $t_absent += $payroll->absent;
                $t_leave += $payroll->leave;
                $t_suspended += $payroll->suspended;
                $t_adjustment += $payroll->adjustment_days;
                $t_present_amount += $payroll->present_amount;
                $t_cola += ($payroll->cola * $payroll->present);
                $t_sss_amount += $payroll->sss_amount;
                $t_hdmf_amount += $payroll->hdmf_amount;
                $t_philhealth_amount += $payroll->philhealth_amount;
                $t_sss_loan_amount += $payroll->sss_loan_amount;
                $t_hdmf_loan_amount += $payroll->hdmf_loan_amount;
                $t_13thmonth += ($payroll->amount/12);
                $t_incentive += $payroll->adjustment;
                $t_amount += $payroll->amount;            
                $data.= '<tr style="font-size:14px;">
                        <td>'.$seqdisplay.'</td>
                        <td style="width:500px;">'.$payroll->fullName.'</td>
                            
                            <td>'.$payroll->location.'</td>
                            <td style="text-align:right;">'.number_format($payroll->present,2).'</td>
                            <td style="text-align:right;">'.number_format($payroll->absent,2).'</td>
                            <td style="text-align:right;">'.number_format($payroll->adjustment_days,2).'</td>
                            <td style="text-align:right;">'.number_format($payroll->rate,2).'</td>
                            <td style="text-align:right;">'.number_format($payroll->present_amount,2).'</td>
                            <td style="text-align:right;">'.number_format($payroll->adjustment,2).'</td>
                            <td style="text-align:right;">'.number_format($payroll->sss_amount,2).'</td>
                            <td style="text-align:right;">'.number_format($payroll->hdmf_amount,2).'</td>
                            <td style="text-align:right;">'.number_format($payroll->philhealth_amount,2).'</td>
                            <td style="text-align:right;">'.number_format($payroll->sss_loan_amount,2).'</td>
                            <td style="text-align:right;">'.number_format($payroll->hdmf_loan_amount,2).'</td>
                            <td style="text-align:right;">'.number_format($payroll->amount,2).'</td>                          
                            <td>_______________</td>
                    </tr>';
                array_push($data_excel[$x],array(
                                $payroll->fullName,
                                $payroll->teamleader,
                                $payroll->location,
                                number_format($payroll->present,4),
                                number_format($payroll->absent,4),
                                number_format($payroll->leave,4),
                                number_format($payroll->suspended,4),
                                number_format($payroll->adjustment_days,4),
                                number_format($payroll->rate,4),
                                number_format($payroll->present_amount,4),
                                number_format(($payroll->cola * $payroll->present),4),
                                number_format($payroll->adjustment,4),
                                number_format($payroll->sss_amount,4),
                                number_format($payroll->hdmf_amount,4),
                                number_format($payroll->philhealth_amount,4),
                                number_format($payroll->sss_loan_amount,4),
                                number_format($payroll->hdmf_loan_amount,4),
                                number_format($payroll->amount,4)
                                )

                );
                
            }
             $data.= '
             <tr style="color:blue;font-size:14px style="text-align:right;">
                            <td>TOTAL: </td>                        
                            <td colspan="2">&nbsp;</td>                            
                          
                            <td style="text-align:right;">'.$t_present.'</td>
                            <td style="text-align:right;">'.$t_absent.'</td>
                            <td style="text-align:right;">'.$t_adjustment.'</td>
                            <td>&nbsp;</td>
                            <td style="text-align:right;">'.number_format($t_present_amount,2).'</td>
                            <td style="text-align:right;">'.number_format($t_incentive,2).'</td>
                            <td style="text-align:right;">'.number_format($t_sss_amount,2).'</td>
                            <td style="text-align:right;">'.number_format($t_hdmf_amount,2).'</td>
                            <td style="text-align:right;">'.number_format($t_philhealth_amount,2).'</td>
                            <td style="text-align:right;">'.number_format($t_sss_loan_amount,2).'</td>
                            <td style="text-align:right;">'.number_format($t_hdmf_loan_amount,2).'</td>                           
                            <td style="text-align:right;">'.number_format($t_amount,2).'</td>
                            <td>&nbsp;</td>
                    </tr>
                    <tr><td><br></td></tr>';
        }
        
        $footer= '<tfoot>
                    
                </tfoot>';
            
        $cutoff = Cutoff::where('id',$id)->first();
        $title = 'Payroll Summary<br><small>'.$cutoff->start.' to '.$cutoff->end.'</small>';
        $report = [
            'header' => $header,
            'data' => $data,
            'footer' => $footer,
            'title' => $title
        ];
        $data_excel['Total'] = $x;
        return view('reports.payroll',compact('report'));
    }

    public function payroll_excel(Request $request, $id){
        $idd = explode("|",$id);
        $id = $idd[0];
        $teamleader = $idd[1];
        $location = $idd[2];

        $user_role = Auth::user()->role;
        $payrolls = DB::table('payrolls')                   
                    ->where('payrolls.cutoff_id','=',$id);
        if($user_role <> 'admin'){
            $payrolls=$payrolls->where('payrolls.contractor',$user_role);
        }
        if($teamleader <> 'ALL'){
            $payrolls=$payrolls->where('payrolls.teamleader',$teamleader);
        }
        if($location <> 'ALL'){
            $payrolls=$payrolls->where('payrolls.location',$location);
        }
                
        $data='';       
     
        $payrolls = $payrolls->get();
        //$payrolls->
        $collection = collect($payrolls);
        $unique = $collection->unique('teamleader');
        $unique->values()->toArray();
        $x=0;
        foreach($unique as $uniqued){
            $x++;
            $data_excel[$x]=array();
            $data_excel['tl'.$x] = $uniqued->teamleader;
            array_push($data_excel[$x],array('Employee','Teamleader','Location','Present','Absent','Leave','Suspended','Adjustment','Rate','Gross','Cola','Adjustment','SSS','HDMF','Philhealth','SSS Loan','HDMF Loan','Net','Signature'));
            $payrolled = collect($payrolls);
            $payroll_per_teamleader = $payrolled->where('teamleader',$uniqued->teamleader)->sortBy('location');
            $payroll_per_teamleader->toArray();
            $data.= '<tr><td colspan="19" style="color:blue;font-size:20px;">Teamleader: '.$uniqued->teamleader.'</td></tr>'; 
            $t_present = 0;
            $t_absent = 0;
            $t_leave = 0;
            $t_suspended = 0;
            $t_present_amount = 0;
            $t_adjustment = 0;
            $t_cola = 0;
            $t_sss_amount = 0;
            $t_hdmf_amount = 0;
            $t_philhealth_amount = 0;
            $t_sss_loan_amount = 0;
            $t_hdmf_loan_amount = 0;
            $t_13thmonth = 0;
            $t_incentive = 0;
            $t_amount = 0;
            foreach($payroll_per_teamleader as $payroll){
                $t_present += $payroll->present;
                $t_absent += $payroll->absent;
                $t_leave += $payroll->leave;
                $t_suspended += $payroll->suspended;
                $t_adjustment += $payroll->adjustment_days;
                $t_present_amount += $payroll->present_amount;
                $t_cola += ($payroll->cola * $payroll->present);
                $t_sss_amount += $payroll->sss_amount;
                $t_hdmf_amount += $payroll->hdmf_amount;
                $t_philhealth_amount += $payroll->philhealth_amount;
                $t_sss_loan_amount += $payroll->sss_loan_amount;
                $t_hdmf_loan_amount += $payroll->hdmf_loan_amount;
                $t_13thmonth += ($payroll->amount/12);
                $t_incentive += $payroll->adjustment;
                $t_amount += $payroll->amount;            
             
                array_push($data_excel[$x],array(
                                $payroll->fullName,
                                $payroll->teamleader,
                                $payroll->location,
                                number_format($payroll->present,4),
                                number_format($payroll->absent,4),
                                number_format($payroll->leave,4),
                                number_format($payroll->suspended,4),
                                number_format($payroll->adjustment_days,4),
                                number_format($payroll->rate,4),
                                number_format($payroll->present_amount,4),
                                number_format(($payroll->cola * $payroll->present),4),
                                number_format($payroll->adjustment,4),
                                number_format($payroll->sss_amount,4),
                                number_format($payroll->hdmf_amount,4),
                                number_format($payroll->philhealth_amount,4),
                                number_format($payroll->sss_loan_amount,4),
                                number_format($payroll->hdmf_loan_amount,4),
                                number_format($payroll->amount,4)
                                )

                );
                
            }
          
        }
        
        
            
        $cutoff = Cutoff::where('id',$id)->first();
       
       $data_excel['Total'] = $x;
    // If export to excel was set
        Excel::create('PayrollSummary'.$id.date('Ymd').'', function($excel) use($data_excel) {
            for($xx = 1; $xx <= $data_excel['Total']; $xx++){
                $data_excel['current'] = $xx;
                $shetname = $data_excel['tl'.$xx];
                $excel->sheet($shetname, function($sheet) use($data_excel) {
                    $sheet->fromArray(
                        $data_excel[$data_excel['current']], null, 'A1', false, false
                    );
                });
            }
        })->export('xlsx');
    // End excel

       
    }

    public function payslip(Request $request, $id){
        $idd = explode("|",$id);
        $id = $idd[0];
        $teamleader = $idd[1];
        $location = $idd[2];
        $user_role = Auth::user()->role;
        $payrolls = DB::table('payrolls')
                    ->where('payrolls.cutoff_id','=',$id);
        if($user_role <> 'admin'){
            $payrolls=$payrolls->where('payrolls.contractor',$user_role);
           
        } 
        if($teamleader <> 'ALL'){
            $payrolls=$payrolls->where('payrolls.teamleader',$teamleader);
        }    
        if($location <> 'ALL'){
            $payrolls=$payrolls->where('payrolls.location',$location);
        }     
        $data='';
        $payrolls = $payrolls->get();
        $cutoff = Cutoff::where('id',$id)->first();
        return view('reports.payslip',compact('payrolls','cutoff'));
    }

    public function deductions(Request $request, $id){
        $idd = explode("|",$id);
        $id = $idd[0];
        $teamleader = $idd[1];
        $location = $idd[2];

        $user_role = Auth::user()->role;
        $payrolls = DB::table('payrolls')
                    ->where('payrolls.cutoff_id','=',$id)
                    // Query below will filter only employees with deductions
                    /*->where(function($query){
                        $query->where('sss_amount','>',0)
                            ->orWhere('hdmf_amount','>',0)
                            ->orWhere('philhealth_amount','>',0)
                            ->orWhere('sss_loan_amount','>',0)
                            ->orWhere('hdmf_loan_amount','>',0);
                    })*/                   
                    ;           
        if($user_role <> 'admin'){
            $payrolls=$payrolls->where('payrolls.contractor',$user_role);
        }
        if($teamleader <> 'ALL'){
            $payrolls=$payrolls->where('payrolls.teamleader',$teamleader);
        }
        if($location <> 'ALL'){
            $payrolls=$payrolls->where('payrolls.location',$location);
        }
                
        $data='';
        $payrolls = $payrolls->get();
        $collection = collect($payrolls);
        $unique = $collection->unique('teamleader');
        $unique->values()->toArray();
        foreach($unique as $uniqued){

            $payrolled = collect($payrolls);
            $payroll_per_teamleader = $payrolled->where('teamleader',$uniqued->teamleader)->sortBy('location');
            $payroll_per_teamleader->toArray();
            $data.= '<tr><td colspan="16" style="color:blue;font-size:20px;">Teamleader: '.$uniqued->teamleader.'</td></tr>'; 
        
            $t_sss_amount = 0;
            $t_hdmf_amount = 0;
            $t_philhealth_amount = 0;
            $t_sss_loan_amount = 0;
            $t_hdmf_loan_amount = 0;
     
            foreach($payroll_per_teamleader as $payroll){                
                
                $t_sss_amount += $payroll->sss_amount;
                $t_hdmf_amount += $payroll->hdmf_amount;
                $t_philhealth_amount += $payroll->philhealth_amount;
                $t_sss_loan_amount += $payroll->sss_loan_amount;
                $t_hdmf_loan_amount += $payroll->hdmf_loan_amount;

          
                $data.= '<tr>
                            <td>'.$payroll->fullName.'</td>
                            <td>'.$payroll->teamleader.'</td>
                            <td>'.$payroll->location.'</td>                          
                            <td>'.number_format($payroll->sss_amount,2).'</td>
                            <td>'.number_format($payroll->hdmf_amount,2).'</td>
                            <td>'.number_format($payroll->philhealth_amount,2).'</td>
                            <td>'.number_format($payroll->sss_loan_amount,2).'</td>
                            <td>'.number_format($payroll->hdmf_loan_amount,2).'</td>
                        </tr>';
                
            }
             $data.= '<tr style="color:blue;font-size:14px;">
                            <td>TOTAL: </td>                        
                            <td colspan="2">&nbsp;</td>                                                        
                            <td>'.number_format($t_sss_amount,2).'</td>
                            <td>'.number_format($t_hdmf_amount,2).'</td>
                            <td>'.number_format($t_philhealth_amount,2).'</td>
                            <td>'.number_format($t_sss_loan_amount,2).'</td>
                            <td>'.number_format($t_hdmf_loan_amount,2).'</td> 
                    </tr>
                    <tr><td><br></td></tr>';
        }
        $header= '<thead>
                    <tr>
                        <th>Employee</th>
                        <td>Teamleader</td>
                        <td>Location</td>                      
                        <td>SSS</td>
                        <td>HDMF</td>
                        <td>Philhealth</td>
                        <td>SSS Loan</td>
                        <td>HDMF Loan</td>   
                    </tr>
                </thead>';
        $footer= '<tfoot>
                    
                </tfoot>';
            
        $cutoff = Cutoff::where('id',$id)->first();
        $title = 'Payroll Deductions<br><small>'.$cutoff->start.' to '.$cutoff->end.'</small>';
        $report = [
            'header' => $header,
            'data' => $data,
            'footer' => $footer,
            'title' => $title
        ];
        return view('reports.deductions',compact('report'));
    }

    public function ppe_schedule(Request $request, $id){       
        $user_role = Auth::user()->role;
        $employees = Employee::where('active',1)
                    ->whereMonth('birthDate', $id);
        if($user_role <> 'admin'){
            $employees=$employees->where('contractor',$user_role);
           
        } 
      
        $data='';
        $employees = $employees->orderBy('teamleader','asc')->get();      
        $monthName = date('F', strtotime("2012-$id-01"));
        return view('reports.ppe_schedule',compact('employees','monthName'));
    }
    public function masterlist(Request $request, $id){       
        $user_role = Auth::user()->role;
        $employees = Employee::where('active',1);
        //$employees = Employee::all();
        if($user_role <> 'admin'){
            $employees = $employees->where('contractor',$user_role);           
        } 
      
        $data='';
        $employees = $employees->orderBy('teamleader','asc')->get();      
        return view('reports.masterlist',compact('employees'));
    }

    public function statutories(Request $request, $id){
        $idd = explode("|",$id);
        $id = $idd[0];
        $teamleader = $idd[1];
        $cutoffs = DB::table('cutoffs')->where('id',$id)->first();
        $day = date('d',strtotime($cutoffs->payroll));
        $user_role = Auth::user()->role;
        $payrolls = DB::table('dtr')->leftJoin('employees', 'dtr.employee_id', '=', 'employees.id')
                    ->select('employees.fullName','dtr.employee_id','employees.sss_contribution','employees.hdmf_contribution','employees.philhealth_contribution','dtr.location','dtr.teamleader')                   
                    ->where('dtr.cutoff_id','=',$id);        
        if($user_role <> 'admin'){
            $payrolls=$payrolls->where('employees.contractor',$user_role);
        }
        if($teamleader <> 'ALL'){
            $payrolls=$payrolls->where('employees.teamleader',$teamleader);
        }
                
        $data='';
       
        $header= '<thead>
                    <tr style="font-weight:bold;font-size:14px style="text-align:right;">                       
                        <th>Employee&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
                        <td>Teamleader&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                        <td>Location</td>
                       
                        <td>SSS</td>
                        <td>HDMF</td>
                        <td>Philhealth</td>
                        <td>HDMF Loan</td>
                        <td>SSS Loan</td>                                            
                    </tr>
                </thead>';

        $payrolls = $payrolls->distinct()->get();
        //$payrolls->
        $collection = collect($payrolls);
        $unique = $collection->unique('teamleader');
        $unique->values()->toArray();
        $x=0;
        foreach($unique as $uniqued){
            $x++;
            $payrolled = collect($payrolls);
            $payroll_per_teamleader = $payrolled->where('teamleader',$uniqued->teamleader)->sortBy('location');
            $payroll_per_teamleader->toArray();
            
            $data.= '<tr><td colspan="19" style="color:blue;font-size:20px;">Teamleader: '.$uniqued->teamleader.'</td></tr>';            
            $t_sss_amount = 0;
            $t_hdmf_amount = 0;
            $t_philhealth_amount = 0;  
            $hdmf_loan_amount = 0;
            $sss_loan_amount = 0;         
            foreach($payroll_per_teamleader as $payroll){
                
                if($day==15){
                    $loans = new Loans();
                    $sss_loan_amount = $loans->getAmountToDeductSSS($payroll->employee_id,'SSS',$cutoffs->payroll);
                    $hdmf_loan_amount = $loans->getAmountToDeductHDMF($payroll->employee_id,'HDMF',$cutoffs->payroll);                   
                    $statutory = 0;
                 
                    
                  
                    $data.= '<tr style="font-size:14px;">
                            <td style="width:500px;">'.$payroll->fullName.'</td>
                                <td>'.$payroll->teamleader.'</td>
                                <td>'.$payroll->location.'</td>                               
                                <td style="text-align:right;">0.00</td>
                                <td style="text-align:right;">0.00</td>
                                <td style="text-align:right;">0.00</td>
                                <td style="text-align:right;">'.number_format($hdmf_loan_amount,2).'</td> 
                                <td style="text-align:right;">'.number_format($sss_loan_amount,2).'</td>                                 
                        </tr>';
                }
                else{
                    $t_sss_amount += $payroll->sss_contribution;
                    $t_hdmf_amount += $payroll->hdmf_contribution;
                    $t_philhealth_amount += $payroll->philhealth_contribution;
                    $data.= '<tr style="font-size:14px;">
                            <td style="width:500px;">'.$payroll->fullName.'</td>
                                <td>'.$payroll->teamleader.'</td>
                                <td>'.$payroll->location.'</td>                               
                                <td style="text-align:right;">'.number_format($payroll->sss_contribution,2).'</td>
                                <td style="text-align:right;">'.number_format($payroll->hdmf_contribution,2).'</td>
                                <td style="text-align:right;">'.number_format($payroll->philhealth_contribution,2).'</td>
                                <td style="text-align:right;">0.00</td>
                                <td style="text-align:right;">0.00</td>                                
                        </tr>';                  
                }
            }
             $data.= '
             <tr style="color:blue;font-size:14px style="text-align:right;">
                            <td>TOTAL: </td>                        
                            <td>&nbsp;</td>                            
                            <td>&nbsp;</td>
                           
                            <td style="text-align:right;">'.number_format($t_sss_amount,2).'</td>
                            <td style="text-align:right;">'.number_format($t_hdmf_amount,2).'</td>
                            <td style="text-align:right;">'.number_format($t_philhealth_amount,2).'</td>
                           
                    </tr>
                    <tr><td><br></td></tr>';
        }
        
        $footer= '<tfoot>
                    
                </tfoot>';
            

        $title = 'Payroll Summary<br><small>'.$cutoffs->start.' to '.$cutoffs->end.'</small>';
        $report = [
            'header' => $header,
            'data' => $data,
            'footer' => $footer,
            'title' => $title
        ];
        $data_excel['Total'] = $x;
        return view('reports.payroll',compact('report'));
    }
    public function resigned(Request $request){       
        $user_role = Auth::user()->role;
        $employees = Employee::where('active',0);
        if($user_role <> 'admin'){
            $employees = $employees->where('contractor',$user_role);           
        } 
      
        $data='';
        $employees = $employees->orderBy('teamleader','asc')->get();
        foreach($employees as $ee){
            $remarks = $ee->resignedRemarks;
           
           /* if($ee->resignedRemarks==''){
                $l = Violation::where('employee_id',$ee->id)->orderBy('incidentDateStart','desc')->first();
                $remarks = $l->details;
            }
            */

            $data.='<tr>
                        <td>'.$ee->fullName.'</td>
                        <td>'.$ee->teamleader.'</td>
                        <td>'.$ee->location.'</td>
                        <td>'.$ee->resignedDate.'</td>
                        <td>'.$remarks.'</td>
                    </tr>';
        }
        $header='
            <thead>
                <tr>                        
                    <th>Employee</th>
                    <td>Teamleader</td>
                    <td>Location</td>                      
                    <td>Resigned Date</td>
                    <td>Remarks</td>
                </tr>
            </thead>';
        $footer= '<tfoot>
                    
                </tfoot>'; 
        $title = 'Resigned Employees<br><small>Since '.$request->fdate.'</small>';
        $report = [
            'header' => $header,
            'data' => $data,
            'footer' => $footer,
            'title' => $title
        ]; 
        return view('reports.resigned',compact('report'));
    }
}
