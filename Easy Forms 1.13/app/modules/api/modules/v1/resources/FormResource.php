<?php

namespace app\modules\api\modules\v1\resources;

use app\models\Form;

class FormResource extends Form
{

    public function fields()
    {
        return [
            'id',
            'name',
            'status',
            'language',
            'created_at',
            'updated_at',
        ];
    }

    public function extraFields()
    {
        return [];
    }
}