<?php

$config = [
    'defaultRoute' => 'adverts/advert',
    'language' => 'ru',
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'authClientCollection' => [
            'class' => 'yii\authclient\Collection',
            'clients' => [
                'vkontakte' => [
                    'class' => 'common\modules\authclient\clients\VKontakte',
                    'clientId' => CLIENT_ID_VKONTAKTE,
                    'clientSecret' => CLIENT_SECRET_VKONTAKTE,
                    'delay' => 0.7,
                    'delayExecute' => 120,
                    'limitExecute' => 1,
                ],
                'facebook' => [
                    'class' => 'common\modules\authclient\clients\Facebook',
                    'clientId' => CLIENT_ID_FACEBOOK,
                    'clientSecret' => CLIENT_SECRET_FACEBOOK,
                ],
                'google' => [
                    'class' => 'common\modules\authclient\clients\Google',
                    'clientId' => CLIENT_ID_GOOGLE,
                    'clientSecret' => CLIENT_SECRET_GOOGLE,
                ],
                'twitter' => [
                    'class' => 'common\modules\authclient\clients\Twitter',
                    'attributeParams' => [
                        'include_email' => 'true'
                    ],
                    'consumerKey' => CLIENT_ID_TWITTER,
                    'consumerSecret' => CLIENT_SECRET_TWITTER,
                ],
                'yandex' => [
                    'class' => 'common\modules\authclient\clients\Yandex',
                    'clientId' => CLIENT_ID_YANDEX,
                    'clientSecret' => CLIENT_SECRET_YANDEX,
                ],
            ]
        ],
        'authClientComponent' => [
            'class' => 'common\modules\authclient\components\AuthClientComponent',
        ],
        'bookmarksManager' => [
            'class' => 'common\modules\core\components\BookmarksManager',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'formatter' => [
            'class' => 'common\modules\core\i18n\Formatter',
            'defaultTimeZone' => 'Europe/Moscow',
            'dateFormat' => 'php:j.m.Y',
            'timeFormat' => 'php:H:i',
            'datetimeFormat' => 'php:j M Y, H:i',
            'nullDisplay' => '',
            'currencyCode' => null,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
        ],
        'sphinx' => [
            'class' => 'yii\sphinx\Connection',
            'dsn' => 'mysql:host=127.0.0.1;port=9312',
            'username' => 'root',
            'password' => '',
        ],
        'vk' => [
            'class' => 'common\modules\authclient\clients\VKontakte',
            'clientId' => '11111',
            'clientSecret' => 'n9wsv98svSD867SA7dsda87',
            'delay' => 0.7, // Минимальная задержка между запросами
            'delayExecute' => 120, // Задержка между группами инструкций в очереди
            'limitExecute' => 1, // Количество инструкций на одно выполнении в очереди
            'captcha' => 'captcha', // Компонент по распознованию капчи
        ],
        'vkPublisher' => [
            'class' => 'common\modules\authclient\components\VkPublisher'
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
        ],
        'view' => [
            'class' => 'common\modules\core\web\View',
        ],
    ],
];

return $config;