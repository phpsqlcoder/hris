<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EmployeeLeave extends Model
{
	public $table = 'employeeleaves';
	protected $fillable = ['balance', 'employee_id', 'leave_id'];
    public function employee(){
     	return $this->belongsTo('App\Employee');
    }

    public function leave(){
     	return $this->belongsTo('App\Leave');
    }
}
