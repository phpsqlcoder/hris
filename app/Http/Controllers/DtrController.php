<?php

namespace App\Http\Controllers;

use App\Dtr;
use Illuminate\Http\Request;
use Session;
use App\Cutoff;
use App\Employee;
use App\Shift;
use App\Leave;
use App\Biologs;
use DB;
use Auth;
use Excel;
use Carbon;

class DtrController extends Controller
{
    
    public function index()
    {
        $dtr = Cutoff::orderBy('id','desc')->get();
        return view('dtr.index',compact('dtr'));
    }

    
    public function create()
    {
        $cutoffs = Cutoff::all();
        return view('dtr.add',compact('cutoffs'));
    }

    public function download_bm(){

        $bm = $this->bm_list();
        return view('dtr.bms',compact('bm'));
    }

    public function bm_list(){
        $list = array(
            'Mine Timehouse1' => '172.16.44.120',
            'Mine Timehouse2' => '172.16.44.121',
            'Level 8' => '172.16.44.118'
        );

        return $list;
    }
    
    public function download_bm_generate(Request $request){

        $dated['start'] = $request->start;
        $dated['end']= $request->end;

        

        $employees=Employee::where('id','>','0')->where('active','<>','0');
        
        $employees = $employees->orderBy('teamleader','desc')->orderBy('location','desc')->get();
        
        $dated['employees'] = array();
        foreach($employees as $employee){
            $ar = array();
            $ar = array($employee->id,$employee->fullName,$employee->teamleader,$employee->location);            
            $xst = $request->start;
            $xen= $request->end;
            while (strtotime($xst) <= strtotime($xen)) {
                $detstart = date('Y-m-d H:i:s',strtotime($xst.' 00:00:00'));
                $detend = date('Y-m-d H:i:s',strtotime($xst.' 23:59:59'));
                if (Biologs::where('biometric_id','=',$employee->biometricId)->where('log','>=',$detstart)->where('log','<=',$detend)->count() > 0) {
                    array_push($ar,'1');
                }
                else{
                    array_push($ar,'0');
                } 

                $xst = date ("Y-m-d", strtotime("+1 day", strtotime($xst)));
            } 
            array_push($dated['employees'],$ar);         
        }
        // End Employees

        Excel::create(date('Ymdhis'), function($excel) use($dated) {

            $excel->sheet(date('Ymdhis'), function($sheet) use($dated) {
                $sheet->fromArray($dated['employees']);
                $heading = array('id','employee_name','teamleader','location');

                while (strtotime($dated['start']) <= strtotime($dated['end'])) {
                    array_push($heading,$dated['start']);                
                    $dated['start'] = date ("Y-m-d", strtotime("+1 day", strtotime($dated['start'])));
                }
                array_push($heading,"INCENTIVE");

                $sheet->row(1, $heading);
            });

        })->download('xlsx');    

    }

    public function download_bm_generate_raw(Request $request){

        $dated['start'] = $request->start;
        $dated['end']= $request->end;

        

        $employees=Employee::where('id','>','0');
        
        $employees = $employees->orderBy('teamleader','desc')->orderBy('location','desc')->get();
        
        $dated['employees'] = array();
        foreach($employees as $employee){
            $ar = array();
            $ar = array($employee->id,$employee->fullName,$employee->teamleader,$employee->location);            
            $xst = $request->start;
            $xen= $request->end;
            while (strtotime($xst) <= strtotime($xen)) {
                $raw = Biologs::where('biometric_id','=',$employee->biometricId)->where('log_date','=',$xst)->get();
                $d = '';
                foreach($raw as $r){
                    $d.= ($r->type==1 ? 'TimeOut: ' : 'TimeIn: ').$r->log."  ";
                }
                array_push($ar,$d);   
                $xst = date ("Y-m-d", strtotime("+1 day", strtotime($xst)));
            } 
            array_push($dated['employees'],$ar);         
        }
        // End Employees

        Excel::create(date('Ymdhis'), function($excel) use($dated) {

            $excel->sheet(date('Ymdhis'), function($sheet) use($dated) {
                $sheet->fromArray($dated['employees']);
                $heading = array('id','employee_name','teamleader','location');

                while (strtotime($dated['start']) <= strtotime($dated['end'])) {
                    array_push($heading,$dated['start']);                
                    $dated['start'] = date ("Y-m-d", strtotime("+1 day", strtotime($dated['start'])));
                }
                array_push($heading,"INCENTIVE");

                $sheet->row(1, $heading);
            });

        })->download('xlsx');    

    }

