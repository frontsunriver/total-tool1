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

namespace app\modules\addons\modules\google_analytics;

use Yii;
use app\modules\addons\EventManagerInterface;
use app\modules\addons\modules\google_analytics\models\Account;
use app\models\Form;

class Module extends \yii\base\Module implements EventManagerInterface
{
    public $id = "google_analytics";
    public $defaultRoute = 'admin/index';
    public $controllerLayout = '@app/views/layouts/main';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        // Set up i8n of this add-on
        if (empty(Yii::$app->i18n->translations['google_analytics'])) {
            Yii::$app->i18n->translations['google_analytics'] = [
                'class' => 'yii\i18n\PhpMessageSource',
                'sourceLanguage' => 'en-US',
                'basePath' => '@addons/google_analytics/messages',
                //'forceTranslation' => true,
            ];
        }
    }

    /**
     * @inheritdoc
     */
    public function attachGlobalEvents()
    {
        return [];
    }

    /**
     * @inheritdoc
     */
    public function attachClassEvents()
    {
        return [
            'yii\base\View' => [
                'afterRender' => [
                    ['app\modules\addons\modules\google_analytics\Module', 'addTrackingCode']
                ],
            ],
            'app\models\Form' => [
                'beforeDelete' => [
                    ['app\modules\addons\modules\google_analytics\Module', 'onFormDeleted']
                ]
            ],
        ];
    }

    /**
     * Event Handler
     * Before a form model is deleted
     *
     * @param $event
     */
    public static function onFormDeleted($event)
    {
        if (isset($event) && isset($event->sender) && $event->sender instanceof Form && isset($event->sender->id)) {
            Account::deleteAll(['form_id' => $event->sender->id]);
        }
    }

    /**
     * Event Handler
     * After a view is rendered
     *
     * @param $event
     */
    public static function addTrackingCode($event)
    {

        if (isset($event, $event->sender, $event->sender->context) &&
            isset($event->sender->context->module, $event->sender->context->module->requestedRoute) &&
            $event->sender->context->module->requestedRoute === "app/embed" ) {

            // Add tracking code only to app/embed view

            $formModel = $event->sender->context->getFormModel();
            $accounts = Account::findAll(['form_id' => $formModel->id, 'status' => 1]);

            if (count($accounts) > 0) {
                $gaCode = <<<EOT

<!-- Google Analytics -->
<script>
(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
})(window,document,'script','//www.google-analytics.com/analytics.js','ga');

EOT;
                foreach ($accounts as $account) {
                    $gaCode .= <<<EOT
ga('create', '$account->tracking_id', 'auto', {
    'name': 'tracker$account->id',
    'cookieDomain': '$account->tracking_domain',
    'legacyCookieDomain': '$account->tracking_domain'
});
EOT;
                    if ($account->anonymize_ip) {
                        $gaCode .= <<<EOT
ga('tracker$account->id.set', 'anonymizeIp', true);
EOT;
                    }
                    $gaCode .= <<<EOT

jQuery(document).ready(function(){

    $(options.name).on('fill', function(event){
        // Track fill
        ga('tracker$account->id.send', 'event', 'Form #$account->form_id', 'Fill', 'Start', null);
    });
    $(options.name).on('error', function(event){
        // Track submits with validation error
        ga('tracker$account->id.send', 'event', 'Form #$account->form_id', 'Submit', 'Error', null);
    });
    $(options.name).on('success', function(event){
        // Track submits with success
        ga('tracker$account->id.send', 'event', 'Form #$account->form_id', 'Submit', 'Success', null);
    });

});
EOT;
                }

                $gaCode .= <<<EOT

</script>
<!-- End Google Analytics -->

</body>
EOT;

                $content = $event->output;
                $event->output =  str_replace("</body>", $gaCode, $content);
            }
        }
    }
}
