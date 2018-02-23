<?php

use common\modules\users\models\ar\User;
use common\modules\core\widgets\DetailView;

/**
 * @var yii\web\View $this
 * @var \common\modules\users\models\ar\User $model
 */

$this->title = $model->fullName;
//$this->params['breadcrumbs'][] = ['label' => UserManagementModule::t('back', 'Users'), 'url' => ['index']];
//$this->params['breadcrumbs'][] = $this->title;

?>

<div class="user-view">

    <h2 class="lte-hide-title"><?= $this->title ?></h2>

    <div class="panel panel-default">
        <div class="panel-body">

            <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                    'fullName',
                    [
                        'attribute' => 'status',
                        'value' => User::getAttributeLabels('status', $model->status),
                    ],
                    [
                        'attribute' => 'email',
                        'value' => $model->email,
                        'format' => 'email',
                        'visible' => !$model->isAuthClient,
                    ],
                    [
                        'attribute' => $model->userAuthClient && $model->userAuthClient->getAttributeLabel('profile_url'),
                        'value' => $model->userAuthClient && $model->userAuthClient->profile_url,
                        'format' => 'email',
                        'visible' => $model->isAuthClient,
                    ],
                    'created_at:datetime',
                ],
            ]) ?>

        </div>
    </div>
</div>
