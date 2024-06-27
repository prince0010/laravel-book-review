<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Reviews Can't Associated on their own so they have to be associated with a specific book 'book_id'=>foreign_key
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();

            // $table->unsignedBigInteger('book_id');

            $table->text('review');
            $table->unsignedTinyInteger('rating');
            
            // $table->foreign('book_id')->references('id')->on('books')->onDelete('cascade');

            // Combination of $table->unsignedBigInteger('book_id') and $table->foreign('book_id')->references('id')->on('books')->onDelete('cascade'); In a shorter syntax
            $table->foreignId('book_id')->constrained('books')->cascadeOnDelete();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
