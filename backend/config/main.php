<?php

use yii\helpers\ArrayHelper;

$params = ArrayHelper::merge([
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
]);

return [
    'id' => 'app-backend',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['log'],
    'modules' => [],
    'components' => [
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'request' => [
            'csrfParam' => '_csrf-backend',
        ],
        'response' => [
            'class' => 'common\modules\core\web\Response',
        ],
        'session' => [
            // this is the name of the session cookie used for login on the backend
            'name' => '_session-backend',
        ],
        'user' => [
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-backend', 'httpOnly' => true],
        ],
        'view' => [
            'class' => 'common\modules\core\web\View',
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