<?php

use App\Http\Controllers\APIController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\FilesController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CsvExportController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/files/filelist', function () {
    return view('files/filelist');
});


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

/**
* File Routes
*/
Route::get('/files', 'App\Http\Controllers\FilesController@index')->name('files.index');
Route::get('/dashboard', 'App\Http\Controllers\FilesController@allFile')->name('dashboard');
Route::get('/files/upload', 'App\Http\Controllers\FilesController@create')->name('files.create');
Route::post('/files/store', 'App\Http\Controllers\FilesController@store')->name('files.store');
Route::post('/files/storeText', 'App\Http\Controllers\FilesController@storeText')->name('files.storeText');
Route::get('/files/filelist', 'App\Http\Controllers\FilesController@filelist')->name('files.filelist');
Route::get('/files/show/{id}', 'App\Http\Controllers\FilesController@showFile')->name('files.showFile');
Route::delete('/files/delete/{id}', 'App\Http\Controllers\FilesController@delete')->name('file.delete');
Route::match(['get', 'post'],'/extract-api-data', 'App\Http\Controllers\APIController@getapi')->name('api.getapi');

//Route::post('/process-api-data', 'App\Http\Controllers\APIController@processData')->name('api.processData');
Route::match(['get', 'post'],'/store-extracted', 'App\Http\Controllers\APIController@storeDataInDatabase')->name('store.database');
Route::post('/files/download/', 'App\Http\Controllers\FilesController@download')->name('files.download');
Route::get('/export', 'App\Http\Controllers\CsvExportController@exportExcelView')->name('export');
Route::get('export-excel',[CsvExportController::class, 'exportExcel'])->name('export.excel');


require __DIR__.'/auth.php';