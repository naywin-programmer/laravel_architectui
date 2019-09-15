<?php

namespace App\Http\View\Composers;

// use App\Models\Example;
use Illuminate\View\View;

class ExampleComposer
{
    public function __construct()
    {
        // Dependencies automatically resolved by service container...
    }

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        // $view->with('example', $example);
    }
}
