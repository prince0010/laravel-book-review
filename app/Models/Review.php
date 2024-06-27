<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    // we will add a fillable here for the review and rating for we can pass an array with these values
    protected $fillable=['review', 'rating'];

    // This method inside the review model is used to define a so called inverse side of the one to many relationship between a review
    // and its book. Specifies that each review belongs to one book.
    public function book(){
        return $this->belongsTo(Book::class);
    }
}
