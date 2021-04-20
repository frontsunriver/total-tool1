<?php

namespace app\modules\api\modules\v1\resources;

use app\models\User;
use yii\helpers\Url;
use yii\web\Link;
use yii\web\Linkable;

class UserResource extends User implements Linkable
{

    public function fields()
    {
        return [
            'id',
            'username',
            'email',
            'last_login_ip',
            'registration_ip',
            'blocked_at',
            'confirmed_at',
            'last_login_at',
            'created_at',
            'updated_at',
        ];
    }

    public function extraFields()
    {
        return [
            'profile',
            'forms',
        ];
    }

    public function getLinks()
    {
        return [
            Link::REL_SELF => Url::to(['user/view', 'id' => $this->id], true),
        ];
    }
}