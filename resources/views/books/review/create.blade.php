@extends('layouts.app')

@section('content')

<div class="flex items-center mb-5">
<a href="{{ url()->previous() }}" class="mr-2 p-2 rounded-full hover:bg-gray-200">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
        </svg>
    </a>
    <h1 class="mb-2 text-2xl">Leave a Review for {{$book->title}}</h1>
</div>

    <form method="POST" action="{{ route('books.review.store', $book)}}">
        @csrf
        <div class="form-group mt-5">
            <label for="review ">Review</label>
            <textarea name="review" id="review" class="input @error('review') border-red-500 shake @enderror">{{ old('review') }}</textarea>
          
            @error('review')
                <span class="text-red-500">{{ $message }}</span>
            @enderror
        </div>

        <div class="mt-4">
            <label for="rating">Rating</label>
            <select name="rating" id="rating" class="input @error('rating') border-red-500 shake @enderror" >
                <option value="">Select a Rating</option>
                @for ($i = 1; $i <= 5; $i++)
                    <option value="{{ $i }}" {{ old('rating') == $i ? 'selected' : '' }}>{{ $i }}</option>
                @endfor
            </select>

            @error('rating')
                <span class="text-red-500">{{ $message }}</span>
            @enderror
        </div>
        <button type="submit" class="btn mt-5">Add Review</button>
    </form>

    <style>
        .shake {
            animation: shake 0.5s ease-in-out;
        }

        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-5px); }
            50% { transform: translateX(5px); }
            75% { transform: translateX(-5px); }
        }
    </style>
@endsection
