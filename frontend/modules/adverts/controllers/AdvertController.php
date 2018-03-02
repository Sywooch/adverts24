<?php

namespace frontend\modules\adverts\controllers;

use common\modules\adverts\models\ar\Advert;
use common\modules\adverts\models\ar\AdvertTemplet;
use common\modules\adverts\models\search\AdvertSearch;
use common\modules\core\behaviors\WidgetPageSizeBehavior;

use Yii;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;
use yii\web\Response;

/**
 * Class AdvertController
 */
class AdvertController extends \common\modules\adverts\controllers\AdvertController
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return ArrayHelper::merge(parent::behaviors(), [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index', 'view', 'published', 'bookmarks', 'bookmark'],
                        'roles' => ['?', '@'],
                    ],
                    [
                        'allow' => true,
                        'actions' => [
                            'create', 'validate', 'save-templet', 'clear-templet', 'update', 'delete',
                            'like', 'comment-add', 'file-upload', 'file-delete'
                        ],
                        'roles' => ['@'],
                    ],
                ],
            ],
        ]);
    }

    /**
     * Adverts list.
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new AdvertSearch();

        $searchParams = Yii::$app->request->queryParams;
        $dataProvider = $searchModel->searchActive($searchParams);

        return $this->renderIsAjax('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'renderFilter' => true,
        ]);
    }

    /**
     * List of the published adverts.
     * @return string
     */
    public function actionPublished()
    {
        $searchModel = new AdvertSearch();
        $dataProvider = $searchModel->searchPublished();

        return $this->renderIsAjax('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'renderFilter' => false,
        ]);
    }

    /**
     * List of the bookmarked adverts.
     * @return string
     */
    public function actionBookmarks()
    {
        $searchModel = new AdvertSearch();
        if (!Yii::$app->user->isGuest) {
            $dataProvider = $searchModel->searchBookmarked();
        } else {
            $dataProvider = $searchModel->search(['id' => [

            ]]);
        }

        return $this->renderIsAjax('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'renderFilter' => false,
        ]);
    }

    /**
     * Advert creating.
     * @return Response
     */
    public function actionCreate()
    {
        $request = Yii::$app->request;
        $templet = AdvertTemplet::getByUserId(Yii::$app->user->id);
        $model = new Advert([
            'user_id' => $templet->user_id
        ]);
        $directPopulating = true;

        if ($model->load($request->post(), '') && $model->save()) {
            $templet->clear();
            $templet->attachFilesToAdvert($model);
            Yii::$app->session->setFlash('success', true);
            return $this->redirect('');
        }

        $model->copyFromTemplet($templet->attributes);

        return $this->renderIsAjax('create', compact('model', 'templet', 'directPopulating'));
    }

    /**
     * Advert templet saving.
     * @throws NotFoundHttpException
     */
    public function actionSaveTemplet()
    {
        $request = Yii::$app->request;

        if (!$request->isPost) {
            throw new NotFoundHttpException();
        }

        $model = AdvertTemplet::getByUserId(Yii::$app->user->id);
        $model->load($request->post(), '');
        $model->save();
    }

    /**
     * Advert templet clearing.
     * @return Response
     */
    public function actionClearTemplet()
    {
        $model = AdvertTemplet::getByUserId(Yii::$app->user->id);
        $model->clear();
        $model->save();

        return $this->redirect(Yii::$app->request->referrer);
    }

    /**
     * @inheritdoc
     */
    public function actionValidate($id = null)
    {
        if (!$id) {
            $model = AdvertTemplet::getByUserId(Yii::$app->user->id);
            $model->load(Yii::$app->request->post(), '');
            $model->save();
        }

        return parent::actionValidate($id);
    }

    /**
     * @inheritdoc
     * @return Advert|null
     * @throws NotFoundHttpException
     */
    public function findModel($id, $mode = self::MODE_READ)
    {
        if ($this->modelName == AdvertTemplet::className()) {
            return AdvertTemplet::getByUserId(Yii::$app->user->id);
        }

        $model = Advert::find()
            ->active()
            ->withDislikesCount()
            ->withLikesCount()
            ->withLooksCount()
            ->withBookmarksCurrentUser()
            ->withLikesCurrentUser()
            ->with(['comments.user.profile'])
            ->andWhere([Advert::tableName() . '.id' => $id])
            ->one();

        if (!$model || ($mode == self::MODE_WRITE && $model->user_id != Yii::$app->user->id)
        ) {
            throw new NotFoundHttpException(Yii::t('app', 'Страница не найдена'));
        }

        return $model;
    }
}