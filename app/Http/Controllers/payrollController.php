<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Cutoff;
use DB;
use App\Payroll;
use App\Employee;
use Session;
use Auth;
use App\Setting;
use App\PayrollRate;
use App\Loans;
use App\Dtr;

class payrollController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $payroll = Cutoff::orderBy('id','desc')->get();
        return view('payroll.index',compact('payroll'));
    }


    public function testx(){
        $loans = new Loans();
        $id = 2182;
        $c = 46;
        return $loans->getAmountToDeductSSS($id,'SSS','2018-11-15');

    }

    public function test($id = 525,$cutoff = 45,$teamleader_f = 'ENEREZ,RICARDO',$location_f = 'SETTLING POND GROUP1'){
        
        $payroll = DB::table('payrolls')->where('employee_id', $id)->where('cutoff_id',$cutoff)->where('teamleader',$teamleader_f)->where('location',$location_f)->first();
        $cutoffs = DB::table('cutoffs')->where('id',$cutoff)->first();
        $day = date('d',strtotime($cutoffs->payroll));
        $e = DB::table('employees')->where('id',$id)->first();
        
        $rated = DB::table('payroll_rates')->where('location','=',$location_f)->where('teamleader','=',$teamleader_f)->where('cutoff_id','=',$cutoff)->first();
        
        if ($rated === null) {           
            $rate = $e->rate;
        }
        else{
            if($rated->rate<=0){
                $rate = $e->rate;       
            }
            else{
                $rate = $rated->rate;
            }
        }              
        $setting = new Setting();
        $xxx='';
        // Default Data

            $data['rate'] = $rate;
            $data['cutoff_id'] = $cutoff;
            $data['employee_id'] = $id;
            $data['leave'] = DB::table('dtr')->where('isLeave','=','1')->where('employee_id','=',$id)->where('cutoff_id','=',$cutoff)->where('teamleader',$teamleader_f)->where('location',$location_f)->count();
            $data['leave_amount'] = $data['rate'] * $data['leave'];

            $data['present'] = DB::table('dtr')->where('tayp','=','PRESENT')->where('employee_id','=',$id)->where('cutoff_id','=',$cutoff)->where('teamleader',$teamleader_f)->where('location',$location_f)->count();
            $data['present_amount'] = $data['rate'] * $data['present'];

            $data['absent'] = DB::table('dtr')->where('tayp','=','ABSENT')->where('employee_id','=',$id)->where('cutoff_id','=',$cutoff)->where('teamleader',$teamleader_f)->where('location',$location_f)->count();
            $data['absent_amount'] = $data['rate'] * $data['absent'];

            $data['suspended'] = DB::table('dtr')->where('isSuspended','=','1')->where('employee_id','=',$id)->where('cutoff_id','=',$cutoff)->where('teamleader',$teamleader_f)->where('location',$location_f)->count();
            $data['suspended_amount'] = $data['rate'] * $data['suspended'];

            $data['cola'] = $setting->cola($e->id);
            $cola_total = $data['cola'] * $data['present'];
            $data['location'] = $location_f;
            $data['teamleader'] = $teamleader_f;
            $data['fullName'] = $e->fullName;
            $data['sss'] = $e->sss;
            $data['hdmf'] = $e->hdmf;
            $data['philhealth'] = $e->philhealth;
            $data['contractor'] = $e->contractor;
            $data['payroll_date'] = $cutoffs->payroll;
            $loans_total_amount = 0;

            // Check if Already government premiums are already deducted from other teamleader or locations.
            $existing_payroll = DB::table('payrolls')->where('employee_id', $id)->where('cutoff_id',$cutoff)
                            ->where(function($query)use($teamleader_f,$location_f){
                                $query->where('teamleader','<>',$teamleader_f)->orWhere('location','<>',$location_f);
                            })
                            ->where(function($query){
                                $query->where('sss_amount','>',0)->orWhere('hdmf_amount','>',0)->orWhere('philhealth_amount','>',0)->orWhere('sss_loan_amount','>',0)->orWhere('hdmf_loan_amount','>',0);
                            })
                            ->first();

            // if no deductions yet
            if ($existing_payroll === null) {

                // If employee has less than 4 duty days then dont deduct anything on its payroll  
                if($data['present']< 4 ){
                    $data['sss_amount'] = 0;
                    $data['hdmf_amount'] = 0;
                    $data['philhealth_amount'] = 0;
                    $data['sss_loan_amount'] = 0;
                    $data['hdmf_loan_amount'] = 0;
                    $statutory = 0;
                    $loans_total_amount = 0;
                }

                // if more than or equal to 4 days then process deduction
                else{                 
                    if($day==15){
                        $data['sss_amount'] = 0;
                        $data['hdmf_amount'] = 0;
                        $data['philhealth_amount'] = 0;

                        $loans = new Loans();
                        $data['sss_loan_amount'] = $loans->getAmountToDeductSSS($e->id,'SSS',$cutoffs->payroll);
                        $data['hdmf_loan_amount'] = $loans->getAmountToDeductHDMF($e->id,'HDMF',$cutoffs->payroll);
                        $data['sss_loan_id'] = $loans->getLoanId($e->id,'SSS',$cutoffs->payroll);
                        $data['hdmf_loan_id'] = $loans->getLoanId($e->id,'HDMF',$cutoffs->payroll);
                        $statutory = 0;
                        $loans_total_amount = $data['sss_loan_amount'] +  $data['hdmf_loan_amount'];
                        
                        // Stop deduction of loan if Total Amount is less than Loan total
                        //if($loans_total_amount >= $data['present_amount']){
                        if($data['present']< 4 ){
                            $loans_total_amount = 0;
                            $data['sss_loan_id'] = 0;
                            $data['hdmf_loan_id'] = 0;
                            $data['hdmf_loan_amount'] = 0;
                            $data['sss_loan_amount'] = 0;
                        }

                    }
                    else{
                        $data['sss_amount'] = $e->sss_contribution;
                        $data['hdmf_amount'] = $e->hdmf_contribution;
                        $data['philhealth_amount'] = $e->philhealth_contribution;
                        $data['sss_loan_amount'] = 0;
                        $data['hdmf_loan_amount'] = 0;
                        $statutory = $e->sss_contribution + $e->hdmf_contribution + $e->philhealth_contribution;
                        $loans_total_amount = 0;
                    }
                }
            }

            // if deductions are already deducted from other teamleader and location
            else{
                    $data['sss_amount'] = 0;
                    $data['hdmf_amount'] = 0;
                    $data['philhealth_amount'] = 0;
                    $data['sss_loan_amount'] = 0;
                    $data['hdmf_loan_amount'] = 0;
                    $statutory = 0;
                    $loans_total_amount = 0;
            }

        // if No Payroll yet, then insert a new record
        if ($payroll === null) {            
            $data['adjustment'] = 0;
            $data['adjustmentRemarks'] = '';
            $data['adjustment_days'] = 0;            
            $data['status'] = '0';
            $data['amount'] = ($data['present_amount'] + $cola_total) - ($statutory + $loans_total_amount);
           /*
            foreach($data as $a => $b){
                $xxx.=$a." = ".$b."<br>";
            }
            return $xxx;*/
            //$p = Payroll::Create($data);
            //return $p;

        }

        // If payroll exist, then update the current record
        else{
            $data['adjustment'] = $payroll->adjustment_days * $rate;
            $data['adjustmentRemarks'] = $payroll->adjustmentRemarks;
            $data['adjustment_days'] = $payroll->adjustment_days;            
            $data['status'] = $payroll->status;
            $data['amount'] = ($data['present_amount'] + $cola_total + $data['adjustment']) - ($statutory + $loans_total_amount);
            
            /*$p = DB::table('payrolls')
                ->where('id', $payroll->id)
                ->update($data);
            $pay = Payroll::where('id',$payroll->id)->first();*/
            //return $pay;
        }
        return $data;
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function process($id)
    {
        $data='';
        $totalPresent = 0;
        $totalAbsent = 0;
        $totalLeave = 0;
        $totalDelinquent = 0;
        $total = 0;
        $employees = DB::table('dtr')
                    ->leftJoin('employees','dtr.employee_id','=','employees.id')
                    ->distinct()
                    ->select('dtr.employee_id','employees.fullName','employees.empid','employees.id','employees.rate')
                    ->where('dtr.cutoff_id','=',$id)
                    ->get();
        foreach($employees as $ee){
            //$data.=$ee->fullName."<br>";
            $leave = DB::table('dtr')->where('isLeave','=','1')->where('employee_id','=',$ee->employee_id)->where('cutoff_id','=',$id)->count();
            $present = DB::table('dtr')->where('tayp','=','PRESENT')->where('employee_id','=',$ee->employee_id)->where('cutoff_id','=',$id)->count();
            $absent = DB::table('dtr')->where('tayp','=','ABSENT')->where('employee_id','=',$ee->employee_id)->where('cutoff_id','=',$id)->count();
            $delinquent = DB::table('dtr')->where('isSuspended','=','1')->where('employee_id','=',$ee->employee_id)->where('cutoff_id','=',$id)->count();
            $first_dtr = DB::table('dtr')->where('tayp','=','PRESENT')->where('employee_id','=',$ee->employee_id)->where('cutoff_id','=',$id)->first();


            $totalPerEmployee = $leave + $present + $absent + $delinquent;
            
            $totalPresent += $present;
            $totalAbsent += $absent;
            $totalLeave += $leave;
            $totalDelinquent += $delinquent;
            $total += $totalPerEmployee;
            
            /*$data.= '<tr>
                        <td>'.$ee->empid.'</td>
                        <td>'.$ee->fullName.'</td>
                        <td>'.$present.'</td>
                        <td>'.$absent.'</td>
                        <td>'.$leave.'</td>
                        <td>'.$delinquent.'</td>
                        <td>'.$totalPerEmployee.'</td>
                    </tr>';*/
                $payrollamount = $present * $ee->rate;
                if(!isset($first_dtr->location)){$location='NA';}else{$location=$first_dtr->location;}
                if(!isset($first_dtr->teamleader)){$teamleader='NA';}else{$teamleader=$first_dtr->teamleader;}
                $save = payroll::create([
                        'cutoff_id' => $id,
                        'employee_id' => $ee->id,
                        'present' => $present,
                        'absent' => $absent,
                        'leave' => $leave,
                        'suspended' => $delinquent,
                        'rate' => $ee->rate,
                        'cola' => '0',
                        'amount' => $payrollamount,
                        'location' => $location,
                        'teamleader' => $teamleader,
                        'fullName' => $ee->fullName
                ]);


        }
        cutoff::findOrFail($id)->update([
            'isPayrollClosed' => 1,
            'PayrollClosedBy' => Auth::user()->name,
            'PayrollClosedDate' => date('Y-m-d h:i:s'),
        ]);
        
        Session::flash('success','Payroll has been successfully processed!');
        return back();
        
    }

    public function load_adjustment_page($id){

       $locations = Dtr::distinct()->select('location')->where('tayp','PRESENT')->orderBy('location')->get();
       $contractors = Dtr::distinct()->select('teamleader')->where('tayp','PRESENT')->orderBy('teamleader')->get();
       $cutoff = $id;
       return view('payroll.adjustment',compact('locations','contractors','cutoff'));
    }

    public function adjustment(Request $request, $id)
    {

        $user_role = Auth::user()->role;
        $cutoff = Cutoff::where('id',$id)->first();

        if($cutoff->isPayrollClosed==0){

            $employees=DB::table('dtr')->select('employee_id','teamleader','location')->distinct()->where('cutoff_id',$id)->where('tayp','present');         
            $delete_employees = DB::table('payrolls')->where('cutoff_id',$id);
            // filter by location
            $request->location = str_replace("qqqqq", "/", $request->location);
            if($request->location <> 'ALL'){
                $employees=$employees->where('location',$request->location);
                $delete_employees = $delete_employees->where('location',$request->location);
            }            

            // filter by contractor
            if($request->contractor <> 'ALL'){
                $employees=$employees->where('teamleader',$request->contractor);
                $delete_employees = $delete_employees->where('teamleader',$request->contractor);
            }
            $delete_employees = $delete_employees->delete();
            //test
           // $employees = $employees->where('employee_id',94);

            $employees= $employees->orderBy('employee_id','asc')->orderBy('teamleader','asc')->orderBy('location','asc')->get();
            
            $data='
            <table class="table" style="font-size:12px;">
            <tr style="font-weight:bold;">
                    <td>Adjustment <br> (Days)</td>
                    <td>Name</td>
                    <td>Present</td>
                    <td>Absent</td>
                    <td>Leave</td>
                    <td>Suspended</td>
                    <td>Rate</td>
                    <td>Gross</td>
                    <td>Cola</td>
                    <td>SSS</td>
                    <td>HDMF</td>
                    <td>Philhealth</td>
                    <td>SSS Loan</td>
                    <td>HDMF Loan</td>
                    <td>13th Month</td>
                    <td>Net</td>
                    
            </tr>';
            
            //$data='';
            foreach($employees as $employee){
                //$data.=$employee->employee_id." - ".$employee->teamleader." - ".$employee->location."<br>";
                
                $payroll = $this->get_payroll_data($employee->employee_id,$id,$employee->teamleader,$employee->location);
                if($payroll->present>0){
                    $data.='<tr id="rec'.$payroll->id.'">
                            <td><input type="number" onchange="saveadjustment('.$payroll->id.',$(this).val(),'.$id.','.$employee->employee_id.')" step="0.01" id="adj'.$payroll->id.'" name="adj'.$payroll->id.'" data="'.$payroll->id.'" class="form-control adj" value="'.$payroll->adjustment_days.'"></td>
                            <td>'.$payroll->fullName.'</td>
                            <td>'.$payroll->present.'</td>
                            <td>'.$payroll->absent.'</td>
                            <td>'.$payroll->leave.'</td>
                            <td>'.$payroll->suspended.'</td>
                            <td>'.$payroll->rate.'</td>
                            <td>'.$payroll->present_amount.'</td>
                            <td>'.($payroll->cola * $payroll->present).'</td>
                            <td>'.$payroll->sss_amount.'</td>
                            <td>'.$payroll->hdmf_amount.'</td>
                            <td>'.$payroll->philhealth_amount.'</td>
                            <td>'.$payroll->sss_loan_amount.'</td>
                            <td>'.$payroll->hdmf_loan_amount.'</td>
                            <td>'.number_format(($payroll->amount/12),2).'</td>
                            <td>'.$payroll->amount.'</td>
                        </tr>';
                }
                
               //return dd($payroll);
            }
            $data.='</table>';
            return $data;
        }

        else{
            return 'Payroll is already closed!';
        }
    }

    public function get_payroll_data($id = 6,$cutoff = 8,$teamleader_f,$location_f){
        
        $payroll = DB::table('payrolls')->where('employee_id', $id)->where('cutoff_id',$cutoff)->where('teamleader',$teamleader_f)->where('location',$location_f)->first();
        $cutoffs = DB::table('cutoffs')->where('id',$cutoff)->first();
        $day = date('d',strtotime($cutoffs->payroll));
        $e = DB::table('employees')->where('id',$id)->first();
        
        $rated = DB::table('payroll_rates')->where('location','=',$location_f)->where('teamleader','=',$teamleader_f)->where('cutoff_id','=',$cutoff)->first();
        
        if ($rated === null) {           
            $rate = $e->rate;
        }
        else{
            if($rated->rate<=0){
                $rate = $e->rate;       
            }
            else{
                $rate = $rated->rate;
            }
        }              
        $setting = new Setting();
        $xxx='';
        // Default Data

            $data['rate'] = $rate;
            $data['cutoff_id'] = $cutoff;
            $data['employee_id'] = $id;
            $data['leave'] = DB::table('dtr')->where('isLeave','=','1')->where('employee_id','=',$id)->where('cutoff_id','=',$cutoff)->where('teamleader',$teamleader_f)->where('location',$location_f)->count();
            $data['leave_amount'] = $data['rate'] * $data['leave'];

            $data['present'] = DB::table('dtr')->where('tayp','=','PRESENT')->where('employee_id','=',$id)->where('cutoff_id','=',$cutoff)->where('teamleader',$teamleader_f)->where('location',$location_f)->count();
            $data['present_amount'] = $data['rate'] * $data['present'];

            $data['absent'] = DB::table('dtr')->where('tayp','=','ABSENT')->where('employee_id','=',$id)->where('cutoff_id','=',$cutoff)->where('teamleader',$teamleader_f)->where('location',$location_f)->count();
            $data['absent_amount'] = $data['rate'] * $data['absent'];

            $data['suspended'] = DB::table('dtr')->where('isSuspended','=','1')->where('employee_id','=',$id)->where('cutoff_id','=',$cutoff)->where('teamleader',$teamleader_f)->where('location',$location_f)->count();
            $data['suspended_amount'] = $data['rate'] * $data['suspended'];

            $data['cola'] = $setting->cola($e->id);
            $cola_total = $data['cola'] * $data['present'];
            $data['location'] = $location_f;
            $data['teamleader'] = $teamleader_f;
            $data['fullName'] = $e->fullName;
            $data['sss'] = $e->sss;
            $data['hdmf'] = $e->hdmf;
            $data['philhealth'] = $e->philhealth;
            $data['contractor'] = $e->contractor;
            $data['payroll_date'] = $cutoffs->payroll;
            $loans_total_amount = 0;

            // Check if Already government premiums are already deducted from other teamleader or locations.
            $existing_payroll = DB::table('payrolls')->where('employee_id', $id)->where('cutoff_id',$cutoff)
                            ->where(function($query)use($teamleader_f,$location_f){
                                $query->where('teamleader','<>',$teamleader_f)->orWhere('location','<>',$location_f);
                            })
                            ->where(function($query){
                                $query->where('sss_amount','>',0)->orWhere('hdmf_amount','>',0)->orWhere('philhealth_amount','>',0)->orWhere('sss_loan_amount','>',0)->orWhere('hdmf_loan_amount','>',0);
                            })
                            ->first();

            // if no deductions yet
            if ($existing_payroll === null) {

                // If employee has less than 4 duty days then dont deduct anything on its payroll  
                if($data['present']< 4 ){
                    $data['sss_amount'] = 0;
                    $data['hdmf_amount'] = 0;
                    $data['philhealth_amount'] = 0;
                    $data['sss_loan_amount'] = 0;
                    $data['hdmf_loan_amount'] = 0;
                    $statutory = 0;
                    $loans_total_amount = 0;
                }

                // if more than or equal to 4 days then process deduction
                else{                 
                    if($day==15){
                        $data['sss_amount'] = 0;
                        $data['hdmf_amount'] = 0;
                        $data['philhealth_amount'] = 0;

                        $loans = new Loans();
                        $data['sss_loan_amount'] = $loans->getAmountToDeductSSS($e->id,'SSS',$cutoffs->payroll);
                        $data['hdmf_loan_amount'] = $loans->getAmountToDeductHDMF($e->id,'HDMF',$cutoffs->payroll);
                        $data['sss_loan_id'] = $loans->getLoanId($e->id,'SSS',$cutoffs->payroll);
                        $data['hdmf_loan_id'] = $loans->getLoanId($e->id,'HDMF',$cutoffs->payroll);
                        $statutory = 0;
                        $loans_total_amount = $data['sss_loan_amount'] +  $data['hdmf_loan_amount'];
                        
                        // Stop deduction of loan if Total Amount is less than Loan total
                        //if($loans_total_amount >= $data['present_amount']){
                        if($data['present']< 4 ){
                            $loans_total_amount = 0;
                            $data['sss_loan_id'] = 0;
                            $data['hdmf_loan_id'] = 0;
                            $data['hdmf_loan_amount'] = 0;
                            $data['sss_loan_amount'] = 0;
                        }

                    }
                    else{
                        $data['sss_amount'] = $e->sss_contribution;
                        $data['hdmf_amount'] = $e->hdmf_contribution;
                        $data['philhealth_amount'] = $e->philhealth_contribution;
                        $data['sss_loan_amount'] = 0;
                        $data['hdmf_loan_amount'] = 0;
                        $statutory = $e->sss_contribution + $e->hdmf_contribution + $e->philhealth_contribution;
                        $loans_total_amount = 0;
                    }
                }
            }

            // if deductions are already deducted from other teamleader and location
            else{
                    $data['sss_amount'] = 0;
                    $data['hdmf_amount'] = 0;
                    $data['philhealth_amount'] = 0;
                    $data['sss_loan_amount'] = 0;
                    $data['hdmf_loan_amount'] = 0;
                    $statutory = 0;
                    $loans_total_amount = 0;
            }

        // if No Payroll yet, then insert a new record
        if ($payroll === null) {            
            $data['adjustment'] = 0;
            $data['adjustmentRemarks'] = '';
            $data['adjustment_days'] = 0;            
            $data['status'] = '0';
            $data['amount'] = ($data['present_amount'] + $cola_total) - ($statutory + $loans_total_amount);
           /*
            foreach($data as $a => $b){
                $xxx.=$a." = ".$b."<br>";
            }
            return $xxx;*/
            $p = Payroll::Create($data);
            return $p;

        }

        // If payroll exist, then update the current record
        else{
            $data['adjustment'] = $payroll->adjustment_days * $rate;
            $data['adjustmentRemarks'] = $payroll->adjustmentRemarks;
            $data['adjustment_days'] = $payroll->adjustment_days;            
            $data['status'] = $payroll->status;
            $data['amount'] = ($data['present_amount'] + $cola_total + $data['adjustment']) - ($statutory + $loans_total_amount);
            
            $p = DB::table('payrolls')
                ->where('id', $payroll->id)
                ->update($data);
            $pay = Payroll::where('id',$payroll->id)->first();
            return $pay;
        }
    }

    public function save_adjustment(Request $request, $id){
        $data['adjustment_days'] = $request->val;
        $p = DB::table('payrolls')->where('id',$request->pay_id)->update($data);
        $ps = DB::table('payrolls')->where('id',$request->pay_id)->first();
        $payroll = $this->get_payroll_data($request->empid,$id,$ps->teamleader,$ps->location);
        $rec='
                    <td><input type="number" onchange="saveadjustment('.$payroll->id.',$(this).val(),'.$id.','.$payroll->employee_id.')" step="0.01" id="adj'.$payroll->id.'" name="adj'.$payroll->id.'" data="'.$payroll->id.'" class="form-control adj" value="'.$payroll->adjustment_days.'"></td>
                    <td>'.$payroll->fullName.'</td>
                    <td>'.$payroll->present.'</td>
                    <td>'.$payroll->absent.'</td>
                    <td>'.$payroll->leave.'</td>
                    <td>'.$payroll->suspended.'</td>
                    <td>'.$payroll->rate.'</td>
                    <td>'.$payroll->present_amount.'</td>
                    <td>'.($payroll->cola * $payroll->present).'</td>
                    <td>'.$payroll->sss_amount.'</td>
                    <td>'.$payroll->hdmf_amount.'</td>
                    <td>'.$payroll->philhealth_amount.'</td>
                    <td>'.$payroll->sss_loan_amount.'</td>
                    <td>'.$payroll->hdmf_loan_amount.'</td>
                    <td>'.number_format(($payroll->amount/12),2).'</td>
                    <td>'.$payroll->amount.'</td>
                ';
        return $rec;
       
    }

    public function getcontractorlocationlist(){
        $url = "http://172.16.20.48/cm/contractors-api.php?locationonly=on";
        $json = file_get_contents($url);
        $obj = json_decode($json);        
        return $obj;
    }

    public function getcontractorlist(){
        $url = "http://172.16.20.48/cm/contractors-api.php?contractoronly=on";
        $json = file_get_contents($url);
        $obj = json_decode($json);        
        return $obj;
    }

    public function locationlist($default='')
    {
        $contractors = $this->getcontractorlocationlist();
        $contractor_options = '';
        foreach($contractors as $contractor){
            $contractor_options .= '<option value="'.$contractor->location.'">'.$contractor->location.'</option>';
        }
        return $contractor_options;
    }

    public function contractorlist($default='')
    {
        $contractors = $this->getcontractorlist();
        $contractor_options = '';
        foreach($contractors as $contractor){
            $contractor_options .= '<option value="'.$contractor->contractor.'">'.$contractor->contractor.'</option>';
        }
        return $contractor_options;
    }

    public function delete_record_option($id){
        $locations = Dtr::distinct()->select('location')->where('tayp','PRESENT')->orderBy('location')->get();
        $contractors = Dtr::distinct()->select('teamleader')->where('tayp','PRESENT')->orderBy('teamleader')->get();
        $cutoff = $id;
        return view('payroll.delete_records',compact('locations','contractors','cutoff'));
    }

    public function delete_records(Request $request, $id){
        $payroll = DB::table('payrolls')->where('cutoff_id',$id);
        $dtr = DB::table('dtr')->where('cutoff_id',$id);
            // filter by location
            if($request->location <> 'ALL'){
                $payroll->where('location',$request->location);
                $dtr->where('location',$request->location);
            }            

            // filter by contractor
            if($request->contractor <> 'ALL'){
                $payroll->where('teamleader',$request->contractor);
                $dtr->where('teamleader',$request->contractor);
            }

            $delete_payroll = $payroll->delete();
            $delete_dtr = $dtr->delete();


    }
}
