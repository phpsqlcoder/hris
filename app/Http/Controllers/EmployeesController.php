<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Employee;
use App\Dependent;
use App\Violation;
use App\Leave;
use App\Leaveledger;
use App\EmployeeLeave;
use DB;
use Session;
use Image;
use App\Loans;
use App\Payroll;
use Auth;
use Excel;

class EmployeesController extends Controller
{
    
    public function index()
    {
        $user_role = Auth::user()->role;
        if($user_role == 'admin'){
            $employees=Employee::where('id','>','0');
        }
        else{
            $employees=Employee::where('contractor',$user_role);
        }
        $employees= $employees->whereNull('resignedDate')->orderBy('id','desc')->get();
        return view('employees.index',compact('employees'));
    }

   
    public function create()
    {
        //$contractors = $this->getcontractorlist();        
        return view('employees.add',compact('contractors'));
    }

  
    public function store(Request $request)
    {
        
        if($request->hasFile('picture')){
            $img = $request->file('picture');
            $filename = time().'.'.$img->getClientOriginalExtension();
            Image::make($img)->save(public_path('/images/'.$filename));
            $request['image'] =  $filename;   
        }
        $request['fullName'] = $request->lName.' '.$request->extName.', '.$request->fName.' '.$request->mName;
        $request['status'] = '1';
        $tl = explode("|",$request['teamleader']);
        $request['teamleader'] = $tl[0];
        $request['location'] = $tl[1];
        $save = Employee::create($request->all());
        $insertedId = $save->id;

        $employee = Employee::find($insertedId);
        for($i=1;$i<=10;$i++){
            if($request->dependent_name[$i]){
                $dependent = $employee->dependents()->create([
                    'fullName' => $request->dependent_name[$i],
                    'relationship' => $request->dependent_relationship[$i],
                    'birthDate' => $request->dependent_bday[$i],                    
                ]); 
            }
        }

        Session::flash('success','New employee has been saved!');
        return redirect ('/employees');       

    }


  
    public function show($id)
    {
        $employee = Employee::find($id);
        $dependents = Dependent::where('employee_id',$id)->get();
        $violations = Violation::where('employee_id',$id)->get();
        $leaveledgers = Leaveledger::where('employee_id',$id)->get();
        $loans = Loans::where('employee_id',$id)->get();
        $payrolls = Payroll::where('employee_id',$id)->get();
        
        $employeeleaves = DB::table('employeeleaves')->select('employeeleaves.balance as balance', 'leaves.name as leavename', 'leaves.code as leavecode')
                            ->leftJoin('leaves', 'employeeleaves.leave_id','=','leaves.id')
                            ->where('employee_id',$id)
                            ->get();
        //$employeeleaves = EmployeeLeave::where('employee_id',$id)->get();
        $leaves = Leave::all();

        return view('employees.show',compact('employee','dependents','violations','leaveledgers','leaves','employeeleaves','loans','payrolls'));
    }

 
    public function edit($id)
    {
        $employee = Employee::findOrFail($id);
        $dependent = Dependent::where('employee_id',$id)->get();
        //$contractors = $this->getcontractorlist();   
        return view('employees.edit',compact('employee','dependent','contractors'));
    }

    
    public function update(Request $request, $id)
    {
        $tl = explode("|",$request['teamleader']);
        // $request['teamleader'] = $tl[0];
        // $request['location'] = $tl[1];
        $employee = Employee::findOrFail($id);
        $employee->update($request->all());

        // update existing dependents
        if($request->total_existing>0){
            for($x=1;$x<=$request->total_existing;$x++){
                Dependent::find($request->existing_dependent_id[$x])->update([
                        'fullName' => $request->existing_dependent_name[$x],
                        'relationship' => $request->existing_dependent_relationship[$x],
                        'birthDate' => $request->existing_dependent_bday[$x]
                    ]);
            }
        }

        // add new dependents        
        for($i=1;$i<=10;$i++){
            if($request->dependent_name[$i]){
                $dependent = $employee->dependents()->create([
                    'fullName' => $request->dependent_name[$i],
                    'relationship' => $request->dependent_relationship[$i],
                    'birthDate' => $request->dependent_bday[$i],                    
                ]); 
            }
        }
        Session::flash('success','Employee has been updated!');
        return redirect ('/employees/'.$id.'/edit');
        
    }

