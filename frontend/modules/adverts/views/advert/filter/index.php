<?php

use common\modules\adverts\models\ar\AdvertTemplet;
use common\modules\adverts\models\search\AdvertSearch;
use common\modules\adverts\models\search\AdvertCategorySearch;
use common\modules\core\widgets\ActiveForm;
use common\modules\core\widgets\ButtonGroupSelectable;
use common\modules\core\widgets\inputs\dateTimePicker\DateTimePicker;
use common\modules\core\widgets\inputs\multiSelect\MultiselectPopup;
use common\modules\currency\models\search\CurrencySearch;
use common\modules\geography\models\search\GeographySearch;

use frontend\assets\AdvertsListAsset;
use frontend\modules\adverts\models\ar\Advert;

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;

/**
 * @var AdvertSearch $model
 * @var AdvertTemplet $templet
 * @var \yii\web\View $this
 */

AdvertsListAsset::register($this);

$expandIcons = '<span class="collapsed pull-right"></span><span class="expanded pull-right"></span>';

?>

<div class="adverts-list-filter-wrapper">
    <div id="adverts-list-filter" class="adverts-list-filter">
        <?php $form = ActiveForm::begin([
            'id' => 'filter-form',
            'options' => [
                'csrf' => false,
            ],
            'fieldConfig' => [
                'template' => '{label}{input}',
                'inputOptions' => [
                    'class' => 'form-control input-sm'
                ],
                'errorOptions' => [
                    'tag' => 'div'
                ]
            ],
            'enableClientValidation' => false,
        ]); ?>

        <!-- phrase -->
        <?php /*$form->field($model, 'phrase', [
            'options' => [
                'class' => 'form-group mb-0',
            ],
            'template' => '{label}<div class="input-group">{input}<span class="input-group-addon"><i class="glyphicon glyphicon-search"></i></span></div>'
        ])->textInput();*/ ?>

        <!-- type -->
        <?= $form->field($model, 'type', [
            'options' => [
                'class' => 'form-group mb-0'
            ]
        ])->widget(ButtonGroupSelectable::className(), [
            'id' => 'button-group-type',
            'model' => $model,
            'attribute' => 'type',
            'items' => Advert::getAttributeLabels('type'),
        ]); ?>

        <!-- geography_id -->
        <?= $form->field($model, 'geography_id', [

        ])->widget(MultiselectPopup::className(), [
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

        <!-- category_id -->
        <?= $form->field($model, 'category_id', [

        ])->widget(MultiselectPopup::className(), [
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

        <!-- min_date, max_date -->
        <?= $form->field($model, 'min_date', [
            'labelOptions' => [
                'label' => 'Дата',
                'class' => 'control-label'
            ],
        ])->widget(DateTimePicker::className(), [
            'options' => [
                'class' =>'form-control input-sm',
                'placeholder' => Yii::t('app', 'от'),
                'value' => $model->getFormattedDatetime('min_date'),
            ],
            'pluginOptions' => [
                'autoclose' => true,
            ],
        ]); ?>

        <?= $form->field($model, 'max_date', [
            'template' => '{input}',
        ])->widget(DateTimePicker::className(), [
            'options' => [
                'class' =>'form-control input-sm',
                'placeholder' => Yii::t('app', 'до'),
                'value' => $model->getFormattedDatetime('max_date'),
            ],
            'pluginOptions' => [
                'autoclose' => true,
            ],
        ]); ?>

        <!-- min_price, max_price -->
        <?= $form->field($model, 'min_price', [
            'options' => [
                'class' => 'form-group',
            ],
        ])->textInput([
            'placeholder' => Yii::t('app', 'от')
        ]); ?>

        <?= $form->field($model, 'max_price', [
            'template' => '{input}',
            'options' => [
                'class' => 'form-group'
            ],
        ])->textInput([
            'placeholder' => Yii::t('app', 'до')
        ]); ?>

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

        <?= Html::a('Сбросить фильтр', Url::home(), [
            'class' => 'btn btn-secondary btn-sm clear-filter'
        ]); ?>

        <?php ActiveForm::end(); ?>
    </div>
</div>