<?php

namespace DarkDoom\HostSecurity;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Crypt;
use function config;

class HostSecurity {
    public function validateDomain(): bool
    {
        $encryptedDomain = config('host-security.encrypted_domain')
            ?? env('REGISTERED_DOMAIN_KEY');

        if (empty($encryptedDomain)) {
            return config('domain-protection.allow_empty', false);
        }

        try {
            $registeredDomain = Crypt::decryptString($encryptedDomain);
//            $currentDomain = request()->getHost();
            $currentDomain = "localhost:8000";


            return $this->compareDomains($registeredDomain, $currentDomain);
        } catch (\Exception $e) {
            Log::error('Domain validation failed: ' . $e->getMessage());
            return false;
        }
    }

    public function compareDomains(string $registered, string $current): bool
    {
        $registered = $this->normalizeDomain($registered);
        $current = $this->normalizeDomain($current);

        // Check exact match
        if ($registered === $current) {
            return true;
        }

        // Check wildcard subdomains if enabled
        if (config('domain-protection.allow_subdomains', false)) {
            return $this->matchesSubdomain($registered, $current);
        }

        return false;
    }

    protected function normalizeDomain(string $domain): string
    {
        $domain = strtolower(trim($domain));

        if (config('domain-protection.ignore_www', true)) {
            $domain = preg_replace('/^www\./', '', $domain);
        }

        return $domain;
    }

    protected function matchesSubdomain(string $registered, string $current): bool
    {
        return str_ends_with($current, '.' . $registered);
    }

    public function encryptDomain(string $domain): string
    {
        return Crypt::encryptString($this->normalizeDomain($domain));
    }

    public function decryptDomain(string $encrypted): ?string
    {
        try {
            return Crypt::decryptString($encrypted);
        } catch (\Exception $e) {
            return null;
        }
    }
}
