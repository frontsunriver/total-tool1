<?php
/**
 * Copyright (C) Baluart.COM - All Rights Reserved
 *
 * @since 1.6.7
 * @author Baluart E.I.R.L.
 * @copyright Copyright (c) 2015 - 2021 Baluart E.I.R.L.
 * @license http://codecanyon.net/licenses/faq Envato marketplace licenses
 * @link https://easyforms.dev/ Easy Forms
 */

namespace app\components\behaviors;

use app\helpers\SlugHelper;
use yii\behaviors\SluggableBehavior as BaseSluggableBehavior;

/**
 * Class SluggableBehavior
 * @package app\components\behaviors
 */
class SluggableBehavior extends BaseSluggableBehavior
{

    /**
     * This method is called by [[getValue]] to generate the slug.
     *
     * @param array $slugParts an array of strings that should be concatenated and converted to generate the slug value.
     * @return string the conversion result.
     */
    protected function generateSlug($slugParts)
    {
        $slug = SlugHelper::slug(implode('-', $slugParts));
        if (isset($this->owner->hashId) && $hashId = $this->owner->hashId) {
            $slug = $slug . '-' . $hashId;
        }
        return $slug;
    }

}