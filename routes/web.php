<?php

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

Route::get('/', function () {
    return view('welcome');
});
Route::get('tuan', function () {
    return view('tuan');
});
Route::get('admin', function () {
    return view('include.layouts.admin');
});
Route::group([
    'prefix' => 'user'
], function () {
    Route::get('admin', function () {
        return view('include.layouts.admin');
    });
});
