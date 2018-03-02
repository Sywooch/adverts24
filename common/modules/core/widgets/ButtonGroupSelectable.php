<?php

namespace common\modules\core\widgets;

use common\modules\core\helpers\ArrayHelper;

use yii\bootstrap\InputWidget;
use yii\helpers\Html;

class ButtonGroupSelectable extends InputWidget
{
    /**
     * @var array
     */
    public $items;

    /**
     * @var array
     */
    public $groupOptions = [
        'class' => 'btn-group-sm btn-group-justified'
    ];

    /**
     * @var array
     */
    public $labelOptions = [
        'class' => 'btn btn-info'
    ];

    /**
     * @var array
     */
    public $inputOptions = [
        'class' => 'form-control',
        'autocomplete' => 'off'
    ];

    /**
     * @inheritdoc
     */
    public function run()
    {
        $content = '';
        $inputValue = $this->hasModel() ? $this->model->{$this->attribute} : $this->value;

        foreach ($this->items as $key => $title) {
            $labelOptions = $this->labelOptions;
            $inputOptions = $this->inputOptions;

            if ($key == $inputValue) {
                Html::addCssClass($labelOptions, 'active');
                $inputOptions['checked'] = true;
            }

            $html = $title;
            $content .= Html::tag('label', $html, ArrayHelper::merge($labelOptions, [
                'data-value' => $key
            ]));
        }

        $content .= Html::activeHiddenInput($this->model, $this->attribute, $this->options);

        echo Html::tag('div', $content, ArrayHelper::merge([
            'id' => $this->id
        ], $this->groupOptions));

        $this->registerClientScript();
    }

    /**
     * Registers the client scripts.
     */
    public function registerClientScript()
    {
        $inputName = $this->hasModel() ? Html::getInputName($this->model, $this->attribute) : $this->name;

        $js = <<<JS
$(document).on('click', "#{$this->id} label", function(event) {
    var self = $(this), btnGroup = self.parent();
    btnGroup.find('label').removeClass('active');
    self.addClass('active');
    btnGroup.find('input[name=$inputName]').attr('value', self.attr('data-value')).trigger('change');
});
JS;

        $this->getView()->registerJs($js);
    }
}