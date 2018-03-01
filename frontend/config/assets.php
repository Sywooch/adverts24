<?php
/**
 * Configuration file for the "yii asset" console command.
 */

// In the console environment, some path aliases may not exist. Please define these:
Yii::setAlias('@webroot', __DIR__ . '/../web');
Yii::setAlias('@web', '/');


$definitions = require Yii::getAlias('@common/config/assets.php');
Yii::$container->setDefinitions($definitions);

return [
    // Adjust command/callback for JavaScript files compressing:
    'jsCompressor' => 'java -jar closure-compiler.jar --js {from} --js_output_file {to}',
    // Adjust command/callback for CSS files compressing:
    'cssCompressor' => 'java -jar node_modules/yuicompressor/build/yuicompressor-2.4.7.jar --type css {from} -o {to}',
    // Whether to delete asset source after compression:
    'deleteSource' => false,
    // The list of asset bundles to compress:
    'bundles' => [
        'frontend\assets\AppAsset',

        'yii\widgets\ActiveFormAsset',
        'yii\validators\ValidationAsset',

        'dosamigos\fileupload\FileUploadAsset',
        'dosamigos\fileupload\FileUploadPlusAsset',

        'kartik\datetime\DateTimePickerAsset',
        'kartik\base\WidgetAsset',
    ],
    // Asset bundle for compression output:
    'targets' => [
        'app' => [
            'class' => 'frontend\assets\AppAsset',
            'basePath' => '@webroot',
            'baseUrl' => '@web',
            'js' => 'js/app.js',
            'css' => 'css/app.css',
            'depends' => []
        ],
        'yii-form' => [
            'class' => 'yii\widgets\ActiveFormAsset',
            'basePath' => '@webroot',
            'baseUrl' => '@web',
            'js' => 'js/yii-form.js',
            'css' => 'css/yii-form.css',
            'depends' => [
                'yii\widgets\ActiveFormAsset',
                'yii\validators\ValidationAsset',
            ]
        ],
        'file-upload' => [
            'class' => 'dosamigos\fileupload\FileUploadAsset',
            'basePath' => '@webroot',
            'baseUrl' => '@web',
            'js' => 'js/file-upload.js',
            'css' => 'css/file-upload.css',
            'depends' => [
                'frontend\assets\AppAsset'
            ]
        ],
        'file-upload-plus' => [
            'class' => 'dosamigos\fileupload\FileUploadAsset',
            'basePath' => '@webroot',
            'baseUrl' => '@web',
            'js' => 'js/file-upload-plus.js',
            'css' => 'css/file-upload-plus.css',
            'depends' => [
                'dosamigos\fileupload\FileUploadAsset',
                'dosamigos\fileupload\FileUploadPlusAsset',
            ]
        ],
        'date-time-picker' => [
            'class' => 'kartik\datetime\DateTimePickerAsset',
            'basePath' => '@webroot',
            'baseUrl' => '@web',
            'js' => 'js/date-time-picker.js',
            'css' => 'css/date-time-picker.css',
            'depends' => [
                'kartik\datetime\DateTimePickerAsset',
                'kartik\base\WidgetAsset',
            ]
        ],
    ],
    // Asset manager configuration:
    'assetManager' => [
        'basePath' => '@webroot/assets',
        'baseUrl' => '@web/assets',
    ],
];