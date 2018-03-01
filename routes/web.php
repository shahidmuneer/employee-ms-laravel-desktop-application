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


Route::get('/', function () {
//    return redirect("http://www.dsjkhanewal.com.pk");
//header("location:https://www.dsjkhanewal.com.pk");

    return view('dashboard');
})->middleware('auth');

Auth::routes();

Route::get('/dashboard', 'DashboardController@index');
// Route::get('/system-management/{option}', 'SystemMgmtController@index');
Route::get('/profile', 'ProfileController@index');

Route::post('user-management/search', 'UserManagementController@search')->name('user-management.search');
Route::resource('user-management', 'UserManagementController');

Route::resource('employee-management', 'EmployeeManagementController');
Route::post('employee-management/search', 'EmployeeManagementController@search')->name('employee-management.search');



Route::resource('system-management/department', 'DepartmentController');
Route::post('system-management/department/search', 'DepartmentController@search')->name('department.search');

Route::resource('system-management/districts', 'DistrictsController');
Route::post('system-management/districts/search', 'DistrictsController@search')->name('districts.search');


Route::resource('system-management/division', 'DivisionController');
Route::post('system-management/division/search', 'DivisionController@search')->name('division.search');


Route::resource('system-management/designation', 'DesignationController');
Route::post('system-management/designation/search', 'DesignationController@search')->name('designation.search');

Route::resource('system-management/bps', 'BpsController');
Route::post('system-management/bps/search', 'BpsController@search')->name('bps.search');
Route::resource('system-management/stage', 'StageController');
Route::post('system-management/stage/search', 'StageController@search')->name('stage.search');


Route::resource('system-management/bps_allowance', 'BpsAllowanceController');
Route::post('system-management/bps_allowance/search', 'BpsAllowanceController@search')->name('BpsAllowance.search');


Route::resource('system-management/designation_allowances', 'DesignationAllowanceController');
Route::post('system-management/designation_allowances/search', 'DesignationAllowanceController@search')->name('designation_allowances.search');

Route::resource('system-management/bps_deduction', 'BpsDeductionController');
Route::post('system-management/bps_deduction/search', 'BpsDeductionController@search')->name('BpsDeduction.search');

Route::resource('budget-management/grant', 'grantController');
Route::post('budet-management/grant/search', 'grantController@search')->name('grant.search');


Route::resource('budget-management/grant-head', 'grantHeadController');
Route::post('budet-management/grant-head/search', 'grantHeadController@search')->name('grant-head.search');

Route::get('budget-management/report', 'budgetReportController@index');
Route::post('budget-management/report/search', 'budgetReportController@search')->name('report.search');


Route::get('system-management/report', 'ReportController@index');
Route::post('system-management/report/search', 'ReportController@search')->name('report.search');
Route::post('system-management/report/excel', 'ReportController@exportExcel')->name('report.excel');
Route::post('system-management/report/pdf', 'ReportController@exportPDF')->name('report.pdf');

Route::get('avatars/{name}', 'EmployeeManagementController@load');

Route::any("grantHead/get", 'AjaxController@get');
Route::any("grants/get", 'AjaxController@getGrants');