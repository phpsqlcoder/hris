<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Position;
use Session;

class PositionController extends Controller
{
   
    public function index()
    {
        $position = Position::all();
        return view('position.index',compact('position'));
    }

   
    public function create()
    {
        return view('position.add');
    }

   
    public function store(Request $request)
    {
        Position::Create($request->all());

        Session::flash('success','New Position has been saved!');

        return redirect('/position');
    }

  
    public function show($id)
    {
        //
    }

    
    public function edit($id)
    {
        $position = Position::findOrFail($id);
        return view('position.edit',compact('position'));
    }

   
    public function update(Request $request, $id)
    {
        Position::findOrFail($id)->update($request->all());

        Session::flash('success','Position has been updated!');

        return redirect('/position');
    }

   
    public function destroy($id)
    {
        //
    }
}
