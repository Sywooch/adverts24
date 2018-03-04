<?php

namespace frontend\assets;

use yii\web\AssetBundle;

class AppAsset extends AssetBundle
{
    /**
     * @inheritdoc
     */
    public $basePath = '@webroot';

    /**
     * @inheritdoc
     */
    public $baseUrl = '@web';

    /**
     * @inheritdoc
     */
    public $css = [
        'libs/bootstrap/dist/css/bootstrap.css',
        'css/bootstrap.css',
        'css/src/page.css',
        'css/src/bootstrap.css',
        'css/src/yii.css',
        'css/src/widgets.css',
        'css/src/icons.css',
        'css/src/auth.css',
        'css/src/adverts-list.css',
        'css/src/advert-form.css',
        'css/src/users.css',
    ];

    /**
     * @inheritdoc
     */
    public $js = [

    ];

    /**
     * @inheritdoc
     */
    public $depends = [
        'yii\bootstrap\BootstrapPluginAsset',
        'yii\web\YiiAsset',
    ];
}