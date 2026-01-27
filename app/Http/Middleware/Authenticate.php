<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;
use Closure;

class Authenticate extends Middleware
{
    protected function redirectTo(Request $request)
    {
        return $request->expectsJson() ? null : route('login');
    }
}
