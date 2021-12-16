<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\my_controller;


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
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/addtypes',[my_controller::class,'show']);
Route::get('/showtypes',[my_controller::class,'show_types']);
Route::get('/addassets',[my_controller::class,'show2']);
Route::get('/showassets',[my_controller::class,'show_assets'])->name('showassets');
Route::post('/addtypes_insert',[my_controller::class,'insert_type']);
Route::post('/addasset_insert',[my_controller::class,'insert_asset']);
Route::get('/delete/{id}',[my_controller::class,'delete_asset']);
Route::get('/deletetype/{id}',[my_controller::class,'delete_type']);
Route::get('/pie',[my_controller::class,'pie_chart']);
Route::get('/bar',[my_controller::class,'bar_chart']);
Route::get('/tasks', [my_controller::class,'exportCsv']);
Route::get('/edit/{id}', [my_controller::class,'edit']);
Route::get('/edittype/{id}', [my_controller::class,'edittype']);
Route::post('/update/{id}', [my_controller::class,'update_asset']);
Route::post('/updatetype/{id}', [my_controller::class,'update_type']);

