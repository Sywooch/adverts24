<?php

namespace common\modules\adverts\components;

use common\modules\adverts\helpers\AdvertHelper;
use common\modules\adverts\models\ar\Advert;
use common\modules\authclient\clients\VKontakte;
use yii\base\Component;
use Yii;

class AdvertManager extends Component
{
    /**
     * @param Advert $model
     */
    public function publish($model)
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

        $client->post('wall.post', [
            'owner_id' => VKONTAKTE_GROUP_ID_NEGATIVE,
            'message' => AdvertHelper::getPostContent($model),
            'from_group' => 1,
            'guid' => $model->id,
        ]);
    }
}