<?php

namespace common\modules\authclient\components;

use common\modules\adverts\helpers\AdvertHelper;
use common\modules\adverts\models\ar\Advert;
use common\modules\authclient\clients\VKontakte;
use common\modules\core\models\ar\File;
use yii\base\Component;
use Yii;

class VkPublisher extends Component
{
    /**
     * @param Advert $model
     */
    public function publishAdvert($model)
    {
        $collection = Yii::$app->get('authClientCollection');
        if (!$collection->hasClient('vkontakte')) {
            throw new NotFoundHttpException("Unknown auth client 'vkontakte'");
        }

        /** @var VKontakte $client */
        $client = $collection->getClient('vkontakte');
        $client->setAccessToken([
            'token' => VKONTAKTE_ACCESS_TOKEN
        ]);

        $attachments = [];
        if ($model->files) {
            $data = $client->post('photos.getWallUploadServer', [
                'group_id' => VKONTAKTE_GROUP_ID_POSITIVE
            ]);
            $uploadUrl = $data['response']['upload_url'];

            foreach ($model->files as $file) {
                $uploadResponse = $this->uploadFiles(['photo' => new \CURLFile($file->fullName)], $uploadUrl);

                if (isset($uploadResponse->server) && isset($uploadResponse->hash) && isset($uploadResponse->photo)) {
                    $saveResponse = $client->post('photos.saveWallPhoto', [
                        'group_id' => VKONTAKTE_GROUP_ID_POSITIVE,
                        'server' => $uploadResponse->server,
                        'hash' => $uploadResponse->hash,
                        'photo' => $uploadResponse->photo,
                    ]);

                    if (isset($saveResponse['response']) && count($saveResponse['response'])) {
                        $attachments[] =  $saveResponse['response'][0]['id'];
                    }
                }
            }
        }

        $model->vk_guid = YII_DEBUG ? md5($model->id . time()) : $model->id;

        $response = $client->post('wall.post', [
            'owner_id' => VKONTAKTE_GROUP_ID_NEGATIVE,
            'message' => AdvertHelper::getPostContent($model),
            'from_group' => 1,
            'guid' => $model->vk_guid,
            'attachments' => implode(',', $attachments),
        ]);

        if (isset($response['response']) && isset($response['response']['post_id'])) {
            $model->vk_id = $response['response']['post_id'];
            $model->save();
        }
    }

    /**
     * @param array $data
     * @param string $uploadUrl
     * @return array
     */
    public function uploadFiles($data, $uploadUrl)
    {
        if ($curl = curl_init()) {
            curl_setopt($curl, CURLOPT_URL,$uploadUrl);
            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);

            $response = curl_exec($curl); // Получаем ответ
            $response = json_decode($response); // Разбираем JSON
            curl_close($curl);

            return $response;
        }
        return false;
    }
}