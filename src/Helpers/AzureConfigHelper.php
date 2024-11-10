<?php

namespace Bagisto\AzureAuth\Helpers;

class AzureConfigHelper
{
    public static function isConfigured()
    {
        $client_id = config('services.azure.client_id');
        $client_secret = config('services.azure.client_secret');
        $redirect = config('services.azure.redirect');
        $tenant = config('services.azure.tenant');

        return ! empty($client_id) && ! empty($client_secret) && ! empty($redirect) && ! empty($tenant);
    }
}
