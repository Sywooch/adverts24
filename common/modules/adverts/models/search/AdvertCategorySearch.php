<?php

namespace common\modules\adverts\models\search;

use common\modules\adverts\AdvertsModule;
use common\modules\adverts\models\ar\AdvertCategory;

use Yii;
use yii\data\ActiveDataProvider;

class AdvertCategorySearch extends AdvertCategory
{
    /**
     * @var integer
     */
    public $pageSize;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['pageSize', 'integer', 'integerOnly' => true, 'min' => 1],
        ];
    }

    /**
     * @return array customized attribute labels
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Id',
            'name' => AdvertsModule::t('Название'),
            'parent_id' => Yii::t('app', 'Роительская категория'),
        ];
    }

    /**
     * Creating model search query.
     * @return ActiveDataProvider|\yii\data\DataProviderInterface
     */
    public function search($params = [])
    {
        $query = self::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'attributes' => [
                    'asc' => ['name']
                ]
            ]
        ]);

        if ($params && !($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        return $dataProvider;
    }

    /**
     * @param $conditions
     * @param array $options
     * @return array
     */
    public static function getList($conditions = [], $options = [])
    {
        $query = self::find();

        if (isset($options['select'])) {
            $query->select($options['select']);
        }

        if (isset($options['order'])) {
            $query->orderBy($options['order']);
        } else {
            $query->orderBy('name');
        }

        return $query->andWhere($conditions)->asArray()->all();
    }
}