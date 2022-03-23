<?php

use App\Http\Controllers\AccountTypeController;
use App\Http\Controllers\AssignmentController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\FileDownloadController;
use App\Http\Controllers\ModuleController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

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
//    ->middleware(['method','authenticated'])
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
    ->prefix('courses/{course_id}/assignments')
    ->group(function(){
        Route::any('/create','create')->name('create');
        Route::any('','read')->name('read');
        Route::any('/update/{assignment_id}','update')->name('update-form');
        Route::any('/{assignment_id}','view')->name('view');
    });

/** todo : if user has a relation with given course id then its ok. Will be controlled in the middleware. If user enrolled that course check whether that file belongs to s/he.*/
Route::controller(FileDownloadController::class)
    ->middleware('method')
    ->prefix('courses/{course_id}/')
    ->group(function (){
        Route::any('submitted-file/{file_id}','submitted')->name('submitted.download');
        Route::any('attached-file/{file_id}','attached')->name('attached.download');
    });

