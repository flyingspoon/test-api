<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Sanitizer
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $input = $request->all();
        if (isset($input)) {
            array_walk_recursive($input, function(&$input) {
                $input = trim($input);
                $input = strip_tags($input);
                $input = htmlspecialchars($input, ENT_QUOTES);
            });
            $request->merge($input);
        }

        return $next($request);
    }
}
