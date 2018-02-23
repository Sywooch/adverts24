<?php

namespace common\modules\geography\controllers\front;

use yii\web\NotFoundHttpException;
use common\modules\geography\models\search\GeographySearch;

class GeographyController extends \common\modules\core\web\Controller
{
    /**
     *
     */
    public function actionIndex()
    {
        if (!Yii::$app->request->isAjax) {
            throw new NotFoundHttpException();
        }

        GeographySearch::getCityListGroupedByRegion();
    }
}