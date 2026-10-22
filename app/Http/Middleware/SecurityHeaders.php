<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Vite;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

/**
 * Baseline security headers for every response.
 *
 * Public pages get an enforced, nonce-based Content-Security-Policy: every
 * <script> must carry nonce="{{ Vite::cspNonce() }}". The admin panel still
 * relies on many inline handlers from older plugins, so it gets the same
 * policy in report-only mode until those are cleaned up.
 */
class SecurityHeaders
{
    public function handle(Request $request, Closure $next): Response
    {
        $nonce = Str::random(32);
        Vite::useCspNonce($nonce);

        $response = $next($request);

        $headers = $response->headers;
        $headers->remove('X-Powered-By');
        header_remove('X-Powered-By');

        if ($request->isSecure()) {
            $headers->set('Strict-Transport-Security', 'max-age=31536000; includeSubDomains');
        }
        $headers->set('X-Content-Type-Options', 'nosniff');
        $headers->set('X-Frame-Options', 'SAMEORIGIN');
        $headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');
        $headers->set('Permissions-Policy', 'camera=(), microphone=(), geolocation=(), payment=(), usb=()');
        $headers->set('Cross-Origin-Opener-Policy', 'same-origin');

        // CSP only makes sense for HTML documents
        $type = (string) $headers->get('Content-Type');
        if ($type === '' || str_contains($type, 'text/html')) {
            $isAdmin = $request->is('admin', 'admin/*');
            $headers->set(
                $isAdmin ? 'Content-Security-Policy-Report-Only' : 'Content-Security-Policy',
                $this->policy($nonce, $request->isSecure())
            );
        }

        return $response;
    }

    private function policy(string $nonce, bool $secure): string
    {
        $directives = [
            "default-src 'self'",
            // 'strict-dynamic' lets nonced scripts (reCAPTCHA) load their own
            // helpers; the https:/unsafe-inline entries are ignored by modern
            // browsers and only act as a fallback for very old ones.
            "script-src 'self' 'nonce-{$nonce}' 'strict-dynamic' https: 'unsafe-inline'",
            "style-src 'self' 'unsafe-inline' https://fonts.googleapis.com",
            "font-src 'self' data: https://fonts.gstatic.com",
            "img-src 'self' data: blob: https:",
            "connect-src 'self' https://www.google.com https://www.gstatic.com",
            "frame-src 'self' https://www.google.com https://recaptcha.google.com https://www.youtube.com https://www.youtube-nocookie.com https://player.vimeo.com https://maps.google.com",
            "media-src 'self' https:",
            "object-src 'none'",
            "base-uri 'self'",
            "form-action 'self'",
            "frame-ancestors 'self'",
        ];

        if ($secure) {
            $directives[] = 'upgrade-insecure-requests';
        }

        return implode('; ', $directives);
    }
}
