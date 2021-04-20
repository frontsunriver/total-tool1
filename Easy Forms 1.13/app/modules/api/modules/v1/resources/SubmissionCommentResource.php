<?php

namespace app\modules\api\modules\v1\resources;

use app\models\FormSubmissionComment;

class SubmissionCommentResource extends FormSubmissionComment
{

    /**
     * @inheritdoc
     */
    public function fields()
    {
        return ['content', 'created_by', 'created_at'];
    }

}