<?php

namespace common\modules\core\actions;

use common\modules\core\base\Action;
use common\modules\core\models\ar\Comment;
use Yii;
use yii\helpers\Url;
use yii\web\Response;

class CommentDeleteAction extends Action
{
    /**
     * @inheritdoc
     */
    public function run($modelId, $modelName)
    {
        $model = new Comment();
        $model->load(Yii::$app->request->post());
        $model->save();
    }
}