<?php
namespace App\Http\Middleware; // <-- This should be correct

use Closure;
use Illuminate\Http\Request;

class IsCustomer // <-- This should be correct
{
    public function handle(Request $request, Closure $next)
    {
        // Your middleware logic here
        return $next($request);
    }
}