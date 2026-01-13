<?php

namespace DarkDoom\HostSecurity\Middleware;
use Closure;
use DarkDoom\HostSecurity\HostSecurity;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ValidateDomainMiddleware
{
    public function __construct(
        protected HostSecurity $domainService
    ) {}

    public function handle(Request $request, Closure $next): Response
    {
        if (!$this->domainService->validateDomain()) {
            abort(403, config('host-security.error_message', 'Unauthorized domain access.'));
        }

        return $next($request);
    }
}
