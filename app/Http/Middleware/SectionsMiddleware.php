<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

use Symfony\Component\HttpFoundation\Response;

use App\Models\Section;
use Illuminate\Support\Facades\View;
class SectionsMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $sections = Section::all();
        View::share('sections', $sections);

        return $next($request);
    }
}
