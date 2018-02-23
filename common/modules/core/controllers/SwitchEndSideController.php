<?php

namespace common\modules\core\controllers;

use common\modules\core\base\Module;
use common\modules\core\behaviors\EndSideBehavior;
use common\modules\core\web\Controller;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;

class SwitchEndSideController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'matchCallback' => function() {
                            return Yii::$app->user->isSuperadmin;
                        }
                    ],
                ],
            ],
        ];
    }

    /**
     * Switch end side.
     * @throws NotFoundHttpException
     */
    public function actionIndex()
    {
        if (Yii::$app->switchEndSide(Yii::$app->request->get('side'))) {
            $this->goHome();
        } else {
            throw new NotFoundHttpException();
        }
    }
}
