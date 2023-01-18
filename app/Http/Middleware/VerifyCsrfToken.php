<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array<int, string>
     */
    protected $except = [
        //
    ];

    function handle($request, \Closure $next)
    {
        if (env('APP_ENV') === 'local') {
            $this->except = [
                "*"
            ];
        }
        return parent::handle($request, $next);
    }

}
