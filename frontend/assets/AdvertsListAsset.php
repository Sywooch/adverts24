<?php

namespace frontend\assets;

use common\modules\core\web\View;

use yii\web\AssetBundle;

class AdvertsListAsset extends AssetBundle
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
    public $css = [];

    /**
     * @inheritdoc
     */
    public $js = [
        'js/src/adverts-list.js',
    ];

    /**
     * @inheritdoc
     */
    public $jsOptions = [
        'position' => View::POS_FINISH
    ];

    /**
     * @inheritdoc
     */
    public $depends = [];
}