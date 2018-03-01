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
            'bundles' => [
                /*'yii\bootstrap\BootstrapAsset' => [
                    'sourcePath' => null,
                    'baseUrl' => '@frontendWeb/libs/bootstrap/dist',
                ],*/
            ]
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