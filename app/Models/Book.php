<?php

namespace App\Models;

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

}
