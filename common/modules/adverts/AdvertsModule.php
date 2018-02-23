<?php

namespace common\modules\adverts;

use Yii;

/**
 * Class AdvertsModule
 * @package common\modules\adverts
 */
class AdvertsModule extends \common\modules\core\base\Module
{
    /**
     * @inheritdoc
     */
    public static function t($message, $category = null, $params = [], $language = null)
    {
        if (!isset(Yii::$app->i18n->translations['app/modules/users/*'])) {
            Yii::$app->i18n->translations['app/modules/users/*'] = [
                'class'          => 'yii\i18n\PhpMessageSource',
                'basePath'       => '@app/modules/users/messages',
                'fileMap'        => [
                    'app/modules/users/main' => 'main.php',
                ],
            ];
        }

        return Yii::t('app/modules/users/'.($category ? : 'main'), $message, $params, $language);
    }
}
