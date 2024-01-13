<?php

// config/dataforseo.php

return [
    'DATAFORSEO_LOGIN' => env('DATAFORSEO_LOGIN', 'login'),
    'DATAFORSEO_PASSWORD' => env('DATAFORSEO_PASSWORD', 'password'),
    'timeoutForEachRequests' => 120,
    'apiVersion' => '/v3/',
    'url' => 'https://api.dataforseo.com',
    'extraEntitiesPaths' => [
        // 'path/to/extra/entity',
    ],
];
