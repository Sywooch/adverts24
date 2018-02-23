<?php

namespace common\modules\core\models\aq;

/**
 * This is the ActiveQuery class for [[\common\modules\core\models\ar\Look]].
 *
 * @see \common\modules\core\models\ar\Look
 */
class LookQuery extends \common\modules\core\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return \common\modules\core\models\ar\Look[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \common\modules\core\models\ar\Look|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
