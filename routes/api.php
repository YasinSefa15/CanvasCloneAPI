<?php

use App\Http\Controllers\AccountTypeController;
use App\Http\Controllers\AssignmentController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\ModuleController;
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

//in development to see upload and read files work clearly. won't be in the production
Route::view('/','home')->name('home');

Route::any('/login',[AuthController::class,'read'])
    ->middleware('device')
    ->name('login');
Route::any('/register',[AuthController::class,'create'])->name('register');


Route::controller(ModuleController::class)
    ->middleware('method')
    ->name('module.')
    ->prefix('modules')
    ->group(function(){
        Route::any('','read')->name('read');
        Route::any('/create','create')->name('create');
        Route::any('/delete/{id}','delete')->name('delete');
    });

Route::controller(AccountTypeController::class)
    ->middleware('method')
    ->name('account.')
    ->prefix('account-type')
    ->group(function(){
        Route::any('','read')->name('read');
        Route::any('/create','create')->name('create');
        Route::any('/delete/{id}','delete')->name('delete');
    });

Route::controller(UserController::class)
    ->middleware('method')
    ->name('user.')
    ->prefix('users')
    ->group(function(){
       Route::any('/create','create')->name('create');
       Route::any('','read')->name('read');
       Route::any('/update/{user_id}','update')->name('update');
       Route::any('/{user_id}','view')->name('view');
    });

Route::controller(CourseController::class)
    ->middleware(['method','authenticated'])
    ->name('course.')
    ->prefix('courses')
    ->group(function(){
       Route::any('/create','create')->name('create');
       Route::any('','read')->name('read');
       Route::any('/update/{course_id}','update')->name('update');
       Route::any('/{course_id}','view')->name('view');
    });

Route::controller(AssignmentController::class)
//    ->middleware(['method','authenticated'])
    ->name('assignment.')
    ->prefix('courses/{id}/assignments')
    ->group(function(){
        Route::any('/create','create')->name('create');
        Route::any('','read')->name('read');
        Route::any('/update/{course_id}','update')->name('update');
        Route::any('/{course_id}','view')->name('view');
    });


