<?php

use App\Http\Controllers\AlbumController;
use App\Http\Controllers\MediaController;
use Illuminate\Support\Facades\Route;

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

Route::resource('album' , AlbumController::class)->except('create');
Route::get('/albums/chart' , [AlbumController::class , 'chart'])->name('album.chart');

Route::name('media.')->prefix('media')->controller(MediaController::class)->group(function () {
    Route::get('/{id}' , 'index')->name('index');
    Route::post('/{id}/store' , 'store')->name('store');
    Route::get('/{album_id}/edit/{id}' , 'edit')->name('edit');
    Route::put('/{album_id}/update/{id}' , 'update')->name('update');
    Route::delete('/delete/{id}' , 'destroy')->name('destroy');
});
