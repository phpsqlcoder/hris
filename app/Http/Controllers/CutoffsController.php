<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Cutoff;
use Auth;
use Session;
use App\Dtr;

class CutoffsController extends Controller
{
   
    public function index()
    {
        $cutoffs=Cutoff::orderBy('id','desc')->get();
        return view('cutoff.index',compact('cutoffs'));
    }

    
    public function create()
    {
        return view('cutoff.add');
    }

   
    public function store(Request $request)
    {
        $save_Cutoff = Cutoff::create([
            'start' => $request->start_date,
            'end' => $request->end_date,
            'code' => $request->code,
            'payroll' => $request->payroll_date,
            'tayp' => 'Regular',
            'isDtrClosed' => '1'
            ]);
        return redirect('/cutoff');
    }

   
    public function show($id)
    {
        //
    }

  
    public function edit($id)
    {
        $cutoff=Cutoff::find($id);
        return view('cutoff.edit',compact('cutoff'));
    }

  
    public function update(Request $request, $id)
    {
        cutoff::find($id)->update([
            'start' => $request->start_date,
            'end' => $request->end_date,
            'code' => $request->code,
            'payroll' => $request->payroll_date,
            'tayp' => 'Regular'
            ]);
        return redirect('/cutoff');
    }

   
    public function destroy($id)
    {
        //
    }

    public function getLastCutoffDate()
    {
        $last = cutoff::where('isDtrClosed','=','1')->orderBy('end','desc')->first();
        if($last === null){
            $last_date = '2017-01-01';
        }
        else {
            $last_date = $last->end;
        }
        return $last_date;
    }

    public function postCutoff($id)
    {
        cutoff::findOrFail($id)->update([
            'isDtrClosed' => 1,
            'dtrClosedBy' => Auth::user()->name,
            'dtrClosedDate' => date('Y-m-d h:i:s'),
        ]);
        $cutoff = cutoff::where('id',$id)->first();
        $start_date = $cutoff->start;
        $end_date = $cutoff->end;
        for ( $x = strtotime($start_date); $x <= strtotime($end_date); $x += 86400 ){
            $dyt=date('Y-m-d',$x);
            Dtr::where('dtrDate',$dyt)->update(['isPosted' => 1]);
        }            
        
        Session::flash('success','Cutoff has been Posted!');
        return back();
    }

    
}
