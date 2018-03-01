<?php

namespace common\modules\adverts\models\ar;

use common\modules\adverts\AdvertsModule;
use common\modules\adverts\models\aq\AdvertQuery;
use common\modules\core\behaviors\ar\DateTimeBehavior;
use common\modules\core\models\ar\Comment;
use common\modules\core\models\ar\File;
use common\modules\core\models\ar\Like;
use common\modules\currency\models\ar\Currency;
use common\modules\core\models\ar\Look;
use common\modules\core\validators\FilesLimitValidator;
use common\modules\geography\models\ar\Geography;
use common\modules\users\models\ar\User;
use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

/**
 * This is the model class for table "user".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $category_id
 * @property integer $geography_id
 * @property integer $currency_id
 * @property string $content
 * @property string $status
 * @property string $type
 * @property string $is_foreign
 * @property string $published
 * @property string $expiry_at
 * @property string $created_at
 * @property string $updated_at
 * @property float $min_price
 * @property float $max_price
 * @property string $cityName
 * @property integer $commentsCount
 * @property string $url
 * @property string $fullUrl
 * @property Comment[] $comments
 * @property Currency $currency
 * @property integer $dislikesCount
 * @property integer $likesCount
 * @property integer $looksCount
 * @property Geography $geography
 * @property AdvertCategory $category
 */
class Advert extends \common\modules\core\db\ActiveRecord
{
    const SCENARIO_CREATE_FROM_SERVICE = 'createFromService';

    /**
     * Advert statuses constants.
     */
    const STATUS_ACTIVE = 'active';
    const STATUS_BLOCKED = 'blocked';
    const STATUS_NEW = 'new';

    const TYPE_DEMAND = 'demand';
    const TYPE_OFFER = 'offer';

    /**
     * @var boolean whether advert bookmarked by current user
     */
    public $bookmarked;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'advert';
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
            [['content', 'user_id', 'category_id', 'geography_id', 'expiry_at'], 'required'],
            ['type', 'required', 'message' => 'Выберите тип'],
            ['currency_id', 'validateCurrency', 'skipOnEmpty' => false],
            [['user_id'], 'exist', 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id'],'skipOnError' => true],
            [['category_id'], 'exist', 'targetClass' => AdvertCategory::className(), 'targetAttribute' => ['category_id' => 'id'],'skipOnError' => true],
            [['geography_id'], 'exist', 'targetClass' => Geography::className(), 'targetAttribute' => ['geography_id' => 'service_id'],'skipOnError' => true],
            [['currency_id'], 'exist', 'targetClass' => Currency::className(), 'targetAttribute' => ['currency_id' => 'id'],'skipOnError' => true],
            [['expiry_at'], 'datetime', 'format' => 'php:Y-m-d H:i:s'],
            [['expiry_at'], 'default', 'value' => date('Y-m-d H:i:s', time() + 3600 * 24 * 30)],
            [['currency_id'], 'default', 'value' => function() {
                $currency = Currency::findOne(['code' => Currency::RUB]);
                return $currency->id;
            }],
            //[['min_price', 'max_price'], 'integer', 'integerOnly' => false],
            [['min_price', 'max_price'], 'validatePrice'],
            [['status'], 'validateStatus'],
            ['type', 'in', 'range' => array_keys(self::getAttributeLabels('type'))],
            [['likesCount', 'dislikesCount', 'looksCount'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Id',
            'user_id' => 'Создал',
            'category_id' => Yii::t('app', 'Категория'),
            'geography_id' => Yii::t('app', 'Месторасположение'),
            'content' => Yii::t('app', 'Содержание'),
            'created_at' => Yii::t('app', 'Дата создания'),
            'currency_id' => Yii::t('app', 'Валюта'),
            'price' => Yii::t('app', 'Цена'),
            'min_price' => Yii::t('app', 'Минимальная цена'),
            'max_price' => Yii::t('app', 'Максимальная цена'),
            'published' => Yii::t('app', 'Is Published'),
            'status' => Yii::t('app', 'Статус'),
            'expiry_at' => Yii::t('app', 'Срок действия'),
            'type' => Yii::t('app', 'Тип'),
            'updated_at' => Yii::t('app', 'Обновлено'),
        ];
    }

    /**
     * @inheritdoc
     */
    public static function attributeLabelsConfig()
    {
        return [
            'status' => [
                self::STATUS_NEW => 'Новый',
                self::STATUS_ACTIVE => 'Активно',
                self::STATUS_BLOCKED => 'Заблокировано',
            ],
            'type' => [
                self::TYPE_DEMAND => 'Спрос',
                self::TYPE_OFFER => 'Предложение',
            ],
        ];
    }

    /**
     * @inheritdoc
     * @return AdvertQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new AdvertQuery(get_called_class());
    }

    /**
     * @return \yii\db\ActiveQuery
     *
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
        return $this->hasOne(Geography::className(), ['service_id' => 'geography_id'])->onCondition([
            Geography::tableName() . '.type' => Geography::TYPE_CITY
        ]);
    }

    /**
     * @return string
     */
    public function getCityName()
    {
        return isset($this->geography) ? $this->geography->title : null;
    }

    /**
     * @param bool $scheme
     * @return null|string
     */
    public function getUrl($scheme = false)
    {
        return !$this->isNewRecord ? Url::to(['/adverts/advert/view', 'id' => $this->id], $scheme) : null;
    }

    /**
     * @return null|string
     */
    public function getFullUrl()
    {
        return $this->getUrl(true);
    }

    /**
     * @param string $attribute
     */
    public function validatePrice($attribute)
    {
        if ($attribute == 'max_price') {
            return;
        }

        if ($this->min_price && $this->max_price && $this->min_price > $this->max_price) {
            $this->addError($attribute, AdvertsModule::t('Минимальная цена должна быть меньше максимальной'));
        }
    }

    /**
     * @param string $attribute
     */
    public function validateCurrency($attribute)
    {
        if (($this->min_price || $this->max_price) && !$this->currency_id) {
            $this->addError($attribute, AdvertsModule::t('Выберите валюту'));
        }
    }

    /**
     * @param string $attribute
     */
    public function validateStatus($attribute)
    {
        if ($this->isAttributeChanged('status') && !Yii::$app->request->isConsoleRequest && !Yii::$app->user->isSuperadmin) {
            $this->addError($attribute, AdvertsModule::t('Вы не можете изменить статус'));
        }
    }

    /**
     * Copy attributes from templet.
     * @param array $attributes
     */
    public function copyFromTemplet($attributes)
    {
        ArrayHelper::remove($attributes, 'id');
        $this->setAttributes($attributes);
    }
}