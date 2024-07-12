<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Cache\RateLimiter;
use Symfony\Component\HttpFoundation\Response;

class ThrottleReviewMiddleware
{
    protected $limiter;

    public function __construct(RateLimiter $limiter)
    {
        $this->limiter = $limiter;
    }

    public function handle(Request $request, Closure $next, $limit = 5, $expires = 60)
    {
        return $this->limiter->limit(
            $request->ip(),  // Use IP address to limit requests per user
            (int) $limit,
            (int) $expires,
            function () use ($request, $next) {
                return $next($request);
            }
        ) ?: response()->json(['message' => 'Too Many Attempts.'], Response::HTTP_TOO_MANY_REQUESTS);
    }
}
