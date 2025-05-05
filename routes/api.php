<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\Department\DepartmentController;
use App\Http\Controllers\Api\Employee\EmployeeController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

  Route::get('departments', DepartmentController::class);
  Route::apiResource('employees', EmployeeController::class);
  Route::get('employee-get-filter-data', [EmployeeController::class, 'getFilterData'])->name('employee-get-filter-dropdown-data');
