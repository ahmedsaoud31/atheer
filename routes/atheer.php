<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Atheer\AtheerController;
use App\Http\Controllers\Atheer\Auth\LoginController;
use App\Http\Controllers\Atheer\Auth\RegisterController;
use App\Http\Controllers\Atheer\Auth\ForgotPasswordController;
use Atheer\Facades\Atheer;
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
Route::resource('/cccccccccc', ForgotPasswordController::class);
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

$url_name = config('atheer.dashboard_name');
Route::name('atheer.')->middleware(['web'])->prefix($url_name)->group(function () {
  Route::get('/test', function () {
      
  });
  Route::get('/logout', [LoginController::class, 'logout'])->name('logout');
  Route::resource('/login', LoginController::class, ['names' => ['index' => 'login']]);
  Route::resource('/register', RegisterController::class, ['names' => ['index' => 'register']]);
  Route::middleware(['atheer-auth'])->group(function () {
    Route::resource('/', AtheerController::class);
    foreach(Atheer::routeGroups() as $group_name){
      Route::name("{$group_name}.")->prefix($group_name)
            ->group(__DIR__."/atheer/{$group_name}.php");
    }
    Route::get('/{page}', [AtheerController::class, 'page']);
  });
});