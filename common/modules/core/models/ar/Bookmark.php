<?php

namespace common\modules\core\models\ar;

use common\modules\users\models\ar\User;
use Yii;

/**
 * This is the model class for table "bookmark".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $owner_id
 * @property string $owner_model_name
 *
 * @property User $user
 */
class Bookmark extends \common\modules\core\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'bookmark';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'owner_id', 'owner_model_name'], 'required'],
            [['user_id', 'owner_id'], 'integer'],
            [['owner_model_name'], 'string'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'user_id' => Yii::t('app', 'User ID'),
            'owner_id' => Yii::t('app', 'Owner ID'),
            'owner_model_name' => Yii::t('app', 'Owner Model Name'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * @inheritdoc
     * @return BookmarkQuery the active query used by this AR class.
     */
    /*public static function find()
    {
        return new BookmarkQuery(get_called_class());
    }*/
}
