<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Loans;
use App\Payroll;
use App\Employee;
use Session;

class LoansController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {        
        $request['status'] = '1';
        $save = Loans::create($request->all());
        Session::flash('success','Loan has been submitted!');
        return redirect ('employees/'.$request->employee_id.'#tab_1_20');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function history($id)
    {
        
        $loan = Loans::where('id','=',$id)->first();

        if($loan->loanType=='SSS'){
            $data='<table class="table">
            <tr>
                <td>Seq</td>
                <td>Cutoff</td>
                <td>Deduction</td>
                <td>Balance</td>
            </tr>
            ';
            $payments = Payroll::where('sss_loan_id','=',$id)->get();
            $balance = $loan->amount;
            $n = 0;
            foreach($payments as $p){
                $n++;
                $balance = $balance - $p->sss_loan_amount;
                $data.='<tr>
                            <td>'.$n.'</td>
                            <td>'.$p->cutoff->Cname.'</td>
                            <td>'.number_format($p->sss_loan_amount,2).'</td>
                            <td>'.number_format($balance,2).'</td>
                        </tr>';
                
            }
            $data.='<tr style="font-weight:bold;font-size:16px;">
                            <td colspan="3">Balance</td>                            
                            <td>'.number_format($balance,2).'</td>
                        </tr>';
            $data.='</table>';
        }
        elseif($loan->loanType=='HDMF'){
            $data='<table class="table">
            <tr>
                <td>Seq</td>
                <td>Cutoff</td>
                <td>Deduction</td>
                <td>Balance</td>
            </tr>
            ';
            $payments = Payroll::where('hdmf_loan_id','=',$id)->get();
            $balance = $loan->amount;
            $n = 0;
            foreach($payments as $p){
                $n++;
                $balance = $balance - $p->hdmf_loan_amount;
                $data.='<tr>
                            <td>'.$n.'</td>
                            <td>'.$p->cutoff->Cname.'</td>
                            <td>'.number_format($p->hdmf_loan_amount,2).'</td>
                            <td>'.number_format($balance,2).'</td>
                        </tr>';
                
            }
            $data.='<tr style="font-weight:bold;font-size:16px;">
                            <td colspan="3">Balance</td>                            
                            <td>'.number_format($balance,2).'</td>
                        </tr>';
            $data.='</table>';
        }

        return $data;
        
    }

    public function show_details($id){
        $loan = Loans::where('id','=',$id)->first();
        $e = Employee::where('id','=',$loan->employee_id)->first();
        $history = $this->history($id);
        return view('loan.loan_details',compact('history','loan','e'));
    }

    public function stop($id){
        $loan = Loans::where('id','=',$id)->update([
            'isClosed' => '1',
            'RemarkClosed' => date('Y-m-d h:i:s')
        ]);
        return "Stopped";
    }

    
}
