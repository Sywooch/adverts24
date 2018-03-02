<?php

namespace common\modules\core\widgets\inputs\dateTimePicker;

use common\modules\core\web\View;

use Yii;

class DateTimePicker extends \kartik\datetime\DateTimePicker
{
    /**
     * @inheritdoc
     */
    public $layout = '{input}{picker}{remove}';

    /**
     * @inheritdoc
     */
    public $convertFormat = true;

    /**
     * @inheritdoc
     */
    public $_langFile = null;

    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->pluginOptions['language'] = Yii::$app->language;

        parent::init();
    }

    /**
     * @inheritdoc
     */
    protected function setLanguage($prefix, $assetPath = null, $filePath = null, $suffix = '.js')
    {
        // Do not register lang file
    }

    /**
     * @inheritdoc
     */
    public function registerAssets()
    {
        $js = <<<JS
$.fn.datetimepicker.dates['ru'] = {
    days: ["Воскресенье", "Понедельник", "Вторник", "Среда", "Четверг", "Пятница", "Суббота", "Воскресенье"],
    daysShort: ["Вск", "Пнд", "Втр", "Срд", "Чтв", "Птн", "Суб", "Вск"],
    daysMin: ["Вс", "Пн", "Вт", "Ср", "Чт", "Пт", "Сб", "Вс"],
    months: ["Январь", "Февраль", "Март", "Апрель", "Май", "Июнь", "Июль", "Август", "Сентябрь", "Октябрь", "Ноябрь", "Декабрь"],
    monthsShort: ["янв", "фев", "мар", "апр", "мая", "июн", "июл", "авг", "сен", "окт", "ноя", "дек"],
    today: "Сегодня",
    suffix: [],
    meridiem: [],
    weekStart: 1
};
JS;
        $this->getView()->registerJs($js, View::POS_READY);

        parent::registerAssets();
    }
}
