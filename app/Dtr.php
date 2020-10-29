<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Validator;

class Dtr extends Model
{
    public $table= 'dtr';

    protected $fillable = [ 'dtrDate', 'tayp', 'hours', 'code', 'location', 'teamleader', 'adjustment', 'adjustmentRemarks', 'cutoff_id', 'employee_id', 'shift_id','isSuspended','isPosted', 'isLeave', 'remarks'];
   
   
}
