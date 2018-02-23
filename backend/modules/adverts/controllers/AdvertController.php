<?php

namespace backend\modules\adverts\controllers;

use common\modules\adverts\models\ar\Advert;
use Yii;
use yii\web\NotFoundHttpException;

/**
 * Class AdvertController
 */
class AdvertController extends \common\modules\adverts\controllers\AdvertController
{
    /**
     * @inheritdoc
     * @return Advert|null
     * @throws NotFoundHttpException
     */
    public function findModel($id, $mode = self::MODE_READ)
    {
        $model = Advert::find()
            ->withDislikesCount()
            ->withLikesCount()
            ->withLooksCount()
            ->withBookmarksCurrentUser()
            ->withLikesCurrentUser()
            ->with(['comments.user.profile'])
            ->andWhere([Advert::tableName() . '.id' => $id])
            ->one();

        if (!$model) {
            throw new NotFoundHttpException(Yii::t('app', 'Страница не найдена'));
        }

        return $model;
    }
}