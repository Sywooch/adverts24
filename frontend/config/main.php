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
            // this is the name of the session cookie used for login on the frontend
            'name' => '_session',
        ],
        'user' => [
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity', 'httpOnly' => true],
        ],
        'view' => [
            'class' => 'common\modules\core\web\View',
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
