<?php

namespace common\modules\users\models\aq;

use common\modules\users\models\ar\User;

/**
 * This is the ActiveQuery class for [[\common\modules\users\models\ar\User]].
 *
 * @see \common\modules\users\models\ar\User
 */
class UserQuery extends \common\modules\core\db\ActiveQuery
{
    /**
     * @return $this
     */
    public function active()
    {
        return $this->andWhere(['status' => User::STATUS_ACTIVE]);
    }

    /**
     * @inheritdoc
     * @return \common\modules\users\models\ar\User[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \common\modules\users\models\ar\User|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