    public function store(Request $request)
    {
        //
    }

   
    public function show(Dtr $dtr)
    {
        //
    }

   
    public function edit(Dtr $dtr)
    {
        //
    }

    
    public function update(Request $request, Dtr $dtr)
    {
        //
    }

   
    public function destroy(Dtr $dtr)
    {
        //
    }

    public function getform(Request $request)
    {
       
        $dyt = $request['dyt'];
        $cutoff = $request['cutoff'];

        // Contractor List
        $contractors = $this->getcontractorlist();
        $contractor_options = '';
        foreach($contractors as $contractor){
            $contractor_options .= '<option value="'.$contractor->contractor.'|'.$contractor->contractorCode.'|'.$contractor->location.'"> '.$contractor->contractor.' - '.$contractor->location.' </option>';
        }

        // DTR Type List
        $types = $this->gettypelist();
        $typelist = '';
        foreach($types as $type){
             $type_name = (substr($type, -6)=='|leave' ? substr($type,0,-6):$type);
             $typelist .= '<option value="'.$type.'"> '.$type_name.' </option>';
        }

         //\Log::info($contractor_options); return;
        $data='<table class="table" style="font-size:12px;">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Employee</th>
                    <th>Date</th>
                    <th>Type</th>                    
                    <th>Shift</th>
                    <th>Location</th>
                    <th>Status</th>
                </tr>
            </thead>
        ';

        $user_role = Auth::user()->role;
        if($user_role == 'admin'){
            $employee=Employee::where('id','>','0');
        }
        else{
            $employee=Employee::where('contractor',$user_role);
        }

        $employee = $employee->where('active','1')->orderBy('lName')->orderBy('fName')->get();
        foreach($employee as $e){
            // Get the employee's DTR
            $emp = Dtr::where('employee_id','=',$e->id)->where('dtrDate','=',$dyt)->first();

            // Add new If Employee has no DTR yet.
            if($emp === null){
                $emp = Dtr::Create([
                        'employee_id' => $e->id,
                        'dtrDate' => $dyt,
                        'cutoff_id' =>  $cutoff,
                        'shift_id' =>  '0'
                    ]);    
            }

            // List of conditions for default values for DTR with data already
            if($emp->shift_id <> '0' && $emp->tayp <> NULL && $emp->location <> NULL){
                $style = 'style="color:blue;font-weight:bold;"';
                $status = '<span class="label label-primary">Saved</span>';
            }
            else{
                $style = '';
                $status = '';
            }

            // Check if Employee has been suspended or On leave
            $isDisableEditing = '';
            if($emp->isLeave==1 || $emp->isSuspended==1){
                $isDisableEditing = 'disabled="disabled"';
                if($emp->isLeave==1){
                    $options = '<td colspan="4" style="text-align:center;">'.Leave::where('id',$emp->tayp)->first()->name.'</td>';    
                }
                if($emp->isSuspended==1){
                    $options = '<td colspan="4" style="text-align:center;color:red;">SUSPENDED</td>';    
                }
            }
            else{
                $default_shift = ($emp->shift_id=='0' ? '<option value="0" selected="selected"> - Select Shift - </option>': $this->getshiftname($emp->shift_id));
                $default_type = ($emp->tayp == NULL ? '<option value="" selected="selected"> - Select Type - </option>': '<option value="'.$emp->tayp.'" selected="selected"> '.$emp->tayp.' </option>');
                $default_location = ($emp->location == NULL ? '<option value="" selected="selected"> - Select location - </option>': '<option value="'.$emp->teamleader.'|'.$emp->id.'|'.$emp->location.'" selected="selected"> '.$emp->teamleader.' - '.$emp->location.' </option>');

                $options = '<td><select class="form-control input-sm" '.$isDisableEditing.' id="type'.$emp->id.'" data="'.$emp->id.'" onchange=\'savedtr($( this ).attr("data"));\'> '.$default_type.$typelist.' </select></td>                        
                        <td><select class="form-control input-sm" '.$isDisableEditing.' id="shift'.$emp->id.'" data="'.$emp->id.'" onchange=\'savedtr($( this ).attr("data"));\'>'.$default_shift.$this->getshiftlist().'</select></td>
                        <td><select class="form-control input-sm" '.$isDisableEditing.' id="contractor'.$emp->id.'" data="'.$emp->id.'" onchange=\'savedtr($( this ).attr("data"));\' style="width:200px;">'.$default_location.$contractor_options.'</select></td>
                        <td align="center" style="vertical-align:middle;"><span id="stat'.$emp->id.'">'.$status.'</span></td>';
            }
            // If Posted, replace the value of $options to readonly
            if($emp->isPosted == 1){
                $options='
                        <td>'.$default_type.'</td>                        
                        <td>'.$default_shift.'</select></td>
                        <td>'.$default_location.'</select></td>
                        <td align="center" style="vertical-align:middle;"><span class="label bg-blue">Posted</span></td>';
            }
            
            // Display all the DTR data
            $data.='<tr>
                        <td style="vertical-align:middle;">'.$e->empid.'</td>
                        <td style="vertical-align:middle;">'.$e->fullName.'</td>
                        <td '.$style.' id="dyttd'.$emp->id.'" style="vertical-align:middle;">'.$dyt.'</td>
                        '.$options.'
                </tr>'; 
          
        }        
        $data.='</table>';

        return $data;
        
    }

