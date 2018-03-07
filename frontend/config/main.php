<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-frontend',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'frontend\controllers',
    'components' => [
        'assetManager' => [
            'bundles' => !YII_DEBUG ? require __DIR__ . '/assets-prod.php'  : require __DIR__ . '/assets-dev.php',
        ],
        'urlManager' => [
            'rules' => require __DIR__ . '/routes.php',
        ],
    ],
    'modules' => [
        'adverts' => [
            'class' => 'frontend\modules\adverts\AdvertsModule',
        ],
        'users' => [
            'class' => 'frontend\modules\users\UsersModule',
        ],
    ],
    'params' => $params,
];
