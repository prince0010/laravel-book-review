@extends('layouts.app')

@section('content')

    <h1 id="titlesite" class="mb-10 text-3xl">
        Books Review
    </h1>

    <!-- Loading Indicator -->
    <div id="loading" class="hidden fixed inset-0 flex items-center justify-center ">
        <p class="text-2xl">Loading...</p>
    </div>

    <!-- Sending this form to the same route that renders this page that's books.index -->
    <!-- <form id="searchForm" action="{{route('books.index', array_merge(request()->query(), ['filter' => request('filter')]) )}}" method="get" class="mb-4 flex items-center space-x-2"> -->
    <form id="searchForm" action="{{route('books.index')}}" method="get" class="mb-4 flex items-center space-x-2">
    
    <input type="text" name="title" placeholder="Search the Title" 
        value="{{ request('title')}}" class="input h-10"/>

            <input type="hidden" name="filter" value="{{request('filter')}}"/>

        <button type="submit" class="btn h-10">Search</button>
        <a href="{{route('books.index')}}" class="btn h-10" id="clearButton">Clear</a>
    </form>

    <div id="filter-container" class="mb-4 flex space-x-2 rounded-md bg-slate-100 p-2">
        <!-- $key => $filter_data -->
    @php
        $filters = [
         '' => 'Latest',
         'popular_last_month' => 'Popular Last Month',
         'popular_last_6months' => 'Popular Last 6 Months',
         'highest_rated_last_month' => 'Highest Rated Last Month',
         'highest_rated_last_6months' => 'Highest Rated Last 6 Months'
        ];
    @endphp
     
     <!-- This is to display all the data's from the array in the $filters = [] in the @php Directive -->
     @foreach ($filters as $key => $filter_data )
     <!-- For the Selected Tab to be active or display then we need to use conditional style css -->
     <!-- ang request('filter') is naa sa url if ang naas url /book?filter=$key ->($key == popular_last_month or popular_last_6months or highest_rated_last_month or highest_rated_last_6months) then sa conditional style css or tailwindcss is true then kani i kwaon na class "filter-item-active" else "filter-item" -->
    <!-- By keeping all the other requests paremeters when we go to any of those tab links $filters sa frontend ex Popular Last Month and etc. so the ['filter' => $key ] is an array of all the query [parameters] that we pass so we can add something to it. 
        the request()->query() this would be an array of all the query parameters that request has. But since the request()->query() always returns an array an it is already inside in the array [request()->query(), 'filter' => $key] we will used the 
        SPREAD OPERATOR '...' before the request()->query() [...request()->query(), 'filter' => $key], this SPREAD OPERATOR will unpack this array request()->query() which means it will get every single element from the request()->query() array and it will 
        add that to this resulting [...request()->query(), 'filter' => $key] array.   -->
     <a href="{{ route('books.index', [...request()->query(), 'filter' => $key]) }}"
     class ="filter-link {{ request('filter') === $key || request('filter') === null && $key === '' ? "filter-item-active" : "filter-item"}}"
     >
     <!-- onclick="logFilterData('{{ $key }}', '{{ $filter_data }}'); return false;"   -->
        {{ $filter_data }}
    </a>
     @endforeach

    </div>

    <!-- $books is the variable that is passed to this view and you can find it in the BookController index() resource controller -->
    <ul id="booksList">
        @forelse ($books as $book)
            <li class="mb-4">
                <div class="book-item">
                    <div class="flex flex-wrap items-center justify-between">
                        <div class="w-full flex-grow sm:w-auto">
                            <a href="{{route('books.show', $book)}}" class="book-title">{{ $book->title }}</a>
                            <span class="book-author">by {{ $book->author}}</span>
                        </div>
                        <div>
                            <div class="book-rating">
                                <!-- {{ number_format($book->review_avg_rating, 2) }} -->
                                <x-star-rating :ratings="$book->review_avg_rating" />
                            </div>
                            <div class="book-review-count">
                                out of {{ $book->review_count }} {{ Str::plural('review', $book->review_count) }}
                            </div>
                        </div>
                    </div>
                </div>
            </li>
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
        @if ($books->count() > 0 && $books->hasPages())
        <div id="pagination" class="mt-4">
            {{ $books->links() }}
        </div>
    @endif
    <!-- Loading -->
    <script>

        function showLoading(){
            document.getElementById('loading').classList.remove('hidden');
            document.getElementById('searchForm').classList.add('hidden');
            document.getElementById('booksList').classList.add('hidden');
            document.getElementById('filter-container').classList.add('hidden');
            document.getElementById('titlesite').classList.add('hidden');
            document.getElementById('pagination').classList.add('hidden');

        }

        document.getElementById('searchForm').addEventListener('submit', showLoading);
        document.getElementById('clearButton').addEventListener('click', showLoading);

        document.querySelectorAll('.filter-link').forEach(function(link){
            link.addEventListener('click', function(e) {
                showLoading();
            });
        });

        function logFilterData(key, filterData) {
        console.log('Clicked filter: ' + filterData + ' (Key: ' + key + ')');
        // Add additional actions here if needed
    }
    </script>
@endsection
