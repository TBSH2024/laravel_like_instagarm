<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class PostMessages extends Component
{
    public $message;
    public $type;
    /**
     * Create a new component instance.
     */
    public function __construct($message, $type)
    {
        $this->messages = $message;
        $this->type = $type;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.post-messages');
    }
}