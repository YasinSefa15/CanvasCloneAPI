<?php

use App\Http\Controllers\AccountTypeController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
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

Route::post('/login',[AuthController::class,'read'])->name('login');
Route::post('/register',[AuthController::class,'create'])->name('register');

Route::controller(\App\Http\Controllers\UserController::class)
    ->name('user.')
    ->prefix('profile/settings')
    ->group(function(){
       Route::get('','read')->name('read');
       Route::post('','update')->name('update');
    });
Route::controller(AccountTypeController::class)
    ->name('account.')
    ->prefix('account-type')
    ->group(function(){
       Route::get('','read')->name('read');
       Route::post('','create')->name('create');
    });
