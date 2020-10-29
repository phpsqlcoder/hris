<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


//Route::get('rrr', function(){	return "sss"; });
Route::get('rrr', 'EmployeesController@jundrie');
Route::get('jundriegwapo', 'PayrollController@testx');
Auth::routes();

Route::group(['middleware' => 'auth'], function () {
	Route::get('/', function () {
    	return view('welcome');
	});
	Route::get('home', 'HomeController@index');
	Route::put('employees/{id}/resign', 'EmployeesController@resign');
	Route::resource('employees', 'EmployeesController');
	


	Route::resource('dependents', 'DependentsController');

	Route::post('leaves/{id}/getdates','LeavesController@getdates');
	Route::post('leaves/{id}/submitfileleave','LeavesController@submitfileleave');
	Route::resource('leaves', 'LeavesController');

	Route::get('violations/{id}/create','ViolationsController@createFromEmployee');
	Route::resource('violations', 'ViolationsController');

	Route::post('leaveledgers/{id}/getledger','LeaveledgersController@getledger');
	Route::resource('leaveledgers', 'LeaveledgersController');

	Route::resource('employeeleaves', 'EmployeeLeavesController');

	Route::get('cutoff/{id}/postCutoff','CutoffsController@postCutoff');
	Route::get('cutoff/{id}/setpayrate','PayrollRatesController@setPayrollRate');
	Route::post('postpayrate/{id}/save_payrate','PayrollRatesController@savePayRate');
	//Route::any('postpayrate/{id}/save_payrate',function(){	return 'aaa';});
	Route::resource('cutoff', 'CutoffsController');

	Route::resource('shift', 'ShiftsController');

	Route::post('dtr/getform','DtrController@getform');
	Route::post('dtr/{id}/saverecord','DtrController@saverecord');
	Route::post('dtr/getWorkHistoryPerEmployee','DtrController@getWorkHistoryPerEmployee');
	Route::post('dtr/getDTRperEmployee','DtrController@getDTRperEmployee');
	Route::get('dtr/uploadexcel',function(){ return view('dtr.excel_upload'); });
	Route::post('dtr/dtr_download_template','DtrController@dtr_download_template');
	Route::get('dtr/uploaddtr','DtrController@dtr_excel');

	Route::get('dtr/download_bm','DtrController@download_bm');
	Route::post('dtr/download_bm_generate','DtrController@download_bm_generate');
	Route::post('dtr/download_bm_generate_raw','DtrController@download_bm_generate_raw');

	Route::post('dtr/excel_post','DtrController@excel_post');
	Route::post('dtr/dtr_post','DtrController@dtr_post');
	Route::resource('dtr', 'DtrController');

	Route::resource('position', 'PositionController');
	Route::get('locations', 'TeamleaderlocationController@view');
	Route::get('loan/details/{id}', 'LoansController@show_details');
	Route::resource('loans', 'LoansController');
	Route::get('loans/stop/{id}', 'LoansController@stop');

	Route::any('payroll/process/{id}','PayrollController@process');
	Route::post('payroll/adjustment/{id}','PayrollController@adjustment');
	Route::any('payroll/load_adjustment/{id}','payrollController@load_adjustment_page');
	Route::post('payroll/saveadjustment/{id}','PayrollController@save_adjustment');
	Route::any('payroll/delete_record_option/{id}','PayrollController@delete_record_option');
	Route::any('payroll/delete_records/{id}','PayrollController@delete_records');

	Route::resource('payroll', 'PayrollController');
	Route::resource('joborder', 'JoborderController');

	Route::any('reports/tss_filter','ReportsController@tss_filter');
	Route::any('reports/tss_range_filter','ReportsController@tss_range_filter');
	Route::any('reports/payroll_filter','ReportsController@payroll_filter');
	Route::any('reports/payslip_filter','ReportsController@payslip_filter');
	Route::any('reports/deductions_filter','ReportsController@deductions_filter');
	Route::any('reports/masterlist_filter','ReportsController@masterlist_filter');
	Route::any('reports/ppe_schedule_filter','ReportsController@ppe_schedule_filter');
	Route::any('reports/statutories_filter','ReportsController@statutories_filter');
	Route::any('reports/resigned_filter','ReportsController@resigned_filter');

	Route::any('reports/tss/{id}','ReportsController@tss');
	Route::any('reports/tss_range/{id}','ReportsController@tss_range');
	Route::any('reports/payroll/{id}','ReportsController@payroll');
	Route::any('reports/payslip/{id}','ReportsController@payslip');
	Route::any('reports/deductions/{id}','ReportsController@deductions');
	Route::any('reports/masterlist/{id}','ReportsController@masterlist');
	Route::any('reports/ppe_schedule/{id}','ReportsController@ppe_schedule');
	Route::any('reports/statutories/{id}','ReportsController@statutories');
	Route::any('reports/resigned/{id}','ReportsController@resigned');

	Route::any('reports/payroll_excel/{id}','ReportsController@payroll_excel');

	// Batch processing
	Route::get('employeesd/setleave', 'EmployeesController@add_default_leave'); // Load Leave to all employees
	Route::get('employeesd/loademployees', 'EmployeesController@load_employee_excel'); // Load employees from excel

	Route::get('batchupdate/employees', 'EmployeesController@get_all_employees');
	Route::get('batchupdate_upload_page/employees', function(){ return view('employees.batchupdate'); });
	Route::post('batchupdate_upload/employees', 'EmployeesController@post_all_employees');
	Route::get('batchupdate/dependents', 'EmployeesController@get_all_employees_with_dependents');

	//Route::get('test', 'TestController@get_payroll_data');
});