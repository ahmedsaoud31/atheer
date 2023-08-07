<?php

use Illuminate\Support\Facades\Route;
use Atheer\Facades\Atheer;
use App\Http\Controllers\Atheer\Auth\RoleController;

$item_name = Atheer::nameFromFile(__FILE__);

Route::get("/{$item_name}/permissions", [RoleController::class, 'permissions'])->name("{$item_name}.permissions");
Route::post("/{$item_name}/update-permissions", [RoleController::class, 'updatePermissions'])->name("{$item_name}.update-permissions");
Route::resource("/{$item_name}", RoleController::class);