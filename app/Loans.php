<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Loans extends Model
{
    public $table = 'loans';
	protected $fillable = ['amount', 'loanType', 'deductionNumber', 'deductionAmount', 'employee_id', 'startDate', 'status', 'isClosed', 'RemarkClosed'];

    public function employee(){
     	return $this->belongsTo('App\Employee');
    }

    public function getAmountToDeductSSS($employee_id,$loan,$cutoff){
        $cutoff = date('Y-m-d',strtotime($cutoff));
        $loand = DB::table('loans')
                ->where('employee_id','=',$employee_id)
                ->where('loanType','=',$loan)
                ->where('status','=','1')
                ->where('startDate','<=',$cutoff)
                ->where('isClosed','!=','1')
                ->first();
         //\Log::info($loan);
        if($loand === null){
            $contribution = 0;
        }
        else{
            
            $exist = DB::table('loans')
                ->where('employee_id','=',$employee_id)
                ->where('loanType','=',$loan)
                ->where('status','=','1')
                ->where('startDate','<=',$cutoff)
                ->where('isClosed','!=','1')
                ->first();
            
                     
            $total_paid_amount = DB::table('payrolls')
                            ->where('payroll_date','<',$cutoff)
                            ->where('employee_id','=',$employee_id)
                            ->where('sss_loan_id','=',$exist->id)
                            ->sum('sss_loan_amount');
                      
            
            $total_paid_qty = DB::table('payrolls')
                            ->where('payroll_date','<',$cutoff)
                            ->where('employee_id','=',$employee_id)
                            ->where('sss_loan_id','=',$exist->id)
                            ->count();
            
            $amount = $exist->amount;
            $qty = $exist->deductionNumber;
            $balance_amount = $amount - $total_paid_amount;
            $balance_qty = $qty - $total_paid_qty;
            if($balance_qty>0){
                $contribution = $balance_amount/$balance_qty;
                $contribution = number_format($contribution,2, '.', '');
            }
            else{
                $contribution = 0;
            }
            
            
        }
        return $contribution;

    }

    public function getAmountToDeductHDMF($employee_id,$loan,$cutoff){

        $loand = DB::table('loans')
                ->where('employee_id','=',$employee_id)
                ->where('loanType','=',$loan)
                ->where('status','=','1')
                ->where('startDate','<=',$cutoff)
                ->where('isClosed','!=','1')
                ->first();
               // \Log::info($loand);
        if($loand === null){
            $contribution = 0;
        }
        else{
            
            $exist = DB::table('loans')
                ->where('employee_id','=',$employee_id)
                ->where('loanType','=',$loan)
                ->where('status','=','1')
                ->where('startDate','<=',$cutoff)
                ->where('isClosed','!=','1')
                ->first();
            
                     
            $total_paid_amount = DB::table('payrolls')
                            ->where('payroll_date','<',$cutoff)
                            ->where('employee_id','=',$employee_id)
                            ->where('hdmf_loan_id','=',$exist->id)
                            ->sum('hdmf_loan_amount');
            
            $total_paid_qty = DB::table('payrolls')
                            ->where('payroll_date','<',$cutoff)
                            ->where('employee_id','=',$employee_id)
                            ->where('hdmf_loan_id','=',$exist->id)
                            ->count();
            
            $amount = $exist->amount;
            $qty = $exist->deductionNumber;
            $balance_amount = $amount - $total_paid_amount;
            $balance_qty = $qty - $total_paid_qty;
            if($balance_qty>0){
                $contribution = $balance_amount/$balance_qty;
                $contribution = number_format($contribution,2, '.', '');
            }
            else{
                $contribution = 0;
            }
            
        }
        return $contribution;

    }

    
    public function getBalance($id)
    {
        return 0;
    }
    public function getLoanId($employee_id,$loan,$cutoff)
    {
        $loand = DB::table('loans')
                ->where('employee_id','=',$employee_id)
                ->where('loanType','=',$loan)
                ->where('status','=','1')
                ->where('startDate','<=',$cutoff)
                ->first();
        if($loand === null){
            $loanID = 0;
        }
        else{
            $loanID = $loand->id;
        }

        return $loanID;
    }
}
