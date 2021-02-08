<?php

namespace App\View\Components\Layouts;

use Illuminate\View\Component;

class Header extends Component
{
    public string $header;

    /**
     * Create a new component instance.
     *
     * @param $header
     */
    public function __construct($header)
    {
        $this->header = $header;
    }
    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.layouts.header');
    }
}
