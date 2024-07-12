@extends('layouts.app')

@section('content')

    <h1 class="mb-10 text-2xl">Leave a Review for {{$book->title}}</h1>

    <form method="POST" action="{{ route('books.review.store', $book)}}">
        @csrf
        <div class="form-group">
            <label for="review">Review</label>
            <textarea name="review" id="review" class="input @error('review') border-red-500 shake @enderror">{{ old('review') }}</textarea>
          
            @error('review')
                <spam class="text-red-500">{{ $message }}</spam>
            @enderror
        </div>

        <div class="mt-4">
            <label for="rating" >Rating</label>
            <select name="rating" id="rating" class="input @error('rating') border-red-500 shake @enderror" >
                <option value="">Select a Rating</option>
                @for ($i = 1; $i <= 5; $i++)
                    <option value="{{ $i }}" {{ old('rating') == $i ? 'selected' : '' }}>{{ $i }}</option>
                @endfor
            </select>

            @error('rating')
                <spam class="text-red-500 ">{{ $message }}</spam>
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
