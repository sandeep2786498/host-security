<?php

namespace DarkDoom\HostSecurity;

use DarkDoom\HostSecurity\Middleware\ValidateDomainMiddleware;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use DarkDoom\HostSecurity\Commands\HostSecurityCommand;

class HostSecurityServiceProvider extends PackageServiceProvider
{

    public function configurePackage(Package $package): void
    {
        $package
            ->name('host-security')
            ->hasConfigFile()
            ->hasCommand(HostSecurityCommand::class);
    }

    public function packageRegistered(): void
    {
        $this->app->singleton(HostSecurity::class, function ($app) {
            return new HostSecurity();
        });
    }

    public function packageBooted(): void
    {
        // Validate domain on boot if enabled
        if (config('host-security.enabled', true) &&
            !$this->app->runningInConsole() &&
            !$this->app->runningUnitTests()) {

            $domainService = $this->app->make(HostSecurity::class);

            if (!$domainService->validateDomain()) {
                abort(403, config('host-security.error_message', 'Unauthorized domain access.'));
            }
        }

        // Register middleware
        $router = $this->app['router'];
        $router->aliasMiddleware('domain.protect', ValidateDomainMiddleware::class);
    }

}
