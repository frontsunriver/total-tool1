<?php
/**
 * Copyright (C) Baluart.COM - All Rights Reserved
 *
 * @since 1.0
 * @author Baluart E.I.R.L.
 * @copyright Copyright (c) 2015 - 2021 Baluart E.I.R.L.
 * @license http://codecanyon.net/licenses/faq Envato marketplace licenses
 * @link https://easyforms.dev/ Easy Forms
 */

namespace app\components\analytics\collector;

use Yii;
use yii\base\Component;

/**
 * Class Mapper
 * @package app\components\analytics\collector
 */
class Session extends Component
{

    /**
     * @var Event
     */
    private $hit;
    /**
     * @var array
     */
    public $info;

    /**
     * Initializes Session.
     */
    public function init()
    {
        parent::init();

        $this->info = array();

    }

    /**
     * @param Event $hit
     */
    public function setHit(Event $hit)
    {
        $this->hit = $hit;
    }

    /**
     * Save session information in the DB
     *
     * @return bool
     */
    public function save()
    {

        if ($this->shouldBeExcluded()) {
            Yii::info(Yii::t("app", "Session excluded."));
            return false;
        }

        return true;
    }

    /**
     * Detect if this session should be excluded.
     *
     * @return bool
     */
    protected function shouldBeExcluded()
    {
        $excluded = false;

        if ($this->hit->isBot()) {
            $excluded = true;
            Yii::info(Yii::t("app", "SearchBot detected."));
        } elseif (!$this->hit->shouldBeRecorded()) {
            $excluded = true;
            Yii::info(Yii::t("app", "The parameter 'rec' was not found in the request."));
        } elseif ($this->hit->hasIgnoreCookie()) {
            $excluded = true;
            Yii::info(Yii::t("app", "The ignore cookie was found."));
        } elseif ($this->hit->hasPrefetchRequest()) {
            $excluded = true;
            Yii::info(Yii::t("app", "Prefetch request detected."));
        } elseif ($this->hit->hasReferrerSpam()) {
            $excluded = true;
            Yii::info(Yii::t("app", "Referrer URL is a known spam."));
        } elseif ($this->wasExcludedByIpAddress()) {
            $excluded = true;
            Yii::info("app", "The ip is in the exluded list for this form.");
        } elseif ($this->wasExcludedByUserAgent()) {
            $excluded = true;
            Yii::info(Yii::t("app", "The user agent is in the excluded list for this form."));
        }

        return $excluded;
    }

    /**
     * Checks if visitor ip is in the excluded list
     *
     * @internal param string $this->hit->getIp() The ip address.
     * @return bool
     */
    protected function wasExcludedByIpAddress()
    {
        // Excluded list in database (by form id)
        return false;
    }

    /**
     * Returns true if specified user agent should be excluded from the current site or not.
     *
     * Visits whose user agent string contains one of the excluded_user_agents strings from the
     * site being tracked (or one of the global strings) will be excluded.
     *
     * @internal param string $this->hit->getUserAgent() The user agent string.
     * @return bool
     */
    protected function wasExcludedByUserAgent()
    {
        // Excluded list in database (by form id)
        return false;
    }
}
