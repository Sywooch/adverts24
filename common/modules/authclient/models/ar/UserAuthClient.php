<?php

namespace common\modules\authclient\models\ar;

use common\modules\users\models\ar\User;
use Yii;

/**
 * This is the model class for table "auth_client_user".
 *
 * @property string $client_user_id
 * @property string $client_name
 * @property integer $user_id
 * @property string $state
 * @property string $access_token
 * @property string $client_status
 * @property string $avatar_url
 * @property string $first_name
 * @property string $last_name
 * @property string $profile
 * @property string $profile_url
 *
 * @property User $user
 */
class UserAuthClient extends \common\modules\core\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_auth_client';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'client_user_id', 'client_name'], 'required'],
            [['user_id', 'client_user_id'], 'integer'],
            [['client_name'], 'string'],
            [['first_name', 'last_name', 'state', 'client_status'], 'string', 'max' => 32],
            [['access_token'], 'string', 'max' => 512],
            [['avatar_url'], 'string', 'max' => 255],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'client_user_id' => Yii::t('app', 'Client User ID'),
            'client_name' => Yii::t('app', 'Client Name'),
            'user_id' => Yii::t('app', 'User ID'),
            'state' => Yii::t('app', 'Статус'),
            'access_token' => Yii::t('app', 'Токен'),
            'client_status' => Yii::t('app', 'Статус'),
            'avatar_url' => Yii::t('app', 'Аватар'),
            'profile' => Yii::t('app', 'Профиль'),
            'profile_url' => Yii::t('app', 'Ссылка на профиль'),
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
     * @return \common\modules\authclient\models\aq\AuthClientUserQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\modules\authclient\models\aq\AuthClientUserQuery(get_called_class());
    }

    /**
     * @param OAuth2|ClientInterface $authClient
     */
    public function setClientAttributes($authClient)
    {
        if ($this->isNewRecord) {
            $this->setAttributes([
                'client_user_id' => $authClient->userId,
                'client_name' => $authClient->name,
            ]);
        }
        $this->setAttributes([
            'first_name' => $authClient->firstName,
            'last_name' => $authClient->lastName,
            'avatar_url' => $authClient->avatarUrl,
            'profile_url' => $authClient->profileUrl,
            'access_token' => $authClient->accessToken->token
        ]);
    }
}
