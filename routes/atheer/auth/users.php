<?php

use Illuminate\Support\Facades\Route;
use Atheer\Facades\Atheer;
use App\Http\Controllers\Atheer\Auth\UserController;

$item_name = Atheer::nameFromFile(__FILE__);

Route::get("/{$item_name}/roles", [UserController::class, 'roles'])->name("{$item_name}.roles");
Route::post("/{$item_name}/update-roles", [UserController::class, 'updateRoles'])->name("{$item_name}.update-roles");
Route::resource("/{$item_name}", UserController::class);