<?php

return [
    'components' => [
        'assetManager' => [
            'bundles' => require __DIR__ . '/assets.php',
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'request' => [
            'csrfParam' => '_csrf',
        ],
        'response' => [
            'class' => 'common\modules\core\web\Response',
        ],
        'session' => [
            'name' => '_session',
            'cookieParams' => [
                'domain' => '.' . FRONTEND_DOMAIN
            ]
        ],
        'user' => [
            'class' => 'common\modules\core\web\User',
            'loginUrl' => '/users/auth/login',
            'identityCookie' => [
                'name' => '_identity',
                'httpOnly' => true,
            ]
        ],
    ],
];