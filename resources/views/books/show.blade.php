@extends('layouts.app')

@section('content')

    <div class="mb-4">
        <!-- Book Title -->
        <h1 class="sticky top-0 mb-2 text-3xl">
            {{ $book->title }}
        </h1>

        <!-- Book Information -->
        <div class="book-info">
            <div class="book-author mb-4 text-lg font-semibold ">
                by {{ $book->author }}
            </div>
            <div class="book-rating flex items-center">
                <div class="mr-2 text-sm font-medium text-slate-700">
                    {{ number_format($book->review_avg_rating, 2) }}
                </div>
                <span class="book-review-count text-sm text-gray-500">
                    {{ $book->review_count }} {{ Str::plural('review', $book->review_count ) }}
                </span>
            </div>
        </div>
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
                        <div class="font-semibold text-lg">{{ $review->rating }}</div>
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