    public function saverecord(Request $request, $id)
    {
        $dtr = Dtr::findOrFail($id);
        $type_selected = $request->stype;
        $isLeave=0;
        if((substr($request->stype, -6))=='|leave'){
            $leave_id=Leave::where('name','=',(substr($request->stype,0,-6)))->first();
            $type_selected = $leave_id->id;
            $isLeave = 1;
        }
        $dtr->update([
            'tayp' => $type_selected,
            'location' => $request->slocation,
            'teamleader' => $request->scontractorname,
            'shift_id' => $request->sshift,
            'isLeave' => $isLeave     
        ]);
        return '<span class="label label-primary">Saved </span>';
    }

    public function getshiftlist(){
        $shifts=Shift::where('id','>',0)->get();
        $data='';
        foreach($shifts as $shift){
            $data.='<option value="'.$shift->id.'">'.$shift->name;
        }
        return $data;
    }

    public function getshiftname($id){
        $shift=Shift::where('id','=',$id)->first();
        return '<option value="'.$shift->id.'" selected="selected">'.$shift->name.'</option>';       
    }

    public function getcontractorlist($contractor = NULL){
        $url = "http://172.16.20.48/cm/contractors-api.php";
        if($contractor<>NULL){$url = $url."&contractor=".$contractor;}
        $json = file_get_contents($url);
        $obj = json_decode($json);        
        return $obj;
    }

    public function getleavelist(){
       $leaves=leave::all();
        $data=array();
        foreach($leaves as $leave){
            $data[]=$leave->name."|leave";
        }
        return $data;
    }

    public function gettypelist($selected = NULL){
        $data = array_merge(array('PRESENT','ABSENT'),$this->getleavelist());
        return $data;
    }

    public function getWorkHistoryPerEmployee(Request $request){
       $employee = Employee::where('id',$request->employee_id)->first();
       $dtrs = Dtr::where('employee_id',$request->employee_id)->where('dtrDate','>=',$request->start)->get();
       $data='';
       $teamleader = '';
       $location = '';
       foreach ($dtrs as $dtr) {
            if($location<>$dtr->location || $teamleader<>$dtr->teamleader){
                $location = $dtr->location;
                $teamleader = $dtr->teamleader;
                $data.='<tr>
                       <td>'.$dtr->dtrDate.'</td>
                       <td>'.$dtr->location.'</td>
                       <td>'.$dtr->teamleader.'</td>
                   </tr>';
            }            
       }
       return '<table class="table" style="font-size:12px;">
                <tr>
                    <th>Date</th>
                    <th>Location</th>
                    <th>Teamleader</th>
                </tr>
       '.$data.'</table>';
    }

