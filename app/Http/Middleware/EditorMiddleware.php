<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EditorMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check() || !in_array(auth()->user()->role, ['editor', 'editor_in_chief'])) {
            abort(403, 'Unauthorized. Editor access required.');
        }
        
        return $next($request);
    }
}