<?php

namespace App\View\Components\Layouts;

use Illuminate\View\Component;

class Footer extends Component
{
    /**
     * @var string
     */
    public string $app_name;

    /**
     * @var string
     */
    public string $created_by;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->app_name = APP_NAME;
        $this->created_by = now()->year . ' Triixa';
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.layouts.footer');
    }
}
