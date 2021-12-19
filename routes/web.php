<?php

use App\Http\Controllers\AssetController;
use App\Http\Controllers\AssetTypeController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ChartController;


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

Route::get('addTypes',[AssetTypeController::class,'AddAssetTypeForm'])->name('addTypes');
Route::get('showTypes',[AssetTypeController::class,'ShowAsssetsType'])->name('showTypes');
Route::post('/addtypes_insert',[AssetTypeController::class,'InsertAssetType']);
Route::get('/deletetype/{id}',[AssetTypeController::class,'DeleteAssetType']);
Route::get('/edittype/{id}', [AssetTypeController::class,'EditAssetType']);
Route::post('/updatetype/{id}', [AssetTypeController::class,'UpdateAssetType']);

Route::get('addAssets',[AssetController::class,'AddAssetForm'])->name('addAssets');
Route::get('showAssets',[AssetController::class,'ShowAssets'])->name('showAssets');
Route::post('/addasset_insert',[AssetController::class,'InsertAsset']);
Route::get('/delete/{id}',[AssetController::class,'DeleteAsset']);
Route::get('/edit/{id}', [AssetController::class,'EditAsset']);
Route::post('/update/{id}', [AssetController::class,'UpdateAsset']);

Route::get('pie',[ChartController::class,'PieChart'])->name('pie');
Route::get('bar',[ChartController::class,'BarChart'])->name('bar');
Route::get('download', [ChartController::class,'DownloadAssets'])->name('download');





