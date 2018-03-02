<?php

$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-backend',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['log'],
    'components' => [
        'assetManager' => [
            'bundles' => require __DIR__ . "/assets.php",
        ],
    ],
    'modules' => [
        'adverts' => [
            'class' => 'backend\modules\adverts\AdvertsModule',
        ],
        'users' => [
            'class' => 'backend\modules\users\UsersModule',
        ],
    ],
    'params' => $params,
];