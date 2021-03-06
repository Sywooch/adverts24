<?php

namespace common\modules\adverts\models\ar;

use common\modules\core\behaviors\ar\DateTimeBehavior;
use common\modules\core\models\ar\File;
use common\modules\core\helpers\ArrayHelper;
use common\modules\geography\models\ar\Geography;
use common\modules\users\models\ar\User;

/**
 * This is the model class for table "advert_templet".
 *
 * @property integer $user_id
 * @property integer $category_id
 * @property integer $geography_id
 * @property string $content
 * @property string $expiry_at
 * @property string $updated_at
 * @property array uploadedFiles
 *
 * @property AdvertCategory $category
 * @property Geography $geography
 * @property User $user
 *
 */
class AdvertTemplet extends Advert
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'advert_templet';
    }

    /**
     * @inheritdoc
     */
    public function attributes()
    {
        return ArrayHelper::merge(parent::attributes(), [
            'created_at', 'uploadedFiles'
        ]);
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'datetime' => [
                'class' => DateTimeBehavior::className(),
                'datetimeAttributes' => ['expiry_at'],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['expiry_at'], 'datetime', 'format' => 'php:Y-m-d H:i:s'],
            [['expiry_at'], 'default', 'value' => date('Y-m-d H:i:s', time() + 3600 * 24 * 30)],
            [['content', 'category_id', 'currency_id', 'geography_id', 'content', 'status', 'expiry_at', 'min_price',
                'max_price', 'type', 'uploadedFile'
            ], 'safe'],
            ['uploadedFiles', 'file',
                'extensions' => ['gif', 'jpeg', 'jpg', 'png'],
                'maxSize' => self::MAX_FILE_SIZE,
                'maxFiles' => self::MAX_FILES,
                //'wrongExtension' =>
                //'tooBig' =>
                //'tooMany' =>
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function beforeValidate()
    {
        if (empty($this->type)) {
            $this->type = null;
        }

        return parent::beforeValidate();
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(AdvertCategory::className(), ['id' => 'category_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCurrency()
    {
        return $this->hasOne(Currency::className(), ['id' => 'currency_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGeography()
    {
        return $this->hasOne(Geography::className(), ['id' => 'geography_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOwner()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * Try to find a templet by user id or creates new one.
     * @param integer $userId
     * @return \common\modules\adverts\models\ar\AdvertTemplet
     */
    public static function getByUserId($userId)
    {
        if (!$model = self::find()->where(['user_id' => $userId])->one()) {
            $model = new self(['user_id' => $userId]);
            $model->save();
        }
        return  $model;
    }

    /**
     * Clears all attributes.
     * @return bool
     */
    public function clear()
    {
        foreach ($this->realAttributes() as $attribute) {
            if (in_array($attribute, ['id', 'user_id'])) {
                continue;
            }
            $this->$attribute = null;
        }
        return $this->save();
    }

    /**
     * Attach all templet files to advert model.
     * @param Advert $model
     */
    public function attachFilesToAdvert($model)
    {
        File::updateAll([
            'owner_id' => $model->id,
            'owner_model_name' => $model::shortClassName(),
        ],[
            'owner_id' => $this->id,
            'owner_model_name' => $this::shortClassName(),
        ]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFiles()
    {
        return $this->hasMany(File::className(), ['owner_id' => 'id'])->onCondition([
            'owner_model_name' => static::shortClassName()
        ]);
    }
}