<?php

namespace app\modules\api\modules\v1\resources;

use app\models\FormSubmissionFile;
use yii\helpers\Url;

class SubmissionFileResource extends FormSubmissionFile
{

    public function fields()
    {
        return [
            'field',
            'label',
            'name' => 'fileName',
            'size',
            'link'
        ];
    }

}