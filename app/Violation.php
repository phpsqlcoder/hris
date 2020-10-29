<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Violation extends Model
{
    protected $fillable = ['details', 'incidentType', 'incidentDateStart', 'suspendDateStart', 'suspendDateEnd', 'employee_id'];
    protected $dates = ['incidentDateStart' , 'suspendDateStart', 'suspendDateEnd'];

    public function employee(){
     	return $this->belongsTo('App\Employee');;
    }

   
}
