<?php

namespace Bagisto\AzureAuth\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

use function Laravel\Prompts\confirm;
use function Laravel\Prompts\info;
use function Laravel\Prompts\text;
use function Laravel\Prompts\warning;

class ConfigureAzure extends Command
{
    protected $signature = 'azure:configure';

    protected $description = 'Configure Azure environment variables';

    public function handle()
    {
        info('Welcome to the Microsoft Azure SSO configuration wizard');
        warning('Please add the redirect URI inside your Azure app registration: '.route('azure.callback'));

        if ($this->keysExist()) {
            warning('Existing Azure configuration keys found');
            $overwrite = confirm('Continuing will overwrite current settings. Do you want to proceed?', false);

            if (! $overwrite) {
                return;
            }
        }

        $clientId = text(
            label: 'Please enter your application (client) ID',
            required: true
        );

        $this->updateEnvFile('AZURE_CLIENT_ID', $clientId);

        $tenantId = text(
            label: 'Please enter your tenant ID',
            required: true
        );

        $this->updateEnvFile('AZURE_TENANT_ID', $tenantId);

        $clientSecret = text(
            label: 'Please enter your client Secret',
            required: true
        );

        $this->updateEnvFile('AZURE_CLIENT_SECRET', $clientSecret);

        $this->updateEnvFile('AZURE_REDIRECT_URL', route('azure.callback'));

        Artisan::call('vendor:publish', [
            '--provider' => "Bagisto\AzureAuth\Providers\AzureAuthServiceProvider",
            '--force'    => true,
        ]);

        Artisan::call('optimize');

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
                $envContent .= PHP_EOL."{$key}=\"{$value}\"";
            }

            File::put($envFilePath, $envContent);
        }
    }
}
