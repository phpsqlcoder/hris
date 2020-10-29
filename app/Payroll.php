<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payroll extends Model
{
    protected $fillable = ['cutoff_id', 'employee_id', 'present', 'absent', 'leave', 'suspended', 'rate', 'cola'
    , 'amount', 'location', 'teamleader', 'fullName', 'adjustment', 'adjustmentRemarks','sss','hdmf','philhealth','contractor','present_amount','absent_amount','leave_amount','suspended_amount','sss_amount','hdmf_amount','philhealth_amount','sss_loan_amount','hdmf_loan_amount','adjustment_days','payroll_date','status','sss_loan_id','hdmf_loan_id'];

    public function employee(){
     	return $this->belongsTo('App\Employee');
    }

    public function cutoff(){
     	return $this->belongsTo('App\Cutoff');
    }

    public function rate($employee_id){
     	return $this->belongsTo('App\Cutoff');
    }

    public function payroll_rate(){
        return $this->hasMany('App\payroll_rates');
    }
}
