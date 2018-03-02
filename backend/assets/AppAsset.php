<?php

namespace backend\assets;

use yii\web\AssetBundle;
use Yii;

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
        'frontend/css/src/bootstrap.css'
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
        'app\assets\AdminLteAsset',
    ];

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        $this->css = [
            Yii::getAlias('@frontendWeb/css/bootstrap.css'),
            Yii::getAlias('@frontendWeb/css/back.css'),
        ];
    }
}
