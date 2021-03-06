<?php

namespace common\modules\adverts\helpers;

use common\modules\adverts\models\ar\Advert;
use Yii;

class AdvertHelper
{
    /**
     * @param Advert $model
     * @return string
     */
    public static function getPostContent($model)
    {
        $content = '';
        $content .= "Категория: {$model->category->name}\n";
        if ($model->geography) {
            $content .= "Место: {$model->geography->title}\n";
        }
        $content .= "Цена: " . Yii::$app->formatter->asCurrencyRange(
            $model->min_price, $model->max_price, $model->currency->code
        ) . " \n\n";
        $content .= "{$model->content}\n\n";
        $content .= "Ссылка: {$model->fullUrl}";
        return $content;
    }
}