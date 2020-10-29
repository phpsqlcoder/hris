<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Cutoff;
use App\PayrollRate;

class PayrollRatesController extends Controller
{
    public function setPayrollRate($id)
    {    	
    	$cutoff = Cutoff::where('id',$id)->first();
    	$contractors = $this->getcontractorlist();
    	$dat='';
    	foreach($contractors as $contractor){
    		
    		
    		$exist = PayrollRate::where('cutoff_id',$id)->where('teamleader',$contractor->contractor)->where('location',$contractor->location)->first();
    		if ($exist === null) {
    			//$dat.= $contractor->contractor." - ".$contractor->location."<br>";
	    		$rec = new PayrollRate();
	    		$rec->teamleader = $contractor->contractor;
	    		$rec->location = $contractor->location;
	    		$rec->rate = '0';
				$rec->cutoff()->associate($cutoff);
				$rec->save();
			}
					
    	}
    	//return $dat;
    	
    	$data = PayrollRate::where('cutoff_id',$id)->orderBy('teamleader','asc')->orderBy('location','asc')->get();
        return view('cutoff.payroll_rate',compact('cutoff','data'));
        
    }
    public function getcontractorlist(){
        $url = "http://172.16.20.48/cm/contractors-api.php";
        $json = file_get_contents($url);
        $obj = json_decode($json);        
        return $obj;
    }

    public function savePayRate(Request $request,$id){
    	$payrate = PayrollRate::findOrFail($id)->update(['rate' => $request->nrate]);      
    	$status = '<span class="label label-primary">Saved</span>';
    	return $status;
    }
}
