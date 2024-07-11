@if ($ratings)
<!-- We are doing a simple loop, looping from 1 to 5 -->
    @for($i = 1; $i <=5; $i++)
    <!--  and we are just checking if this current index $i is less or equal. The rating displaying full star or an empty star -->
    @if(  $i <= round($ratings))
        <span class="text-yellow-500">★</span>
    @else
        <span>☆</span>
    @endif
   
 
    @endfor
@else
No Rating is being Added Yet

@endif