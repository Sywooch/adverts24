<?php

namespace common\modules\users\models\aq;

/**
 * This is the ActiveQuery class for [[\common\modules\users\models\ar\AuthFail]].
 *
 * @see \common\modules\users\models\ar\AuthFail
 */
class AuthFailQuery extends \common\modules\core\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return \common\modules\users\models\ar\AuthFail[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \common\modules\users\models\ar\AuthFail|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
