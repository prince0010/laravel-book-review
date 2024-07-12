<?php

use App\Http\Controllers\BookController;
use App\Http\Controllers\ReviewController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    // This is an alterative if tinker doesnt work for any reason. the dd()
  // dd();
  return redirect()->route('books.index');
});

// RESOURCE CONTROLLERS SUPPORT NESTED ROUTES 
// RESOURCE CONTROLLERS ALLOWS FOR PARTIAL RESOURCE ROUTES 

Route::resource('/books', BookController::class)
->only(['index', 'show']); // we use only since we only use the index and show route in the BookController

Route::resource('books.review', ReviewController::class)
->scoped(['review' => 'book'])//We scoped it first so that review is in the scope of the book
->only(['create', 'store']);//The actions in routes we will need is create to display the form and store to store the data that is being sent 
 
 
