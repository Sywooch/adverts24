<?php

namespace backend\components;

use Yii;

class Application extends \yii\web\Application
{
    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        $user = Yii::$app->user;
        if ($user->isGuest || !$user->isSuperadmin) {
            Yii::$app->response->redirect(FRONTEND_URL);
            Yii::$app->end();
        }
    }
}