<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cutoff extends Model
{
  	protected $fillable = ['start', 'end', 'payroll', 'isDtrClosed', 'isPayrollClosed', 'dtrClosedBy', 'payrollClosedBy', 'payrollClosedDate', 'dtrClosedDate', 'tayp', 'code'];

	public function getCutoffId($value){
        $cutoff = $this->whereRaw("'".$value."' between start and end")->first();      
        return $cutoff->id;
    }

    public function payroll(){
     	return $this->belongsTo('App\Payroll');;
     }

    public function PayrollRate(){
    	return $this->hasMany('App\PayrollRate');
    }

    public function getCnameAttribute(){
        return $this->start." to ".$this->end;
    }
}
