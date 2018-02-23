<?php

namespace common\modules\core\actions;

use common\modules\core\base\Action;
use common\modules\core\models\ar\File;
use Yii;
use yii\helpers\Url;
use yii\web\Response;

class FileDeleteAction extends Action
{
    /**
     * @inheritdoc
     */
    public function run($id = null)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        //$controller = $this->controller;
        //$controller->findModel($id, $controller::MODE_WRITE);

        $success = false;
        if ($file = File::findOne($id)) {
            $success = (bool) $file->delete();
        }

        return [
            'success' => $success
        ];
    }
}