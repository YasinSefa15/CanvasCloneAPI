<?php

use App\Http\Controllers\AccountTypeController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::view('/home','home');

Route::controller(AccountTypeController::class)
    ->middleware('method')
    ->name('account.')
    ->prefix('account-type')
    ->group(function(){
        Route::any('','read')->name('read');
        Route::any('/create','create')->name('create');
    });

Route::any('/login',[AuthController::class,'read'])->name('login');
Route::any('/register',[AuthController::class,'create'])->name('register');

Route::controller(UserController::class)
    ->middleware('method')
    ->name('user.')
    ->prefix('users')
    ->group(function(){
       Route::any('/create','create')->name('create');
       Route::any('','read')->name('read');
       Route::any('/update/{user_id}','update')->name('update');
       Route::any('/view/{user_id}','view')->name('view');
    });

Route::controller(CourseController::class)
    ->middleware('method')
    ->name('course.')
    ->prefix('courses')
    ->group(function(){
       Route::any('/create','create')->name('create');
       Route::any('','read')->name('read');
       Route::any('/update/{course_id}','update')->name('update');
       Route::any('/view/{course_id}','view')->name('view');
    });

