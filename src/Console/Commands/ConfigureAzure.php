<?php

namespace Bagisto\AzureAuth\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

use function Laravel\Prompts\text;
use function Laravel\Prompts\info;
use function Laravel\Prompts\confirm;

class ConfigureAzure extends Command
{
    protected $signature = 'azure:configure';
    protected $description = 'Configure Azure environment variables';

    public function handle()
    {
        info('Welcome to the Microsoft Azure SSO configuration wizard');

        if ($this->keysExist()) {
            $overwrite = confirm('Azure configuration keys already exist. This wizard will overwrite existing settings. Continue?', false);

            if (!$overwrite) {
                return;
            }
        }

        $clientId = text(
            label: 'Please enter your Client ID',
            required: true
        );

        $this->updateEnvFile('AZURE_CLIENT_ID', $clientId);

        $clientSecret = text(
            label: 'Please enter your client Secret',
            required: true
        );

        $this->updateEnvFile('AZURE_CLIENT_SECRET', $clientSecret);

        $tenantId = text(
            label: 'Please enter your Tenant ID',
            required: true
        );

        $this->updateEnvFile('AZURE_TENANT_ID', $tenantId);

        Artisan::call('optimize');
        
        Artisan::call('vendor:publish', [
            '--provider' => "Bagisto\AzureAuth\Providers\AzureAuthServiceProvider",
            '--force'    => true
        ]);

        info('Azure SSO configuration completed successfully.');
    }

    protected function keysExist()
    {
        return env('AZURE_CLIENT_ID') !== null
            && env('AZURE_CLIENT_SECRET') !== null
            && env('AZURE_TENANT_ID') !== null;
    }

    protected function updateEnvFile($key, $value)
    {
        $envFilePath = base_path('.env');

        if (File::exists($envFilePath)) {
            $envContent = File::get($envFilePath);

            if (Str::contains($envContent, "{$key}=")) {
                $envContent = preg_replace("/{$key}=.*/", "{$key}=\"{$value}\"", $envContent);
            } else {
                $envContent .= PHP_EOL . "{$key}=\"{$value}\"";
            }

            File::put($envFilePath, $envContent);
        }
    }
}
