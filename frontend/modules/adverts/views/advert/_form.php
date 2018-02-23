<?php

use common\modules\adverts\AdvertsModule;
use common\modules\adverts\models\search\AdvertCategorySearch;
use common\modules\currency\models\search\CurrencySearch;
use common\modules\core\widgets\ActiveForm;
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
 * @var \yii\web\View $this
 */

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
    'clientEvents' => [
        'ajaxSubmitComplete' => "function(event, jqXHR) {
            var url = jqXHR.getResponseHeader('X-Reload-Url');
            if (url) {
                            
            }
        }"
    ]
]); ?>

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
        </div>

        <div class="col-sm-5 col-md-4 col-lg-3">
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
                    'class' => 'form-group mb-0'
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
                ],
            ]); ?>

            <?= $form->field($model, 'currency_id', [
                'options' => [
                    'class' => 'form-group mb-0'
                ]
            ])->dropDownList(
                ArrayHelper::map(CurrencySearch::getList(), 'id', 'name')
            ); ?>

            <?= $form->field($model, 'min_price', [
                'options' => [
                    'class' => 'form-group mb-0'
                ]
            ])->textInput(); ?>

            <?= $form->field($model, 'max_price', [
                'options' => [
                    'class' => 'form-group mb-0'
                ]
            ])->textInput(); ?>
        </div>
    </div>

<?php /*$form->field($model, 'city_id')->dropDownList(City::getList(), [
        'name' => ($directPopulating) ? 'city_id' : null,
        'label' => 'City',
        'emptyItem' => Yii::t('app', 'Empty city option'),
    ])*/ ?>

    <div class="row mt-30">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div class="files-list" data-action="files-list">
                <?php
                $files = !$model->isNewRecord ? $model->files : $templet->files;
                ?>
                <?php if ($files): ?>
                    <?php /** @var $file \common\modules\core\models\ar\File */ ?>
                    <?php foreach ($files as $file): ?>
                        <?= $this->render('form/_file-container', [
                            'model' => $file
                        ]); ?>
                    <?php endforeach; ?>
                <?php endif; ?>
                <div class="files-empty<?= $files ? ' hide' : '' ?>"><?= Yii::t('app', 'Не загружено ни одного файла...'); ?></div>
            </div>
            <?= \yii\jui\ProgressBar::widget([
                'options' => [
                    'id' => 'files-progressbar',
                    'class' => 'files-progressbar',
                ]
            ]); ?>
        </div>
    </div>

    <div class="clear"></div>

    <div class="mt-20">
        <?= $this->render('form/files', [
            'model' => $model,
            'templet' => $templet,
        ]); ?>

        <span class="file-uploaded-success">Файл загружен</span>
        <span class="file-uploaded-fail">Произошла ошибка при загрузке файла</span>

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
    $js = <<<JS
jQuery('#advert-form').on('ajaxComplete', function(data) {
    $.ajax({
        url: '{$saveTempletUrl}',
        method: 'post',
        data: $(this).serialize(),
        success: function(data, textStatus, jqXHR ) {

    },
        error: function() {
        alert('Ошибка, данные объявления не сохранилиь автоматически!');
    }
    });    
});
JS;
    $this->registerJs($js, View::POS_READY);
}

$js = <<<JS
jQuery('#advert-form').on('click', '[data-action=file-delete]', function() {
    var self = $(this);
    var img = self.prev();
    var container = self.parent();
    container.css('width', img.css('width')).css('height', img.css('height'));
    container.find('[data-action=file-deleting]').show();
    self.removeClass('visible');
    $.ajax({
        url: self.attr('data-url'),
        success: function(data, textStatus, jqXHR) {
            self.prev().animate({
                width: 0
            }, 300, function() {
                self.parents('.file-container').remove();
            });
            $('.files-list .files-empty').show();
        },
        error: function() {
            alert('error. Посмотри firebug!');
        }
    });
    return false;
})
JS;
$this->registerJs($js, View::POS_READY);
?>