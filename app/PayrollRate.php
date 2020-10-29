<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PayrollRate extends Model
{
	public $table = 'payroll_rates';
    protected $fillable = ['teamleader','location','rate','cutoff_id'];

    public function cutoff(){
     	return $this->belongsTo('App\Cutoff');
    }

    public function getrate($location,$teamleader,$cutoff_id)
    {
    	
    	$rates = $this->where('location',$location)->where('teamleader',$teamleader)->where('cutoff_id',$cutoff_id)->first();
    	if ($rates === null) {
    		return $rates->rate;
    	}
    	else{
    		return 10000000;
    	}
    	
    	//return $location." - ".$teamleader." - ".$cutoff_id;
    }
}
