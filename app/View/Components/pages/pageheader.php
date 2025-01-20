<?php

namespace App\View\Components\pages;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class pageheader extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public string $class='',
        public string $title= '',
        public string $color= '',
        public string $url= '',
        public string $buttonTitle= '',

    )
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.admin.pageheader');
    }
}
