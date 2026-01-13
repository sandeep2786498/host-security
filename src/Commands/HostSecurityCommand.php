<?php

namespace DarkDoom\HostSecurity\Commands;

use DarkDoom\HostSecurity\HostSecurity;
use Illuminate\Console\Command;

class HostSecurityCommand extends Command
{
    public $signature = 'host-security {domain}';

    public $description = 'Host Security checker';

    public function handle(HostSecurity $service): int
    {
        $domain = $this->argument('domain');
        $this->info('Encrypting domain: ' . $domain);
        $encrypted = $service->encryptDomain($domain);

        $this->newLine();
        $this->line('Add this to your .env file:');
        $this->line('<fg=green>REGISTERED_DOMAIN_KEY=' . $encrypted . '</>');

        $this->newLine();
        $this->comment('Make sure to keep your APP_KEY secure!');

        return self::SUCCESS;
    }

}
