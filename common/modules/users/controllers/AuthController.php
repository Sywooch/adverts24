<?php

namespace common\modules\users\controllers;

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
class AuthController extends \common\modules\core\web\Controller
{
    /**
     * Logout from site.
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();
        return $this->goHome();
    }
}
