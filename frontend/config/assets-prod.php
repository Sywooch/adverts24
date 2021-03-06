<?php
/**
 * This file is generated by the "yii asset" command.
 * DO NOT MODIFY THIS FILE DIRECTLY.
 * @version 2018-03-02 17:41:23
 */
return [
    'app' => [
        'class' => 'frontend\\assets\\AppAsset',
        'basePath' => '@webroot',
        'baseUrl' => '@web',
        'js' => [
            'js/app.js',
        ],
        'css' => [],
        'depends' => [],
        'sourcePath' => null,
    ],
    'yii-form' => [
        'class' => 'yii\\widgets\\ActiveFormAsset',
        'basePath' => '@webroot',
        'baseUrl' => '@web',
        'js' => [
            'js/yii-form.js',
        ],
        'css' => [],
        'depends' => [],
        'sourcePath' => null,
    ],
    'file-upload' => [
        'class' => 'dosamigos\\fileupload\\FileUploadAsset',
        'basePath' => '@webroot',
        'baseUrl' => '@web',
        'js' => [],
        'css' => [
            'css/file-upload.css',
        ],
        'depends' => [],
        'sourcePath' => null,
    ],
    'file-upload-plus' => [
        'class' => 'dosamigos\\fileupload\\FileUploadAsset',
        'basePath' => '@webroot',
        'baseUrl' => '@web',
        'js' => [
            'js/file-upload-plus.js',
        ],
        'css' => [
            'css/file-upload-plus.css',
        ],
        'depends' => [],
        'sourcePath' => null,
    ],
    'date-time-picker' => [
        'class' => 'kartik\\datetime\\DateTimePickerAsset',
        'basePath' => '@webroot',
        'baseUrl' => '@web',
        'js' => [
            'js/date-time-picker.js',
        ],
        'css' => [
            'css/date-time-picker.css',
        ],
        'depends' => [],
        'sourcePath' => null,
    ],
    'yii\\web\\JqueryAsset' => [
        'sourcePath' => null,
        'js' => [],
        'css' => [],
        'depends' => [
            'app',
        ],
    ],
    'yii\\bootstrap\\BootstrapAsset' => [
        'sourcePath' => null,
        'css' => [
            'css/bootstrap.css',
        ],
        'basePath' => null,
        'baseUrl' => '/libs/bootstrap/dist',
        'depends' => [],
        'js' => [],
        'jsOptions' => [],
        'cssOptions' => [],
        'publishOptions' => [],
        'class' => 'yii\\bootstrap\\BootstrapAsset',
    ],
    'yii\\bootstrap\\BootstrapPluginAsset' => [
        'sourcePath' => null,
        'js' => [],
        'css' => [],
        'depends' => [
            'yii\\web\\JqueryAsset',
            'yii\\bootstrap\\BootstrapAsset',
            'app',
        ],
    ],
    'yii\\web\\YiiAsset' => [
        'sourcePath' => null,
        'js' => [],
        'css' => [],
        'depends' => [
            'yii\\web\\JqueryAsset',
            'app',
        ],
    ],
    'dosamigos\\fileupload\\BlueimpLoadImageAsset' => [
        'sourcePath' => null,
        'js' => [],
        'css' => [],
        'depends' => [
            'app',
        ],
    ],
    'dosamigos\\fileupload\\BlueimpCanvasToBlobAsset' => [
        'sourcePath' => null,
        'js' => [],
        'css' => [],
        'depends' => [
            'app',
        ],
    ],
    'yii\\widgets\\ActiveFormAsset' => [
        'sourcePath' => null,
        'js' => [],
        'css' => [],
        'depends' => [
            'yii\\web\\YiiAsset',
            'yii-form',
        ],
    ],
    'yii\\validators\\ValidationAsset' => [
        'sourcePath' => null,
        'js' => [],
        'css' => [],
        'depends' => [
            'yii\\web\\YiiAsset',
            'yii-form',
        ],
    ],
    'frontend\\assets\\AppAsset' => [
        'sourcePath' => null,
        'js' => [],
        'css' => [],
        'depends' => [
            'yii\\bootstrap\\BootstrapPluginAsset',
            'yii\\web\\YiiAsset',
            'file-upload',
        ],
    ],
    'dosamigos\\fileupload\\FileUploadAsset' => [
        'sourcePath' => null,
        'js' => [],
        'css' => [],
        'depends' => [
            'yii\\web\\JqueryAsset',
            'yii\\bootstrap\\BootstrapAsset',
            'file-upload-plus',
        ],
    ],
    'dosamigos\\fileupload\\FileUploadPlusAsset' => [
        'sourcePath' => null,
        'js' => [],
        'css' => [],
        'depends' => [
            'dosamigos\\fileupload\\FileUploadAsset',
            'dosamigos\\fileupload\\BlueimpLoadImageAsset',
            'dosamigos\\fileupload\\BlueimpCanvasToBlobAsset',
            'file-upload-plus',
        ],
    ],
    'kartik\\datetime\\DateTimePickerAsset' => [
        'sourcePath' => null,
        'js' => [],
        'css' => [],
        'depends' => [
            'yii\\web\\JqueryAsset',
            'yii\\bootstrap\\BootstrapAsset',
            'date-time-picker',
        ],
    ],
    'kartik\\base\\WidgetAsset' => [
        'sourcePath' => null,
        'js' => [],
        'css' => [],
        'depends' => [
            'yii\\web\\JqueryAsset',
            'yii\\bootstrap\\BootstrapAsset',
            'date-time-picker',
        ],
    ],
];