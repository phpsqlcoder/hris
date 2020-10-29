<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Dependent extends Model
{
     protected $fillable = ['fullName', 'relationship', 'birthDate', 'employee_id'];

     public function employee(){
     	return $this->belongsTo('App\Employee');;
     }

     public function getAgeAttribute(){
        return Carbon::parse($this->attributes['birthDate'])->age;
     }
}
