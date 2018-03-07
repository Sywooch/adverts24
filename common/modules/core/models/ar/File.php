<?php

namespace common\modules\core\models\ar;

use common\modules\adverts\models\ar\Advert;
use common\modules\adverts\models\ar\AdvertTemplet;
use common\modules\core\db\ActiveRecord;
use Yii;
use yii\web\UploadedFile;
use common\modules\core\validators\FilesLimitValidator;

/**
 * This is the model class for table "file".
 *
 * @property integer $id
 * @property integer $owner_id
 * @property string $owner_model_name
 * @property string $file_name
 * @property string $origin_file_name
 * @property string $deleted_at
 * @property string $vk_server
 * @property string $vk_photo
 * @property string $vk_hashs
 *
 * @property string $fullName
 * @property string $path
 * @property string $url
 */
class File extends \common\modules\core\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'file';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['owner_id'], 'integer'],
            [['owner_model_name', 'file_name', 'origin_file_name'], 'required'],
            [['deleted_at'], 'safe'],
            [['owner_model_name'], 'string', 'max' => 32],
            [['file_name', 'origin_file_name', 'vk_server', 'vk_photo', 'vk_hash'], 'string', 'max' => 128],
            //['owner_id', 'validateFilesLimit'],
            //['owner_id', 'validateFilesTypes'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'owner_id' => Yii::t('app', 'Owner ID'),
            'owner_model_name' => Yii::t('app', 'Owner Model Name'),
            'file_name' => Yii::t('app', 'File Name'),
            'origin_file_name' => Yii::t('app', 'Origin File Name'),
            'deleted_at' => Yii::t('app', 'Deleted At'),
            'vk_server' => Yii::t('app', 'VK сервер'),
            'vk_photo' => Yii::t('app', 'VK фото'),
            'vk_hash' => Yii::t('app', 'VK хеш'),
        ];
    }

    /**
     * @inheritdoc
     * @return \common\modules\core\models\aq\FileQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\modules\core\models\aq\FileQuery(get_called_class());
    }

    /**
     * @inheritdoc
     */
    public static function attributeLabelsConfig()
    {
        return [
            'owner_model_name' => [
                Advert::shortClassName() => 'Объявление',
                AdvertTemplet::shortClassName() => 'Шаблон объявления',
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public function afterDelete()
    {
        parent::afterDelete();

        if (is_file($this->fullName)) {
            unlink($this->fullName);
        }
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return "/uploaded/{$this->file_name}";
    }

    /**
     * @return string
     */
    public function getPath()
    {
        return Yii::getAlias('@frontend/web/uploaded');
    }

    /**
     * @return string
     */
    public function getFullName()
    {
        return Yii::getAlias("@frontend/web/uploaded/{$this->file_name}");
    }

    /**
     * Uploads file and attaches it to the model.
     * @param ActiveRecord $owner
     * @param string $attribute
     * @return File
     */
    public static function upload($owner, $attribute = 'files')
    {
        $uploadedFile = UploadedFile::getInstance($owner, $attribute);

        $owner->uploadedFiles = [$uploadedFile];
        $owner->validate('uploadedFiles');

        $file = new self([
            'owner_id' => $owner->id,
            'owner_model_name' => $owner::shortClassName(),
            'file_name' => uniqid(time(), true) . '.' . $uploadedFile->extension,
            'origin_file_name' => $uploadedFile->name
        ]);

        if ($owner->hasErrors()) {
            $file->addError('owner_id', $owner->getFirstError('uploadedFiles'));
        } else {
            $file->save() && $uploadedFile->saveAs("{$file->path}/{$file->file_name}");
        }

        return $file;
    }
}
