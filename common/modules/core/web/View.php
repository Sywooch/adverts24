<?php

namespace common\modules\core\web;

use yii\helpers\Json;

class View extends \yii\web\View
{
    /**
     * The location of registered JavaScript code block or files.
     * This means the location is at the end of the body section and after POOS_LOAD and POS_READY JavaScript.
     */
    const POS_FINISH = 6;

    /**
     * JavaAcript to pass to the client side.
     * @var array
     */
    public $jsAppData = [];

    /**
     * @inheritdoc
     */
    protected function renderHeadHtml()
    {
        $this->js[self::POS_HEAD][] = "window.app = " . Json::encode($this->jsAppData, JSON_PRETTY_PRINT) . ";\n";

        return parent::renderHeadHtml();
    }

    /**
     * @inheritdoc
     */
    protected function renderBodyEndHtml($ajaxMode)
    {
        $lines = parent::renderBodyEndHtml($ajaxMode);

        if (!empty($this->jsFiles[self::POS_FINISH])) {
            $lines .= implode("\n", $this->jsFiles[self::POS_FINISH]);
        }

        return $lines;
    }
}