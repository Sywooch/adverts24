<?php

use frontend\assets\AdvertFormAsset;
use common\modules\adverts\models\ar\Advert;
use common\modules\adverts\AdvertsModule;
use common\modules\adverts\models\search\AdvertCategorySearch;
use common\modules\currency\models\search\CurrencySearch;
use common\modules\core\widgets\ActiveForm;
use common\modules\core\widgets\ButtonGroupSelectable;
use common\modules\core\widgets\inputs\dateTimePicker\DateTimePicker;
use common\modules\core\widgets\inputs\multiSelect\MultiselectPopup;
use common\modules\geography\models\search\GeographySearch;

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;

/**
 * @var \common\modules\adverts\models\ar\Advert $model
 * @var \common\modules\adverts\models\ar\AdvertTemplet $templet
 * @var \common\modules\core\web\View $this
 */

AdvertFormAsset::register($this);

?>

<!-- Advert form -->
<?php $form = ActiveForm::begin([
    'id' => 'advert-form',
    'enableClientValidation' => true,
    'enableAjaxValidation' => true,
    'validateOnBlur' => true,
    'validationUrl' => Url::to(['validate', 'id' => $model->id]),
    'ajaxSubmit' => true, //Yii::$app->request->isAjax,
    'options' => [
        'class' => 'advert-form'
    ],
    'fieldConfig' => [
        'template' => "{label}\n{input}\n{error}",
        'inputOptions' => [
            'class' => 'form-control input-sm'
        ],
        'errorOptions' => [
            'tag' => 'div'
        ]
    ],
]); ?>

    <?= Html::activeHiddenInput($model, 'user_id'); ?>

    <div class="row">
        <div class="col-sm-7 col-md-8 col-lg-9">
            <?= $form->field($model, 'content', [
                'options' => [
                    'class' => 'form-group col-sm-12 col-md-12 col-lg-12'
                ]
            ])->textarea([
                'rows' => '18',
            ]) ?>
        </div>

        <div class="col-sm-5 col-md-4 col-lg-3">
            <?= $form->field($model, 'type', [
                'options' => [
                    'class' => 'form-group'
                ]
            ])->widget(ButtonGroupSelectable::className(), [
                'id' => 'button-group-type',
                'model' => $model,
                'attribute' => 'type',
                'items' => Advert::getAttributeLabels('type'),
            ]); ?>

            <?= $form->field($model, 'geography_id')->widget(MultiselectPopup::className(), [
                'model' => $model,
                'addonGlyphiconClass' => 'glyphicon-list',
                'attribute' => 'geography_id',
                'emptyText' => 'Указать',
                'notEmptyText' => 'Изменить',
                'likeInput' => true,
                'clientOptions' => [
                    'title' => 'Выбор месторасположения',
                    'dataUrl' => Url::to(['/geography/geography/index']),
                    'itemsChildEagerDisplaying' => true,
                    /*'items' => GeographySearch::getList([
                        'select' => ['id', 'title', 'items' => new \yii\db\Expression('1')],
                        'type' => Geography::TYPE_REGION,
                    ]),*/
                    'items' => GeographySearch::getCityListGroupedByRegion(),
                    'selectedValues' => $model->geography_id ? ArrayHelper::map(
                        GeographySearch::getList(['in', 'service_id', $model->geography_id], ['select' => ['service_id', 'title']]), 'service_id', 'title'
                    ) : [],
                    'selectedValuesContainerSelector' => '',
                    'showSelectedItems' => true,
                    'showSelectedInputs' => false,
                    'likeInput'
                ],
                'options' => [

                ]
            ]); ?>

            <?= $form->field($model, 'category_id')->widget(MultiselectPopup::className(), [
                'model' => $model,
                'attribute' => 'category_id',
                'emptyText' => 'Указать',
                'notEmptyText' => 'Изменить',
                'clientOptions' => [
                    'title' => 'Выбор категории',
                    'itemsDisplayMode' => MultiselectPopup::ITEMS_DISPLAY_MODE_INLINE,
                    'items' => ArrayHelper::map(
                        AdvertCategorySearch::getList([], ['select' => ['id', 'name']]), 'id', 'name'
                    ),
                    'selectedValues' => !empty($model->category_id) ? ArrayHelper::map(
                        AdvertCategorySearch::getList(['in', 'id', $model->category_id], ['select' => ['id', 'name']]), 'id', 'name'
                    ) : [],
                    'showSelectedItems' => true,
                    'showSelectedInputs' => false,
                    'showNavigation' => false,
                ],
                'options' => [
                    'tag' => 'span',
                    'class' => 'pl-5 cursor-pointer',
                ]
            ]); ?>

            <?= $form->field($model, 'expiry_at', [
                'options' => [
                    'class' => 'form-group'
                ]
            ])->widget(DateTimePicker::className(), [
                'layout' => '{input}{picker}',
                'options' => [
                    'class' =>'form-control input-sm',
                    'placeholder' => Yii::t('app', 'от'),
                    'value' => $model->getFormattedDatetime('expiry_at'),
                ],
                'pluginOptions' => [
                    'autoclose' => true,
                    'startDate' => date('Y-m-d'),
                    'endDate' => date('Y-m-d', time() + 3600 * 24 * 90),
                ],
            ]); ?>

            <?= $form->field($model, 'min_price', [
                'options' => [
                    'class' => 'form-group'
                ]
            ])->textInput(); ?>

            <?= $form->field($model, 'max_price', [
                'options' => [
                    'class' => 'form-group'
                ]
            ])->textInput(); ?>

            <?= $form->field($model, 'currency_id', [
                'options' => [
                    'class' => 'form-group',
                    'style' => !$model->min_price && !$model->max_price ? ' display: none' : ''
                ]
            ])->widget(ButtonGroupSelectable::className(), [
                'id' => 'button-group-currency',
                'model' => $model,
                'attribute' => 'type',
                'items' => ArrayHelper::map(CurrencySearch::getList(), 'id', 'short_name'),
            ]); ?>
        </div>
    </div>

