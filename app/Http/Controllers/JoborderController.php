<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Joborder;

class JoborderController extends Controller
{
     public function index()
    {
        $joborders = Joborder::where('id','>',0)->get();
        return view('joborder.index',compact('joborders'));
    }

   
    public function create()
    {
        $contractors = $this->contractorlist();
        return view('joborder.add',compact('contractors'));
    }

   
    public function store(Request $request)
    {
        $shift = Joborder::create($request->all());
        return redirect('/joborder');
    }

   
    public function show(Joborder $joborder)
    {
        //
    }

    
    public function edit(Joborder $joborder)
    {
        //
    }

    
    public function update(Request $request, Joborder $joborder)
    {
        //
    }

    
    public function destroy(Joborder $joborder)
    {
        //
    }

    public function getcontractorlist(){
        $url = "http://172.16.20.48/cm/contractors-api.php?contractoronly=on";
        $json = file_get_contents($url);
        $obj = json_decode($json);        
        return $obj;
    }

    public function contractorlist($default='')
    {
        $contractors = $this->getcontractorlist();
        $contractor_options = '';
        foreach($contractors as $contractor){
            $contractor_options .= '<option value="'.$contractor->contractor.'">'.$contractor->contractor.'</option>';
        }
        return $contractor_options;
    }
}
