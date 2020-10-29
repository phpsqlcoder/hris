<?php

namespace App\Http\Controllers;

use App\Shift;
use Illuminate\Http\Request;

class ShiftsController extends Controller
{
    
    public function index()
    {
        $shifts = Shift::where('id','>',0)->get();
        return view('shift.index',compact('shifts'));
    }

   
    public function create()
    {
        return view('shift.add');
    }

   
    public function store(Request $request)
    {
        $shift = Shift::create($request->all());
        return redirect('/shift');
    }

   
    public function show(Shift $shift)
    {
        //
    }

    
    public function edit(Shift $shift)
    {
        //
    }

    
    public function update(Request $request, Shift $shift)
    {
        //
    }

    
    public function destroy(Shift $shift)
    {
        //
    }
}
