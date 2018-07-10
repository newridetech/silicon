<?php

return [
    'authServerUrl' => env('KEYCLOAK_AUTH_SERVER_URL'),
    'realm' => env('KEYCLOAK_REALM'),
    'clientId' => env('KEYCLOAK_CLIENT_ID'),
    'clientSecret' => env('KEYCLOAK_CLIENT_SECRET'),
    'redirectUri' => env('KEYCLOAK_REDIRECT_URL'),
    'encryptionAlgorithm' => env('KEYCLOAK_ENCRYPTION_ALGORITHM'),
    'encryptionKeyPath' => base_path(env('KEYCLOAK_ENCRYPTION_KEY_PATH')),
    'encryptionKey' => env('KEYCLOAK_ENCRYPTION_KEY'),
];
