<?php

namespace app\modules\api\modules\v1\resources;

use app\modules\addons\modules\webhooks\models\Webhook;

class WebhookResource extends Webhook
{

    public function fields()
    {
        return [
            'id',
            'form_id',
            'url',
            'handshake_key',
            'status',
            'json',
            'alias',
            'created_by',
            'updated_by',
            'created_at',
            'updated_at',
        ];
    }

}