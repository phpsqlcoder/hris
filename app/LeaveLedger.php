<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Leave;

class Leaveledger extends Model
{
	//protected $table='leaveledgers';

	protected $fillable = ['qty', 'tayp', 'remarks', 'effectivityDate', 'employee_id', 'leave_id'];

    public function employee(){
     	return $this->belongsTo('App\Employee');
    }

    public function leave(){
     	return $this->belongsTo('App\Leave');
    }

    public function update_leave_maintenance_per_employee($id)
    {
        $leaves = Leave::all();
        foreach($leaves as $leave){
            $add = Leaveledger::where('employee_id', $id)->where('leave_id',$leave->id)->sum('qty');
            $subtract = Dtr::where('employee_id', $id)->where('tayp',$leave->id)->where('isLeave',1)->count();
            $leave_balance=$add - $subtract;
            EmployeeLeave::updateOrCreate(
                ['leave_id' => $leave->id, 'employee_id' => $id],
                ['balance' => $leave_balance]
            );
        }        
        
    }

    public function update_leave_maintenance_per_employee_and_leave($empid,$leaveid)
    {
        $add = Leaveledger::where('employee_id', $empid)->where('leave_id',$leaveid)->sum('qty');
        $subtract = Dtr::where('employee_id', $empid)->where('tayp',$leaveid)->where('isLeave',1)->count();
        $leave_balance=$add - $subtract;
        EmployeeLeave::updateOrCreate(
            ['leave_id' => $leaveid, 'employee_id' => $empid],
            ['balance' => $leave_balance]
        );
    }
}
