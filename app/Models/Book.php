<?php

namespace App\Models;

use GuzzleHttp\Psr7\Query;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Query\Builder as QueryBuilder;
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
    // Fetching the Titllel
    public function scopeTitle(Builder $query, $title) : Builder
    {
        return $query->where('title', 'LIKE', '%' . $title . '%');
    }

    // Local Query Scope
    public function scopePopular(Builder $query, $from = null, $to = null) : Builder|QueryBuilder
    {
         // Filtering the Reviews 
         // In the arrow function fn there is only one expression can be use and
         // No need to use the use() statement for the outside variables so basicallly you can have access of the outside variables like $from and $to

        return $query->withCount(['review' => fn (Builder $q) => $this->dateRangeFilter($q, $from, $to)
        ])
        ->orderBy('review_count', 'desc');
    }

    // Highest Rated to Lowest Rated
    public function scopeHighestRated(Builder $query, $from = null, $to = null) : Builder|QueryBuilder
    {
        return $query->withAvg(['review' => fn (Builder $q) => $this->dateRangeFilter($q, $from, $to)], 'rating')->orderBy('review_avg_rating', 'desc');
    }

    // Add some scope that would only show results when they have some minimun amount of reviews 
    // It will query only the review between the specific review and its higher than the specific review
    // minReview(3) -> It will query the output only the review_count that is equals to 3 or greater than 3 review until until as long as dili maubos or below sa 3 ang review i query ang output
    public function scopeMinReview(Builder $query, int $minReview) : Builder|QueryBuilder
    { 
        // We Use having() not where() clauses because when you are working with the results of aggregate functions, we need to use the having() clause
        return $query->having('review_count', '>=', $minReview);
    }

    // Lowest Rated Average
    // public function scopeLowestRated(Builder $query) : Builder|QueryBuilder
    // {
    //     return $query->withAvg('review', 'rating')->orderBy('review_avg_rating', 'asc');
    // }
    
    // // Unpopular Review
    // public function scopeUnpopular(Builder $query) : Builder|QueryBuilder 
    // {
    //     return $query->withCount('review')->orderBy('review_count', 'asc');
    // }

    // Internal Use the Private Function
    // $query is a object and object cannot return anything since object remember that the query object is an
    // object and objects are passed by reference not by copy. So you modify existed object so you dont realy
    // have to return anything from this method. 
    private function dateRangeFilter(Builder $query, $from = null, $to = null) {

        if($from && !$to){
            $query->where('created_at', '>=', $from);
        }elseif(!$from && $to){
            $query->where('created_at', '<=', $to);
        }
        elseif($from && $to){
            $query->whereBetween('created_at', [$from, $to]);
        }
    }

    public function scopePopularLastMonth(Builder $query) : Builder | QueryBuilder
    {
        return $query->popular(now()->subMonth(), now())
        ->highestRated(now()->subMonth(), now())
        ->minReview(2);
    }

    public function scopePopularLast6Month(Builder $query) : Builder | QueryBuilder
    {
        return $query->popular(now()->subMonths(6), now())
        ->highestRated(now()->subMonths(6), now())
        ->minReview(2);
    }

    public function scopeRatedLastMonth(Builder $query) : Builder|QueryBuilder
    {
        return $query->highestRated(now()->subMonth(), now())
        ->popular(now()->subMonth(), now())
        ->minReview(2);
    }
    public function scopeRatedLast6Month(Builder $query) : Builder|QueryBuilder
    {
        return $query->highestRated(now()->subMonths(6), now())
        ->popular(now()->subMonths(6), now())
        ->minReview(2);
    }

}
