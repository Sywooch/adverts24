<?php

namespace common\modules\core\widgets;

use common\modules\core\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\helpers\Url;
use dosamigos\fileupload\FileUploadAsset;
use dosamigos\fileupload\FileUploadPlusAsset;

/**
 * @see: https://github.com/blueimp/jQuery-File-Upload/wiki/Options#processing-callback-options
 */
class FileUpload extends \dosamigos\fileupload\FileUpload
{
    /**
     * @inheritdoc
     */
    public $clientOptions = [];

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        if (empty($this->clientOptions['messages'])) {
            $this->clientOptions['messages'] = [
                'maxNumberOfFiles' => 'Загружено максимальное количество файлов',
                'acceptFileTypes' => 'Нельзя загрузить файл такого типа',
                'maxFileSize' => 'Слишком большой размер файла',
                'minFileSize' => 'Слишком маленький размер файла'
            ];
        }
    }

    /**
     * @inheritdoc
     */
    public function run()
    {
        $input = $this->hasModel()
            ? Html::activeFileInput($this->model, $this->attribute, ArrayHelper::merge($this->options, ['value' => '']))
            : Html::fileInput($this->name, $this->value, $this->options);

        echo $this->useDefaultButton
            ? $this->render('file-upload/upload-button', ['input' => $input])
            : $input;

        $this->registerClientScript();
    }

    /**
     * @inheritdoc
     */
    public function registerClientScript()
    {
        $view = $this->getView();

        if($this->plus) {
            FileUploadPlusAsset::register($view);
        } else {
            FileUploadAsset::register($view);
        }

        if (!empty($this->clientOptions['acceptFileTypes'])) {
            $acceptFileTypes = ArrayHelper::remove($this->clientOptions, 'acceptFileTypes');
        }

        $options = Json::encode($this->clientOptions, JSON_PRETTY_PRINT);
        $id = $this->options['id'];

        $js[] = "$('#$id').fileupload($options);";
        if (isset($acceptFileTypes)) {
            $js[] = "$('#$id').fileupload('option', 'acceptFileTypes', {$acceptFileTypes});";
        }
        if (!empty($this->clientEvents)) {
            foreach ($this->clientEvents as $event => $handler) {
                $js[] = "$('#$id').on('$event', $handler);";
            }
        }

        $view->registerJs(implode("\n", $js));
    }
}