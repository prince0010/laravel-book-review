<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class StarRating extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(    
        public readonly ?float $ratings // This wont be modified. You cant modify this value and it is a shortcut form newer of PHP to define a field on a class. 
        )

    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    // No need to pass this rating to the View and you can pass the $ratings in this view star rating
    public function render(): View|Closure|string
    {
        return view('components.star-rating');
    }
}
