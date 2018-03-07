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
     */
    public function actionUpdate($id)
    {
        /** @var Advert $model */
        $model = $this->findModel($id, self::MODE_WRITE);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            if (!$model->published && $model->status = Advert::STATUS_ACTIVE) {
                Yii::$app->get('vkPublisher')->publishAdvert($model);
            }

            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return [
                    'success' => true,
                    'redirect-url' => Url::to(''),
                ];
            } else {
                $this->addFlashMessage('success', true);
                return $this->redirect('');
            }
        }

        return $this->renderIsAjax('update', [
            'model' => $model,
        ]);
    }

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