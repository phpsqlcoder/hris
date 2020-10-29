<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Employee extends Model
{
    protected $table = 'employees';
    protected $fillable = ['lName', 'fName', 'mName', 'extName', 'fullName', 'sss', 'hdmf', 'philhealth', 'tin', 'status', 'hiredDate', 'birthDate', 'birthPlace', 'image', 'gender', 'address', 'contactNo', 'civilStatus', 'religion', 'emergencyContactNo', 'emergencyContactPerson', 'empid', 'bloodType','rate','teamleader','biometricId','contractor','sss_contribution','hdmf_contribution','philhealth_contribution','rateUpdateDate','location','resignedDate'];
   
    public function getFullnameAttribute(){
        return $this->lName.' '.$this->extName.', '.$this->fName.' '.$this->mName;
    }

    public function getAgeAttribute(){
        return Carbon::parse($this->attributes['birthDate'])->age;
    }

    public function getEmpidAttribute(){
        return $this->id;
    }


    ### Relationships ###
    
    public function dependents(){
        return $this->hasMany('App\Dependent');
    }

    public function violations(){
        return $this->hasMany('App\Violation');
    }

    public function employeeleaves(){
        return $this->hasMany('App\EmployeeLeave');
    }

    public function leaveledgers(){
        return $this->hasMany('App\Leaveledger');
    }

    public function loans(){
        return $this->hasMany('App\Loans');
    }

    public function payroll(){
        return $this->hasMany('App\Payroll');
    }

    ### End Relationships ###
}
