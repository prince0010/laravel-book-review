<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    // RESOURCE CONTROLLERS BELOW 

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Optional Title parameter, which will be used for filtering
        $title = $request->input('title');
        $filter = $request->input('filter', '');
        $page = $request->input('page', 1); // Get current page or default to 1
        // here in the first argument the $title and the second argument function () If title is not empty then it will run otherwist in wont 
        // $book = Book::when($title, function ($query, $title) { 
        //     return $query->$title('title');
        // })
        // ARROW FUNCTION
        // The title($title) and the where() method is all in the local query scope in the Book.php Model where it has the scopeTitle and the $query for that is from the local query which has the where() method and you can check that in the Book.php Model
        // Creating an Optional Query using this model's when() method -> if this $title is being supplied as a query parameter to this action, then we optionally call our own local query scope called title as a reminder
    //    And it is simple where $query-> that is using a LIKE operator
        $bookQuery = Book::when($title, fn ($query, $title) => $query->title($title)
        );

        // match() is a statement and not a fucntion so its part of the language syntax and now a traditional function. it looks similar to switch case
        $bookQuery  = match($filter) {
            // Define the value of the $filter
            'popular_last_month' => $bookQuery ->popularLastMonth(),
            'popular_last_6months' => $bookQuery ->popularLast6Months(),
            'highest_rated_last_month' => $bookQuery ->highestRatedLastMonth(),
            'highest_rated_last_6months' => $bookQuery ->highestRatedLast6Months(),
            // the dafault is the latest() it is local built in the query scope. There are latest() and oldest() and other built in local query scope
            default => $bookQuery ->latest()->withAvgRating()->withReviewsCount()

        };

        // CACHED
        // Cached the result so that the infrastructure of this web app will not be having strain or hard time in caching every result that query is running 
        // Saving the results to an temporary storage so that it wont strain the infrastructure and just easily fetch the new results since the query is always running
        $cachedKey = 'book:' . $filter . ':' . $title . 'page:' . $page;
        $books = 
            cache()->remember(
            $cachedKey, 
            300, 
            fn()=>
             $bookQuery->paginate(15)
        );
        // $book = cache()->remember($cachedKey, 3600, function () use ($book) {
        //     dd('Not from Cached');
        //     return $book->get();
        // });

        // This is just renders this view,
        return view('books.index', ['books' => $books]);

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    // Book $book -> it is a route model binding and we didnt cached the whole book but we only cached the specific book
    public function show(int $id)
    {
        // Book that we cache by the BookID
        // the $id will be correctly correctly created as a string
        $cacheKey = 'book:' . $id;
        
        // Fetch the reviews
        // So now every single book that you will visit on an individual book page like this /books/58 in the show page will be cached and will be served directly from the cached for one hour. 
        // Aftert that the new Query to the database will be run for someone that visits this page and then it will be stored for another one hour again. 
        $book = cache()->remember(
            $cacheKey, 
            300, 
            fn() => 
            // load() method is only useful for the models that are already loaded. Load() is an instance method, its a method on a created object.
            // So we need to use static method of a class
            // with() one of the way to fetch the relations together with the model at the same time, in this case.
            // Load() is useful if you are fetching relations for a model that is already loaded.
            Book::with([
                'review' => fn($query) => $query->latest()
            ])->withAvgRating()->withReviewsCount()->FindOrFail($id)
        );
        // Caching the reviews, and this cache is stored for one hour.

        // Passing the Specific model in the View
        // Route Model Binding No need to use the FindOrFail($id) 
        // Laravel will fetch the Book for us Book $book -> Laravel will know that the argument in the route is related to an ID of a database model
        return view('books.show', ['book' => $book]);
            // Load some additional relationships or your can use this or lazy laoding in the template which is the show.blade.php 
            // With the sorting out from newest to oldest we use latest() in the local query scope and with the load() it is uses so that when fetching the books in the database it will not ruin the --
            // -- server part of fetching by all at once or you can use the Lazy Loading style as well in the Template in the show.balde.php
        
        }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
