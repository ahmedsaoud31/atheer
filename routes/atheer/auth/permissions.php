<?php

use Illuminate\Support\Facades\Route;
use Atheer\Facades\Atheer;
use App\Http\Controllers\Atheer\Auth\PermissionController;

$item_name = Atheer::nameFromFile(__FILE__);

Route::resource("/{$item_name}", PermissionController::class);