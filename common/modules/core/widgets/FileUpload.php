<?php

namespace common\modules\core\widgets;

use common\modules\core\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\helpers\Url;
use dosamigos\fileupload\FileUploadAsset;
use dosamigos\fileupload\FileUploadPlusAsset;

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

        $options = Json::encode($this->clientOptions);
        $id = $this->options['id'];

        $js[] = ";jQuery('#$id').fileupload($options);";
        if (!empty($this->clientEvents)) {
            foreach ($this->clientEvents as $event => $handler) {
                $js[] = "jQuery('#$id').on('$event', $handler);";
            }
        }

        //$js[0] = preg_replace('/,"acceptFileTypes":"(.+)i","/', ',"acceptFileTypes":$1i,"', $js[0]);

        $view->registerJs(implode("\n", $js));
    }
}