<?php /*$form->field($model, 'city_id')->dropDownList(City::getList(), [
        'name' => ($directPopulating) ? 'city_id' : null,
        'label' => 'City',
        'emptyItem' => Yii::t('app', 'Empty city option'),
    ])*/ ?>

    <?= $this->render('_fileupload-files', [
        'model' => $model,
        'templet' => $templet,
    ]); ?>

    <div class="clear"></div>

    <div class="mt-20">
        <?= $this->render('_fileupload-button', [
            'model' => $model,
            'templet' => $templet,
        ]); ?>

        <div class="btn-group pull-right">
            <?php if ($model->isNewRecord): ?>
                <?= Html::submitButton(AdvertsModule::t('Опубликовать'), [
                    'class' => 'btn btn-primary btn-sm'
                ]); ?>

                <?php
                // TODO: взвесить и реализовать возможность добавления заметок в черновики
                /*print Html::a(AdvertsModule::t('Сохранить как черновик'), Url::to(['/advert/clear-templet']), [
                    'class' => 'btn btn-success btn-sm'
                ]);*/
                ?>

                <?= Html::a(AdvertsModule::t('Очистить'), Url::to(['clear-templet']), [
                    'class' => 'btn btn-warning btn-sm'
                ]) ?>
            <?php else: ?>
                <?= Html::submitButton(AdvertsModule::t('Сохранить изменения'), [
                    'class' => 'btn btn-primary btn-sm'
                ]); ?>
            <?php endif; ?>
        </div>
    </div>

    <div class="clear"></div>

<?php ActiveForm::end(); ?>

<?php
if (!Yii::$app->request->isAjax) {
    $saveTempletUrl = Url::to('/adverts/advert/save-templet');
    $this->registerJs($js, View::POS_READY);
}
?>
