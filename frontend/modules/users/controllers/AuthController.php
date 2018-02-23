<?php

namespace frontend\modules\users\controllers;

use common\modules\authclient\clients\ClientTrait;
use common\modules\core\widgets\ActiveForm;
use common\modules\users\components\UserAuthEvent;
use common\modules\users\models\ar\PasswordRestoreToken;
use common\modules\users\models\form\ChangePasswordForm;
use common\modules\users\models\form\EmailConfirmForm;
use common\modules\users\models\form\LoginForm;
use common\modules\users\models\form\RegistrationForm;
use common\modules\users\models\form\PasswordRestoreForm;
use common\modules\users\models\ar\User;
use common\modules\users\UsersModule;

use Yii;
use yii\authclient\BaseClient;
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;
use yii\web\Response;

/**
 * Class AuthController
 */
class AuthController extends \common\modules\users\controllers\AuthController
{
    /**
     * @inheritdoc
     */
    public function actions()
    {
         return [
             'client' => [
                 'class' => 'yii\authclient\AuthAction',
                 'successCallback' => [
                     $this, 'authSuccessCallback'
                 ],
                 'successUrl' => '/'
             ],
         ];
    }

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
                        'actions' => [
                            'login', 'registration', 'email', 'email-confirm', 'password-restore', 'captcha', 'change-password',
                            'client'
                        ],
                        'roles' => ['?'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['logout', 'profile', 'change-password'],
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Страница авторизации.
     * @return Response
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        $this->performAjaxValidation($model);

        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        return $this->renderIsAjax('login', compact('model'));
    }

    /**
     * Регистрация.
     * @return string|Response
     */
    public function actionRegistration()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $session = Yii::$app->session;
        $registeredUser = User::findOne($session->getFlash('registeredUserId'));
        $model = new RegistrationForm();
        $this->performAjaxValidation($model);

        if ($model->load(Yii::$app->request->post()) && $user = $model->registerUser()) {
            // TODO: реализовать копирование закладок из сессий в БД
            $session->setFlash('registeredUserId', $user->id);
            return $this->redirect('');
        }

        return $this->renderIsAjax('registration', compact('model', 'registeredUser'));
    }

    /**
     * Password recover form.
     * @return string|\yii\web\Response
     */
    public function actionPasswordRestore()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $request = Yii::$app->request;
        $sendingError = false;
        $model = new PasswordRestoreForm();
        $this->performAjaxValidation($model);

        if ($model->load($request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('passwordRestoreEmailSend', true);
                return $this->redirect('');
            } else {
                $sendingError = false;
            }
        }

        return $this->renderIsAjax('password-restore', compact('model', 'sendingError'));
    }

    /**
     *
     */
    public function actionChangePassword()
    {
        $request = Yii::$app->request;
        $passwordChanged = Yii::$app->session->getFlash('passwordChanged');
        $model = new ChangePasswordForm();

        if (Yii::$app->user->isGuest) {
            $user = User::findByPasswordRestoreToken($request->get('token'));
            if (!$user && !$passwordChanged) {
                throw new NotFoundHttpException();
            }
            $model->user = $user;
            $model->setScenario(ChangePasswordForm::SCENARIO_RESTORE_VIA_EMAIL);
        } else {
            if ($request->get('token')) {
                return $this->redirect('/users/auth/change-password');
            }
            $model->user = Yii::$app->user->identity;
        }

        $this->performAjaxValidation($model);

        if ($model->load($request->post()) && $model->changePassword()) {
            Yii::$app->session->setFlash('passwordChanged', true);
            return $this->redirect('/users/auth/change-password');
        }

        return $this->renderIsAjax('change-password', compact('model', 'passwordChanged'));
    }

    /**
     * Email confirmation.
     * @param string $token
     * @throws \yii\web\NotFoundHttpException
     * @return string|\yii\web\Response
     */
    public function actionEmailConfirm($token)
    {
        if ($model = User::findByEmailConfirmToken($token)) {
            Yii::$app->user->login($model);
            return $this->renderIsAjax('email-confirm', compact('model'));
        }

        throw new NotFoundHttpException();
    }

    /**
     * Callback that triggered when success client authorization.
     * @param BaseClient|ClientTrait $authClient
     */
    public function authSuccessCallback($authClient)
    {
        $attributes = $authClient->getUserAttributes();
        if (!$user = User::findByUserAuthClientId($authClient->userId, $authClient->name)) {
            $user = new User([
                'status' => User::STATUS_ACTIVE,
            ]);
            $user->scenario = User::SCENARIO_NEW_USER_AUTH_CLIENT;
            $user->register($authClient);
        }
        $user->userAuthClient->setClientAttributes($authClient);
        $user->userAuthClient->save();
        Yii::$app->user->login($user, 0);
    }
}
