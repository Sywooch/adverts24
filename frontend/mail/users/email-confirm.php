<?php

/**
 * @var $this yii\web\View
 * @var $user \common\modules\users\models\ar\User
 */

use common\modules\users\UsersModule;
use yii\helpers\Url;

?>

<?= UsersModule::t('Для подтверждения регистрации перейдите по ссылке: {link}. Ссылка действительна в течении недели.', 'front', [
    'link' => Url::to(['/users/auth/email-confirm', 'token' => $user->emailConfirmToken->token], true)
]); ?>