    public function getDTRperEmployee(Request $request){
       $employee = Employee::where('id',$request->employee_id)->first();
       $emps = Dtr::where('employee_id',$request->employee_id)
       //->where('dtrDate','>=',$request->start)
       //->where('dtrDate','<=',$request->end)
       ->orderBy('dtrDate')
       ->get();
        //->whereRaw("dtrDate between '".$request->start."' and '".$request->end."'")
       $data='';
      
       foreach ($emps as $emp) {            
            if($emp->isLeave==1 || $emp->isSuspended==1){
                $isDisableEditing = 'disabled="disabled"';
                if($emp->isLeave==1){
                    $options = '<td colspan="4" style="text-align:center;">'.Leave::where('id',$emp->tayp)->first()->name.'</td>';    
                }
                if($emp->isSuspended==1){
                    $options = '<td colspan="4" style="text-align:center;color:red;">SUSPENDED</td>';    
                }
            }
            else{
                $default_shift = ($emp->shift_id=='0' ? '': $this->getshiftname($emp->shift_id));
                $default_type = ($emp->tayp == NULL ? '': $emp->tayp);
                $default_location = ($emp->location == NULL ? '': $emp->teamleader.' - '.$emp->location);
                 $options='
                        <td>'.$default_type.'</td>                        
                        <td>'.$default_shift.'</select></td>
              
                        <td align="center" style="vertical-align:middle;"><span class="label bg-blue">Posted</span></td>';
            }

               
       
            
            // Display all the DTR data
            $data.='<tr>
                        <td style="vertical-align:middle;">'.$employee->empid.'</td>
                        <td style="vertical-align:middle;">'.$employee->fullName.'</td>
                        <td id="dyttd'.$emp->id.'" style="vertical-align:middle;">'.$emp->dtrDate.'</td>
                        '.$options.'
                </tr>';
       }
       return '<table class="table" style="font-size:12px;">
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Date</th>
                    <th>Type</th>
                    <th>Shift</th>
                  
                    <th>Status</th>
                </tr>
       '.$data.'</table>';
    }

    public function excel_post(Request $request)
    {
        $results = Excel::load($request->xls, function($reader) {
            
        })->get();
          //  $datas=$results->department."xxx";
            $datas='';
            foreach($results as $result => $val){
                //$datas.=$val->timetable1."<br>";
                if($val->timetable1 <>'' && $val->employee_id<>''){
                    $emp = Employee::where('biometricId',$val->employee_id)->first();
                    if($emp === null){

                    }
                    else{
                        $cu = new Cutoff();
                        $da['employee_id'] = $emp->id;
                        $da['cutoff_id'] =  $cu->getCutoffId($val->date);
                        $da['tayp'] = 'PRESENT';
                        $da['location'] = $emp->location;
                        $da['teamleader'] = $emp->teamleader;
                        $da['shift_id'] = 1;
                        $da['dtrDate'] = $val->date;


                        $dtr = Dtr::where('employee_id',$emp->id)->where('dtrDate',$val->date)->first();
                        if($dtr === null){
                            $p = Dtr::Create($da);                            
                        }
                        else{
                            $da['isLeave'] = 0;
                            $da['isSuspended'] = 0;
                            $p = DB::table('dtr')
                            ->where('id', $dtr->id)
                            ->update($da);
                        }
                    }
                }                
            }
            Session::flash('success','Biometric logs has been processed');
            return redirect ('/dtr/uploadexcel');  
           // return $datas;
            //return $results->count();
    }

