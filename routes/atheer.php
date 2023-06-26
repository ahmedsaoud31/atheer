<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AtheerController;
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

$url_name = config('atheer.dashboard_name');

Route::get('/change-layout/{layout}', function ($layout) {
    if(in_array($layout, config('atheer.layouts'))){
      Cache::forever('atheer_layout', $layout);
    }
    return redirect(url()->previous());
});

Route::get('/change-locale/{locale}', function ($locale) {
    if(in_array($locale, ['ar', 'en'])){
      Cache::forever('locale', $locale);
    }
    return redirect(url()->previous());
});

Route::get($url_name, [AtheerController::class, 'index']);
Route::get($url_name .'/{page}', [AtheerController::class, 'page']);