<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\ValidateCsrfToken as Middleware;

/**
 * Same CSRF check as the framework, minus the JS-readable XSRF-TOKEN cookie.
 * Every form and $.ajax call here sends the token from csrf_token() in the
 * page, so nothing needs that cookie -- and as a script-readable cookie it
 * can never be HttpOnly.
 */
class ValidateCsrfToken extends Middleware
{
    protected $addHttpCookie = false;
}
