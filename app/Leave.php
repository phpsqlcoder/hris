<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Leave extends Model
{
    protected $fillable = ['name', 'limit', 'code'];

    public function employeeleaves(){
        return $this->hasMany('App\EmployeeLeave');
    }

    public function leaveledgers(){
        return $this->hasMany('App\LeaveLedger');
    }
}
