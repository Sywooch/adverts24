<?php

namespace common\modules\core\behaviors\controllers;

use common\modules\core\web\Controller;
use common\modules\core\widgets\WidgetPageSize;
use yii\base\Behavior;
use Yii;

class WidgetPageSizeBehavior extends Behavior
{
    /**
     * @inheritdoc
     */
    public function events()
    {
        return [
            Controller::EVENT_BEFORE_ACTION => 'setPageSize'
        ];
    }

    /**
     * Sets widget page size.
     */
    public function setPageSize()
    {
        if ($pageSize = Yii::$app->request->headers->get(WidgetPageSize::PAGE_SIZE_PARAM_NAME)) {
            WidgetPageSize::setPageSize($pageSize, Yii::$app->request->headers->get(WidgetPageSize::WIDGET_ID_PARAM_NAME));
        }
    }
}