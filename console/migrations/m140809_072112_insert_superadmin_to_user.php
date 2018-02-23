<?php

use yii\db\Migration;
use common\modules\users\models\ar\Profile;
use common\modules\users\models\ar\User;

/**
 * Class m140809_072112_insert_superadmin_to_user
 */
class m140809_072112_insert_superadmin_to_user extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $user = new User([
            'email' => 'roman444uk@mail.ru',
            'passwordNotEncrypted' => 'september',
            'status' => User::STATUS_ACTIVE,
            'superadmin' => 1
        ]);
        $user->register();

        $profile = Profile::findOne($user->id);
        $profile->setAttributes([
            'first_name' => 'Роман',
            'last_name' => 'Гниденко',
            'skype' => 'roman444uk',
            'page_vk' => 'https://vk.com/id274216423',
            'phone_1' => '+380666887629'
        ]);
        $profile->save();
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        if ($user = User::findByUsername('superadmin')) {
            $user->delete();
        }
    }
}
