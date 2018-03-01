<?php

namespace common\modules\adverts\widgets;

use common\modules\core\db\ActiveRecord;
use common\modules\core\widgets\WidgetPageSize;
use common\modules\core\widgets\Wps;
use common\modules\currency\models\ar\Currency;
use common\modules\currency\models\search\CurrencySearch;
use common\modules\currency\widgets\UiCurrency;
use yii\helpers\ArrayHelper;
use common\modules\adverts\widgets\AdvertListWidgetPageSize;
use yii\helpers\Html;
use yii\widgets\LinkSorter;
use yii\web\Request;
use Yii;

class AdvertList extends \yii\widgets\ListView
{
    /**
     * @var ActiveRecord see GridView::$filterModel for more details
     */
    public $filterModel;

    /**
     * @var bool
     */
    public $renderFilter = true;

    /**
     * @var string
     */
    public $itemView = '@common/modules/adverts/views/advert/advert/index';

    /**
     * @inheritdoc
     */
    public $summaryOptions = [
        'tag' => 'span',
        'class' => 'summary',
    ];

    /**
     * @inheritdoc
     */
    public $pager = [
        'disableCurrentPageButton' => false
    ];

    /**
     * @inheritdoc
     */
    public $showOnEmpty = false;

    /**
     * @inheritdoc
     */
    public function run()
    {
        if ($this->showOnEmpty || $this->dataProvider->getCount() > 0) {
            $this->layout = $this->render('advert-list/index', [
                'widget' => $this,
                'tag' => ArrayHelper::remove($this->options, 'tag', 'div')
            ]);
            $content = preg_replace_callback('/{\\w+}/', function ($matches) {
                $content = $this->renderSection($matches[0]);
                return $content === false ? $matches[0] : $content;
            }, $this->layout);
        } else {
            $content = $this->renderEmpty();
        }

        echo $content;
    }

    /**
     * @inheritdoc
     */
    public function renderSection($name)
    {
        switch ($name) {
            case '{widgetPageSize}':
                return $this->renderWidgetPageSize();
            case '{uiCurrency}':
                return $this->renderUiCurrency();
            default:
                return parent::renderSection($name);
        }
    }

    /**
     * @return string
     */
    public function renderWidgetPageSize()
    {
        return WidgetPageSize::widget([
            'pjaxId' => 'adverts-list-pjax',
            'widgetId' => 'adverts-list',
            'independentChanging' => true,
        ]);

    }
    /**
     * @return string
     */
    public function renderUiCurrency()
    {
        return UiCurrency::widget([]);
    }

    /**
     * @inheritdoc
     */
    public function renderEmpty()
    {
        return $this->render('advert-list/empty', [
            'widget' => $this,
            'tag' => ArrayHelper::remove($this->options, 'tag', 'div'),
            'text' => $this->emptyText
        ]);
    }
}