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

        // here in the first argument the $title and the second argument function () If title is not empty then it will run otherwist in wont 
        // $book = Book::when($title, function ($query, $title) { 
        //     return $query->$title('title');

        // })

        // ARROW FUNCTION
        // The title($title) and the where() method is all in the local query scope in the Book.php Model where it has the scopeTitle and the $query for that is from the local query which has the where() method and you can check that in the Book.php Model
        // Creating an Optional Query using this model's when() method -> if this $title is being supplied as a query parameter to this action, then we optionally call our own local query scope called title as a reminder
    //    And it is simple where $query-> that is using a LIKE operator
        $book = Book::when($title, fn ($query, $title) => $query->title($title)
        )
        ->get();

        // This is just renders this view,
        return view('books.index', ['books' => $book]);

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
    public function show(string $id)
    {
        //
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
