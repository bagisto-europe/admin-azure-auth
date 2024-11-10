<?php

return [
    'azure' => [
        'client_id'     => env('AZURE_CLIENT_ID'),
        'client_secret' => env('AZURE_CLIENT_SECRET'),
        'redirect'      => env('AZURE_REDIRECT_URL'),
        'tenant'        => env('AZURE_TENANT_ID'),
    ],
];
