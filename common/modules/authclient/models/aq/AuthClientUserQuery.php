<?php

namespace common\modules\authclient\models\aq;

/**
 * This is the ActiveQuery class for [[\common\modules\authclient\models\ar\AuthClientUser]].
 *
 * @see \common\modules\authclient\models\ar\UserAuthClient
 */
class AuthClientUserQuery extends \common\modules\core\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return \common\modules\authclient\models\ar\UserAuthClient[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \common\modules\authclient\models\ar\UserAuthClient|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
