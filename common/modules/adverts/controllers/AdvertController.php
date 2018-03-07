<?php

namespace common\modules\adverts\controllers;

use common\modules\adverts\models\ar\Advert;
use common\modules\adverts\models\ar\AdvertTemplet;
use common\modules\adverts\models\search\AdvertSearch;
use common\modules\core\behaviors\controllers\WidgetPageSizeBehavior;
use common\modules\core\models\ar\File;
use common\modules\core\models\ar\Look;
use common\modules\core\web\Controller;
use Yii;
use yii\db\Expression;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\web\UploadedFile;
use yii\widgets\ActiveForm;

/**
 * Class AdvertController
 */
class AdvertController extends Controller
{
    /**
     * @var string
     */
    public $modelName = 'common\modules\adverts\models\ar\Advert';

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'bookmark' => [
                'class' => 'common\modules\core\actions\BookmarkToggleAction',
                'modelName' => Advert::className()
            ],
            'comment-add' => [
                'class' => 'common\modules\core\actions\CommentAddAction',
                'modelName' => Advert::className()
            ],
            'comment-delete' => [
                'class' => 'common\modules\core\actions\CommentDeleteAction',
                'modelName' => Advert::className()
            ],
            'file-upload' => [
                'class' => 'common\modules\core\actions\FileUploadAction',
                'modelName' => Yii::$app->request->get('owner'),
            ],
            'file-delete' => [
                'class' => 'common\modules\core\actions\FileDeleteAction',
                'modelName' => Yii::$app->request->get('owner'),
            ],
            'like' => [
                'class' => 'common\modules\core\actions\LikeAction',
                'modelName' => Advert::className()
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return ArrayHelper::merge(parent::behaviors(), [
            'widgetPageSize' => WidgetPageSizeBehavior::className()
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
        $dataProvider = $searchModel->search($searchParams);

        return $this->renderIsAjax('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'withFilter' => true,
        ]);
    }

    /**
     * Advert wiewing.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException
     */
    public function actionView($id)
    {
        $model = $this->findModel($id, self::MODE_READ);

        return $this->renderIsAjax('view', [
            'model' => $model
        ]);
    }

    /**
     * Advert updating.
     * @param integer $id
     * @return string|Response
     */
    public function actionUpdate($id)
    {
        /** @var Advert $model */
        $model = $this->findModel($id, self::MODE_WRITE);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
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
     * Advert deleting.
     * @param integer $id
     * @return Response
     * @throws NotFoundHttpException
     */
    public function actionDelete($id)
    {
        throw new NotFoundHttpException();
        $model = $this->findModel($id, self::MODE_WRITE);
        $model->delete();
        return $this->redirect(Yii::$app->request->referrer);
    }

    /**
     * Advert validating.
     * @param integer|null $id
     * @return array
     * @throws NotFoundHttpException
     */
    public function actionValidate($id = null)
    {
        $request = Yii::$app->getRequest();
        if (!$request->isAjax) {
            throw new NotFoundHttpException();
        }

        if ($id) {
            $model = $this->findModel($id);
        } else {
            $model = new Advert();
        }
        $model->load($request->post());

        Yii::$app->response->format = Response::FORMAT_JSON;
        return ActiveForm::validate($model);
    }
}