<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {
        if (!$request->expectsJson()) {
            // Check which guard is being used based on the route
            if ($request->is('student-*') || $request->is('my-*')) {
                return route('student.login');
            } elseif ($request->is('admin/*') || $request->is('dashboard')) {
                return route('admin.login');
            }

            // Default to student login for public routes
            return route('student.login');
        }

        return null;
    }
}
