<?php

return [
    'yii\bootstrap\BootstrapAsset' => [
        'sourcePath' => null,
        'baseUrl' => '@web/libs/bootstrap/dist',
    ],
    'yii\web\YiiAsset' => [
        'sourcePath' => '@common/modules/core/assets/src',
        'js' => ['js/yii.js'],
    ],
    'yii\widgets\ActiveFormAsset' => [
        'sourcePath' => '@common/modules/core/assets/src',
        'js' => ['js/yii.activeForm.js'],
    ],
];