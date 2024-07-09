@extends('layouts.app')



@section('content')

    <h1 class="mb-10 text-2xl">
        Books
    </h1>

        <!-- Sending this form to the same route that renders this page that's books.index -->
    <form action="GET" action="{{route('books.index')}}">


    </form>

    <!-- $books is the variable that is passed to this view and you can find it in the BookController index() resource controller -->
    <ul>
        @forelse ($books as $book)
            <li class="mb-4">
    <div class="book-item">
        <div class="flex flex-wrap items-center justify-between">
            <div class="w-full flex-grow sm:w-auto">
                <!-- in the href="{{route('books.show', $book)}}" we just passed the $book varialbe for it has one parameter '$book'
                the laravel is smart enough to know that this one has one parameter. It wil know that it needs to pass a bookID because the $book is an object-->
                <a href="{{route('books.show', $book)}}" class="book-title">{{ $book->title }}</a>
                <span class="book-author">by {{ $book->author}}</span>
            </div>
            <div>

            
            <div class="book-rating">
                <!-- The review_avg_rating is an alias from the scope in the book where it will displays the output of the book rating of a book and you can see that in the php artisan tinker query. 
            We will only add the alias or some name from the output in order to display in the front-end. Just call the exact name alias or the name variable that will be display in the output in the query in sqp or postman or in the tinker => php artisan tinker -->
                {{ number_format($book->review_avg_rating, 2) }}
            </div>
            <div class="book-review-count">
                <!-- There is plural method of an Str object in the Laravel. You can pass verb to it so a noun to it. -->
                <!-- If the review_count is singular then it will convert and display review else it will display the plural which is reviews -->
                out of {{ $book->review_count }} {{ Str::plural('review', $book->review_count) }}
            </div>
           </div>
        </div>
    </div>
            </li>
            <!-- If No Data Book Found or Empty -->
            <!-- If we would not have any books or they will be filtered out as we allowing filitering to, we need to reset a link -->
    <!-- Easiest way for a reset link is to just link to a page without any parameters. EX: href="{{route('books.index')}}-->
        @empty
            <li class="mb-4">
                <div class="empty-book-item">
                    <p class="empty-text">
                        No Books Found
                    </p>
                    <a href="{{route('books.index')}}" class="reset-link"> Reset Criteria </a>
                </div>
            </li>
        @endforelse
    </ul>
@endsection