<?php

namespace Bagisto\AzureAuth\Helpers;

class AzureConfigHelper
{
    public static function isConfigured(): bool
    {
        return !empty(
            config('services.azure.client_id')
            ?? config('services.azure.client_secret')
            ?? config('services.azure.redirect')
            ?? config('services.azure.tenant')
        );
    }
}
