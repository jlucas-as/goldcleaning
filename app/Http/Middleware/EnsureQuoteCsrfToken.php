<?php

namespace App\Http\Middleware;

use Closure;
use Symfony\Component\HttpFoundation\Cookie;

class EnsureQuoteCsrfToken
{
    public function handle($request, Closure $next)
    {
        $existingToken = (string) $request->cookie('gc_quote_csrf', '');
        $hasValidToken = preg_match('/^[a-f0-9]{64}$/', $existingToken) === 1;
        $token = $hasValidToken ? $existingToken : bin2hex(random_bytes(32));

        $request->attributes->set('quote_csrf_token', $token);
        $response = $next($request);

        if (!$hasValidToken) {
            $response->headers->setCookie(new Cookie(
                'gc_quote_csrf',
                $token,
                time() + 7200,
                '/',
                null,
                $request->isSecure(),
                true,
                false,
                Cookie::SAMESITE_LAX
            ));
        }

        return $response;
    }
}
