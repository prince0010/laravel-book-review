<?php

use App\Http\Controllers\BookController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    // This is an alterative if tinker doesnt work for any reason. the dd()
  dd();
});

// RESOURCE CONTROLLERS SUPPORT NESTED ROUTES 
// RESOURCE CONTROLLERS ALLOWS FOR PARTIAL RESOURCE ROUTES 

Route::resource('/books', BookController::class);