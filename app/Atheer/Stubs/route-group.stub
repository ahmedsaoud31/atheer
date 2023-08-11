<?php

use Illuminate\Support\Facades\Route;
use Atheer\Facades\Atheer;

$group_name = Atheer::nameFromFile(__FILE__);

foreach(Atheer::routeItems(basename(__FILE__)) as $item_name){
  Route::name("")->group(__DIR__."/{$group_name}/$item_name.php");
}