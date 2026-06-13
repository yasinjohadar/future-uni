<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class PageController extends Controller
{
    public function show(string $page): View
    {
        $view = 'frontend.pages.' . $page;

        abort_unless(view()->exists($view), 404);

        return view($view);
    }
}
