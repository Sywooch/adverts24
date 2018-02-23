<?php

namespace common\modules\core\web;

use common\modules\adverts\models\Advert;
use Yii;

/**
 * @property  boolean $isSuperadmin
 */
class User extends \yii\web\User
{
    /**
     * @inheritdoc
     */
    public $enableAutoLogin = true;

    /**
     * @inheritdoc
     */
    public $loginUrl = ['/user/auth/login'];

    /**
     * @inheritdoc
     */
    public $identityClass = 'common\modules\users\models\ar\User';

    /**
     * Whether user is admin.
     * @return bool
     */
    public function getIsSuperadmin()
    {
        return Yii::$app->user->identity && Yii::$app->user->identity->superadmin == 1;
    }
}