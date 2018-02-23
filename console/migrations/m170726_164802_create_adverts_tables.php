<?php

use common\modules\adverts\models\ar\Advert;
use common\modules\core\db\Migration;
use common\modules\adverts\models\ar\AdvertCategory;

class m170726_164802_create_adverts_tables extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable(AdvertCategory::tableName(), [
            'id'                    => 'pk',
            'name'                  => 'VARCHAR(32) NOT NULL',
            'parent_id'             => 'INT(4) DEFAULT NULL'
        ], $this->tableOptions);
        $this->addForeignKey('fk_advert_category_refs_advert_category', 'advert_category', 'parent_id', 'advert_category', 'id', 'NO ACTION', 'NO ACTION');

        $statuses = array_keys(Advert::getAttributeLabels('status'));
        $this->createTable('advert', [
            'id'                    => 'pk',
            'user_id'               => 'INT(11) NOT NULL',
            'category_id'           => 'INT(3) NOT NULL',
            'geography_id'          => 'INT(11) NOT NULL',
            'currency_id'           => 'INT(11) NOT NULL',
            'content'               => 'TEXT  NOT NULL',
            'status'                => 'ENUM("'.implode('","', $statuses).'") DEFAULT "'.Advert::STATUS_NEW.'"',
            'is_foreign'            => 'TINYINT(1) DEFAULT 0',
            'published'             => 'TINYINT(1) DEFAULT 0',
            'expiry_at'             => 'TIMESTAMP NOT NULL',
            'created_at'            => 'TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP',
            'updated_at'            => 'TIMESTAMP NULL DEFAULT NULL',
            'min_price'             => 'DECIMAL(10,2)',
            'max_price'             => 'DECIMAL(10,2)',
        ], $this->tableOptions);
        $this->addForeignKey('fk_advert_refs_user', 'advert', 'user_id', 'user', 'id', 'NO ACTION', 'NO ACTION');
        $this->addForeignKey('fk_advert_refs_advert_category', 'advert', 'category_id', 'advert_category', 'id', 'NO ACTION', 'NO ACTION');
        $this->addForeignKey('fk_advert_refs_geography', 'advert', 'geography_id', 'geography', 'service_id', 'NO ACTION', 'NO ACTION');
        $this->addForeignKey('fk_advert_refs_currency', 'advert', 'currency_id', 'currency', 'id', 'NO ACTION', 'NO ACTION');
        //$this->createIndex();

        $this->createTable('advert_templet', [
            'id'                    => 'pk',
            'user_id'               => 'INT(11) NOT NULL',
            'category_id'           => 'INT(3)',
            'geography_id'          => 'INT(11)',
            'currency_id'           => 'INT(11)',
            'content'               => 'TEXT DEFAULT NULL',
            'expiry_at'             => 'TIMESTAMP NOT NULL',
            'updated_at'            => 'TIMESTAMP NULL DEFAULT NULL',
            'min_price'             => 'DECIMAL(10,2)',
            'max_price'             => 'DECIMAL(10,2)',
        ], $this->tableOptions);
        $this->addForeignKey('fk_advert_templet_refs_user', 'advert_templet', 'user_id', 'user', 'id', 'NO ACTION', 'NO ACTION');
        $this->addForeignKey('fk_advert_templet_refs_advert_category', 'advert_templet', 'category_id', 'advert_category', 'id', 'NO ACTION', 'NO ACTION');
        $this->addForeignKey('fk_advert_templet_refs_geography', 'advert_templet', 'geography_id', 'geography', 'service_id', 'NO ACTION', 'NO ACTION');
    }

    /**
    * @inheritdoc
    */
    public function down()
    {
        $this->dropTable('advert_templet');
        $this->dropTable('advert');
        $this->dropTable('advert_category');
    }
}
