<?php

namespace common\modules\adverts\models\aq;

use common\modules\adverts\models\ar\Advert;
use common\modules\core\db\ActiveQuery;
use common\modules\core\db\ActiveRecord;
use common\modules\core\models\ar\Bookmark;
use Yii;
use yii\db\Expression;

/**
 * This is the ActiveQuery class for [[Advert]].
 *
 * @see Advert
 */
class AdvertQuery extends ActiveQuery
{
    /**
     * @return $this
     */
    public function active()
    {
        return $this->andWhere(["{$this->tableName}.status" => Advert::STATUS_ACTIVE]);
    }

    /**
     * @inheritdoc
     * @return Advert[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Advert|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

    /**
     * @return $this
     */
    public function published()
    {
        return $this->where([
            self::getPrimaryTableName() . '.user_id' => Yii::$app->user->id
        ]);
    }
}
