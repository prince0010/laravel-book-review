<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;
    // One to Many Relationship with the Reviews Table
    // The Book Can Have Many Review

    public function review(){

        return $this->hasMany(Review::class);

    }

    // Local Query Scope
    // This can be used in the tinker by making the query in the tinker as a method 
    // Like \App\Models\Book::where('title', 'LIKE', '%delectus%')->get(); 'delectus' is the title of the book
    // to - with the Query Scope - to > \App\Models\Book::title('delectus')->get();
    public function scopeTitle(Builder $query, $title) : Builder
    {
        return $query->where('title', 'LIKE', '%' . $title . '%');
    }

}