    public function destroy($id)
    {
        //
    }

    public function getcontractorlist(){
        return ;
        $url = "http://172.16.20.48/cm/contractors-api.php";       
        $json = file_get_contents($url);
        $obj = json_decode($json);        
        return $obj;
    }

    public function add_default_leave($id = null)
    {
        $leaves=Leave::get();
        foreach($leaves as $leave){
            if($id){
                $employees = Employee::where('id',$id)->get(); 
            }
            else{
                $employees = Employee::get();    
            }            
            foreach($employees as $employee){
                $insert_leave = Leaveledger::create(                    
                    [
                    'qty' => 100,
                    'tayp' => 'ADD',
                    'remarks' => 'AUTO',
                    'effectivityDate' => '2017-01-01',
                    'employee_id' => $employee->id,
                    'leave_id' => $leave->id
                    ]
                );
                $data['leave_id'] = $leave->id;
                $data['employee_id'] = $employee->id;
                $this->update_leave_maintenance($data);
            }

        }
        return 'Success';
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

    public function load_employee_excel()
    {
       $xls =  'Book1.xlsx';

        $results = Excel::load($xls, function($reader) {
            
        })->get();
        $data='';
        foreach($results as $result => $val){
            $data.=$val->lName;
        }
        return dd($results);

    }

    public function get_all_employees()
    {
        $user_role = Auth::user()->role;
  
        if($user_role == 'admin'){
            $employees=Employee::where('id','>','0');
        }
        else{
            $employees=Employee::where('contractor',$user_role);
        }
        $employees = $employees->orderBy('teamleader','desc')->orderBy('location','desc')->get();
        $dated['employees'] = array();
        foreach($employees as $employee){
            array_push($dated['employees'],array($employee->id,$employee->fullName,$employee->teamleader,$employee->location));
        }
          Excel::create(date('Ymdhis'), function($excel) use($dated) {

            $excel->sheet(date('Ymdhis'), function($sheet) use($dated) {
                $sheet->fromArray($dated['employees']);
                $heading = array('id','employee_name','teamleader','location','resignedDate');
                $sheet->row(1, $heading);
            });

        })->download('xlsx');   
    }

    public function get_all_employees_with_dependents()
    {
        $user_role = Auth::user()->role;
  
        if($user_role == 'admin'){
            $employees=Employee::where('id','>','0');
        }
        else{
            $employees=Employee::where('contractor',$user_role);
        }
        $employees = $employees->orderBy('teamleader','desc')->orderBy('location','desc')->get();
        $dated['employees'] = array();
        foreach($employees as $employee){
            array_push($dated['employees'],array($employee->id,$employee->fullName));
        }
          Excel::create(date('Ymdhis'), function($excel) use($dated) {

            $excel->sheet(date('Ymdhis'), function($sheet) use($dated) {
                $sheet->fromArray($dated['employees']);
                $heading = array('id','employee_name','Dep1-Fullname','Dep1-Bday','Dep1-Relationship',
                    'Dep2-Fullname','Dep2-Bday','Dep2-Relationship',
                    'Dep3-Fullname','Dep3-Bday','Dep3-Relationship',
                    'Dep4-Fullname','Dep4-Bday','Dep4-Relationship',
                    'Dep5-Fullname','Dep5-Bday','Dep5-Relationship',
                    'Dep6-Fullname','Dep6-Bday','Dep6-Relationship',
                    'Dep7-Fullname','Dep7-Bday','Dep7-Relationship',
                    'Dep8-Fullname','Dep8-Bday','Dep8-Relationship',
                    'Dep9-Fullname','Dep9-Bday','Dep9-Relationship',
                    'Dep10-Fullname','Dep10-Bday','Dep10-Relationship'
                    );
                $sheet->row(1, $heading);
            });

        })->download('xlsx');   
    }

    public function post_all_employees(Request $request)
    {
        $heads = Excel::load($request->xls, function($reader) {
            
        })->formatDates(false)->first();

        $results = Excel::load($request->xls, function($reader) {
            
        })->get()->toArray();         
            $datas='';
            foreach($results as $result => $val){
            
           // $datas.=$resigned.'<br>';
           
            DB::table('employees')
                ->where('id', $val['id'])
                ->update([
                    'teamleader' => $val['teamleader'],
                    'location' => $val['location']
                    ]);

            if($val['resigneddate']){
               DB::table('employees')
                ->where('id', $val['id'])
                ->update([
                    'active' => '0',
                    'resignedDate' => $val['resigneddate']
                    ]);
            }
              
           
            }
           
            Session::flash('success','Employee has been Updated!');
            return back();
            
            return $datas;

    }

    public function resign(Request $request, $id)
    {
         DB::table('employees')
                ->where('id', $id)
                ->update([
                    'active' => '0',
                    'resignedDate' => $request->resigned_date,
                    'resignedRemarks' => $request->resign_reason
                    ]);
        Session::flash('success','Employee is now in resigned status');
        return back();
    }

    public function jundrie(){
        $xls =  'Book10.xlsx';

        $results = Excel::load($xls, function($reader) {
            
        })->get();

         foreach($results as $result => $val){
            if($val->teamleader=='TEAM LEADER'){
                $csss = '363.30';
                $cphic = '125.00';
                $chdmf = '100.00';
            }
            else{
                $csss = '254.30';
                $cphic = '100.00';
                $chdmf = '100.00';
            }
            if($val->dob==''){
                $val->dob = '0000-00-00';
            }
            if($val->datehire==''){
                $val->datehire = '0000-00-00';
            }

            $rr['lName'] = $val->name;
            $rr['fName'] = '';
            $rr['mName'] = '';
            $rr['extName'] = '';
            $rr['fullName'] = $val->name;
            $rr['sss'] = $val->sss;
            $rr['hdmf'] = $val->pagibig;
            $rr['philhealth'] = $val->phic;
            $rr['tin'] = $val->tin;
            $rr['status'] = '1';
            $rr['hiredDate'] = $val->datehire;
            $rr['birthDate'] = $val->dob;
            $rr['birthPlace'] = $val->birthplace;
            $rr['gender'] = 'Male';
            $rr['address'] = $val->address;
            $rr['contactNo'] = $val->contactnum;
            $rr['civilStatus'] = $val->CivilStatus;
            $rr['religion'] = '';
            $rr['emergencyContactNo'] = $val->contactnum;
            $rr['emergencyContactPerson'] = $val->contactperson;
            $rr['empid'] = '';
            $rr['bloodType'] = '';
            $rr['active'] = '1';
            $rr['location'] = $val->workplace;
            $rr['teamleader'] = $val->teamleader;
            $rr['rate'] = '0.00';
            $rr['biometricId'] = 0;
            $rr['contractor'] = 'Shepherd';
            $rr['sss_contribution'] = $csss;
            $rr['hdmf_contribution'] = $chdmf;
            $rr['philhealth_contribution'] = $cphic;
            $rr['rateUpdateDate'] = '2017-10-03';

            $save = Employee::create($rr);
             //$data.=$val->name."<br>";
         }
        //return dd($results);
        return $data;
        
       // $x=0;
       //  foreach($array as $a){
       //      $x++;
       //      if($x>1){
       //          echo $a[1]."<br>";
       //      }
          
       //  }
    }


}
