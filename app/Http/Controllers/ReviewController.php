<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function __construct()
    {
        $this->middleware('throttle:reviews');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create (Book $book)
    {
        // The book.review.create is frrom the php artisan route:list and you can see the GET part it has the books.review.create
        // Passing a book instance 'book' => $book to the user for which book they will be leaving for a review
        return view('books.review.create', ['book' => $book]); 
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Book $book) // We need the Book $book since it is a scope request
    {
        // We need a $request to get the data from the form and also to validate the data
        $data = $request->validate([
            'review' => 'required|min:15',
            'rating' => 'required|integer|min:1|max:5'  
        ]);

         // Log or debug to verify data
         \Log::info('Review Data: ', $data);

        // To use create() remember that the model has to have properties you are passing which is FILLABLE in the MODEL
        // It not just the create a new model, but it also automatically stores it inside the database.
        $book->review()->create($data); // So this is a scope create, it will create a new instance of the review and automatically associated with the specific book

        // Redirect back to the book page which the data of the $book
        return redirect()->route('books.show', $book);
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
