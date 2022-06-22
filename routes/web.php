<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\DownloadController;

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

Route::controller(DownloadController::class)->group(function () {
    Route::post('/webhook', 'store')->name('downloads.store');
    Route::get('/api/download_data/{id}', 'view_downloads_data')->name('downloads.view');
});