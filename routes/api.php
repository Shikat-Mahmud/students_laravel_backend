<?php

use App\Http\Controllers\StudentController;
use Illuminate\Support\Facades\Route;

Route::get('students', [StudentController::class, 'index']);
Route::post('create_student',[StudentController::class,'store']);