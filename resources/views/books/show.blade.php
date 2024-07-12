@extends('layouts.app')

@section('content')
<div class="flex items-center mb-5">
<a href="{{ route('books.index') }}" class="mr-2 p-2 rounded-full hover:bg-gray-200">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
        </svg>
    </a>
    <h1 class="mb-2 text-3xl">
        {{ $book->title }}
    </h1>
</div>

<div class="mb-4">
    <!-- Book Information -->
    <div class="book-info">
        <div class="book-author mb-4 text-lg font-semibold">
            by {{ $book->author }}
        </div>
        <div class="book-rating flex items-center">
            <div class="mr-2 text-sm font-medium text-slate-700">
                <!-- {{ number_format($book->review_avg_rating, 2) }} -->
                <x-star-rating :ratings="$book->review_avg_rating" />
            </div>
            <span class="book-review-count text-sm text-gray-500">
                {{ $book->review_count }} {{ Str::plural('review', $book->review_count ) }}
            </span>
        </div>
    </div>
</div>

<div class="mb-4">
    <a href="{{ route('books.review.create', $book)}}" class="btn">Add Review</a>
</div>

<div>
    <h2 class="mb-4 text-xl font-semibold">
        Reviews
    </h2>
    <ul>
        <!-- Iterate all of the reviews $book->review -->
        @forelse ($book->review as $review)
        <li class="book-item mb-4">
            <div>
                <div class="mb-2 flex items-center justify-between">
                    <div class="font-semibold text-lg">
                        {{ $review->rating }} 
                        <x-star-rating :ratings="$review->rating" />
                    </div>
                    <div class="book-review-count">
                        {{ $review->created_at->format('M j, Y') }}
                    </div>
                </div>
                <p class="text-gray-700">{{$review->review}}</p>
            </div>
        </li>
        @empty
        <li class="mb-4">
            <div class="empty-book-item">
                <p class="empty-text text-lg font-semibold">
                    No Reviews Yet!
                </p>
            </div>
        </li>
        @endforelse
    </ul>
</div>
@endsection