    public function dtr_post(Request $request)
    {
        $heads = Excel::load($request->xls, function($reader) {
            
        })->formatDates(false)->first();

        $results = Excel::load($request->xls, function($reader) {
            
        })->get()->toArray();
          $datas='';
          $x=0;
          $y=0;
            foreach($heads as $h => $e){            
                $x++;
                if($x>=5 && $h<>'incentive'){
                    $y++;
                    $hh['daterec'][$y] = $h;  
                    $hx = str_replace("_", "-", $h);
                    $hh['date'][$y] = date('Y-m-d',strtotime("1899-12-30 + $h days")); 
                    $hdate[$y] = $hx;    
                }
                //$datas.=$h."<br>";
            }
            
            foreach($results as $result => $val){
                $e = Employee::where('id',$val['id'])->first();
                //$datas.='<tr><td></td><td>'.$val['employee_name'].'</td></tr>';
                if($e === null){
                    
                }
                else{
                    for($c=1;$c<=$y;$c++){

                        
                            $g = $hh['daterec'][$c];
                        if($val[$g]>0){
                            $cu = new Cutoff();
                            $da['employee_id'] = $val['id'];
                            $da['cutoff_id'] =  $cu->getCutoffId($hdate[$c]);
                            $da['tayp'] = 'PRESENT';
                            $da['location'] = $val['location'];
                            $da['teamleader'] = $val['teamleader'];
                            $da['shift_id'] = $val[$g];
                            $da['dtrDate'] = $hdate[$c];
                          

                            $dtr = Dtr::where('employee_id',$val['id'])->where('dtrDate',$hdate[$c])->first();
                            if($dtr === null){
                                $p = Dtr::Create($da);                            
                            }
                            else{
                                $da['isLeave'] = 0;
                                $da['isSuspended'] = 0;
                                $p = DB::table('dtr')
                                ->where('id', $dtr->id)
                                ->update($da);
                            }
                        }
            
                    }
                }
               // $datas.=$result[3]."<br>";
                
            }
            Session::flash('success','DTR has been successfully processed!');
            return back();
            //return '<table>'.$datas.'</table>';
            //return $results->count();
    }

    public function dtr_download_template(Request $request){
        $dated['start'] = $request->startdate;
        $dated['end']= $request->enddate;

        // Employees Filter
        $user_role = Auth::user()->role;
  
        if($user_role == 'admin'){
            $employees=Employee::where('id','>','0');
        }
        else{
            $employees=Employee::where('contractor',$user_role);
        }        
        if($request->teamleader<>''){
            $employees = $employees->where('teamleader',trim($request->teamleader));
            //\Log::info(trim($request->teamleader));
        }
        if($request->location<>''){
            $employees = $employees->where('location','=',trim($request->location));
        }
        $employees = $employees->orderBy('teamleader','desc')->orderBy('location','desc')->get();
       // \Log::info($contractor_options);
        $dated['employees'] = array();
        foreach($employees as $employee){
            array_push($dated['employees'],array($employee->id,$employee->fullName,$employee->teamleader,$employee->location));
        }
        // End Employees

        Excel::create(date('Ymdhis'), function($excel) use($dated) {

            $excel->sheet(date('Ymdhis'), function($sheet) use($dated) {
                $sheet->fromArray($dated['employees']);
                $heading = array('id','employee_name','teamleader','location');

                while (strtotime($dated['start']) <= strtotime($dated['end'])) {
                    array_push($heading,$dated['start']);                
                    $dated['start'] = date ("Y-m-d", strtotime("+1 day", strtotime($dated['start'])));
                }
                array_push($heading,"INCENTIVE");

                $sheet->row(1, $heading);
            });

        })->download('xlsx');   

    }

    public function dtr_excel(){
        $locations = $this->locationlist();
        $teamleaders = $this->contractorlist();
        return view('dtr.dtr_upload',compact('teamleaders','locations'));
    }

    public function getcontractorlocationlist(){
        $url = "http://172.16.20.48/cm/contractors-api.php?locationonly=on";
        $json = file_get_contents($url);
        $obj = json_decode($json);        
        return $obj;
    }

    public function getcontractorlistn(){
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
        $contractors = $this->getcontractorlistn();
        $contractor_options = '';
        foreach($contractors as $contractor){
            $contractor_options .= '<option value="'.$contractor->contractor.'">'.$contractor->contractor.'</option>';
        }
        return $contractor_options;
    }
}
