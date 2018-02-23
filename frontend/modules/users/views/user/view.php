<?php

/**
 * @var $this yii\web\View
 * @var $model \common\modules\adverts\models\ar\Advert
 * @var $owner \common\modules\users\models\ar\User
 * @var $profile \common\modules\users\models\ar\Profile
 * @var $renderPartial bool
 */

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\DetailView;

use common\modules\users\components\GhostHtml;
use common\modules\users\models\rbacDB\Role;
use common\modules\users\models\ar\User;
use common\modules\users\UsersModule;


$this->title = $model->username;

?>
