<?php

namespace common\modules\core\widgets\inputs\multiSelect;

use yii\web\AssetBundle;

class MultiselectPopupAsset extends AssetBundle
{
    public $i18n;
    /**
     * @inheritdoc
     */
    public $baseUrl = '@web/libs/multiselect-popup';

    /**
     * @inheritdoc
     */
    public $js = [
        'multiselectPopup.js'
    ];
    /**
     * @inheritdoc
     */
    public $css = [
        'multiselectPopup.css'
    ];
    /**
     * @inheritdoc
     */
    public $depends = [
        'yii\jui\JuiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
