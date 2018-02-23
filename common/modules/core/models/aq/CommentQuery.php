<?php

namespace common\modules\core\models\aq;

/**
 * This is the ActiveQuery class for [[\common\modules\core\models\ar\Comment]].
 *
 * @see \common\modules\core\models\ar\Comment
 */
class CommentQuery extends \common\modules\core\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return \common\modules\core\models\ar\Comment[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \common\modules\core\models\ar\Comment|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
