<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    // we will add a fillable here for the review and rating for we can pass an array with these values
    protected $fillable = ['review', 'rating'];

    // This method inside the review model is used to define a so called inverse side of the one to many relationship between a review
    // and its book. Specifies that each review belongs to one book.
    public function book()
    {

        return $this->belongsTo(Book::class);

    }

    protected static function booted()
    {
        // Whenever the review model is modified then this static is triggered. Just make sure that this modification has to happen to a model so it cant be done directly inside the database. 
        // Now this event handler -> updated::() would not be called in all the situations
        // So if we are talkling about a book model then we need to call the cache()->forget() method
        // So if wea re talking about cache invalidation, this updated::() method for this review model wont be called. Obviously if you modify the database directly because this is outside Laravel,
        // if you use mass assignment, which means you would use an update method on a model, then also wont be triggered because the update method on the model does not first fetch the model, it just runs the query directly.
    //    So this wouldn't triggered then.
    // This Events updated() and deleted() wont be triggered if the updated of an rating or in the reviews will just run a query without LOADING the MODEL,
    // -- like this query in the php artisan tinker ;this wont trigger the updated() and deleted() events \App\Models\Review::query()->where('id', 944)->update(['rating' => 2]);
    // and those are the cases where those model events updated() and deleted() wont run. --
    // and this is the example that can trigger the model events -> in the php artisan tinker -> $review = \App\Models\Review::findOrFail(944); -> $review->rating = 2; >> $review->rating = 3; >> $review->save(); --
    // or \App\Models\Review::where('id', 944)->update(['rating' => 2]); >> This could work and trigger the model events as well
        static::updated(fn(Review $review) => cache()->forget('book:' . $review->book_id));
        static::deleted(fn(Review $review) => cache()->forget('book:' . $review->book_id));
        static::created(fn(Review $review) => cache()->forget('book:' . $review->book_id)); // so whenever a new review is created then this static is triggered and will reset the cache for a given book that is being reviewed.
       
    }
}
