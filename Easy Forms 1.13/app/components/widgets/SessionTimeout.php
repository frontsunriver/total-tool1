<?php
/**
 * Copyright (C) Baluart.COM - All Rights Reserved
 *
 * @since 1.7
 * @author Baluart E.I.R.L.
 * @copyright Copyright (c) 2015 - 2021 Baluart E.I.R.L.
 * @license http://codecanyon.net/licenses/faq Envato marketplace licenses
 * @link https://easyforms.dev/ Easy Forms
 */

namespace app\components\widgets;

use Yii;
use yii\web\View;
use yii\base\Widget;
use yii\helpers\Url;

class SessionTimeout extends Widget
{
    public $title;

    public $message;

    public $actionMessage;

    public $logoutButton;

    public $keepAliveButton;

    public $keepAliveUrl;

    public $keepAlive;

    public $keepAliveInterval;

    public $ajaxType;

    public $ajaxData;

    public $redirUrl;

    public $logoutUrl;

    public $warnAfter;

    public $redirAfter;

    public $ignoreUserActivity;

    public $countdownSmart;

    public $countdownMessage;

    public $countdownBar;

    public $jsFile;

    public function init()
    {
        parent::init();
        if ($this->title === null) {
            $this->title = Yii::t('app', 'Session Timeout');
        }
        if ($this->message === null) {
            $this->message = Yii::t('app', 'Your online session will expire in');
        }
        if ($this->actionMessage === null) {
            $this->actionMessage = Yii::t('app', 'Please click "{keepAliveButton}" to keep working or click "{logoutButton}" to end your session now.');
        }
        if ($this->logoutButton === null) {
            $this->logoutButton = Yii::t('app', 'Sign out');
        }
        if ($this->keepAliveButton === null) {
            $this->keepAliveButton = Yii::t('app', 'Stay signed in');
        }
        if ($this->keepAliveUrl === null) {
            $this->keepAliveUrl = Url::to(['ajax/keep-alive']);
        }
        if ($this->keepAlive === null) {
            $this->keepAlive = 'false';
        }
        if ($this->keepAliveInterval === null) {
            $this->keepAliveInterval = 5000;
        }
        if ($this->ajaxType === null) {
            $this->ajaxType = 'POST';
        }
        if ($this->ajaxData === null) {
            $this->ajaxData = '';
        }
        if ($this->redirUrl === null) {
            $this->redirUrl = '#';
        }
        if ($this->logoutUrl === null) {
            $this->logoutUrl = Url::to(['/user/logout']);
        }
        if ($this->warnAfter === null) {
            $this->warnAfter = 900000;
        }
        if ($this->redirAfter === null) {
            $this->redirAfter = 1200000;
        }
        if ($this->ignoreUserActivity === null) {
            $this->ignoreUserActivity = 'false';
        }
        if ($this->countdownSmart === null) {
            $this->countdownSmart = 'true';
        }
        if ($this->countdownMessage === null) {
            $this->countdownMessage = '{timer}';
        }
        if ($this->countdownBar === null) {
            $this->countdownBar = 'true';
        }
        if ($this->jsFile === null) {
            $this->jsFile = Url::to('@web/static_files/js/app.session.timeout.min.js');;
        }
    }

    public function run()
    {
        $this->view->registerJs("
window.onload = function(e){
    if (typeof $ === 'function') {
        $.getScript('{$this->jsFile}', function() {
            $.sessionTimeout({
                title: '{$this->title}',
                message: '{$this->message}',
                actionMessage: '{$this->actionMessage}',
                logoutButton: '{$this->logoutButton}',
                keepAliveButton: '{$this->keepAliveButton}',
                keepAliveUrl: '{$this->keepAliveUrl}',
                keepAlive: {$this->keepAlive},
                keepAliveInterval: {$this->keepAliveInterval},
                ajaxType: '{$this->ajaxType}',
                ajaxData: '{$this->ajaxData}',
                redirUrl: '{$this->redirUrl}',
                logoutUrl: '{$this->logoutUrl}',
                warnAfter: {$this->warnAfter},
                redirAfter: {$this->redirAfter},
                ignoreUserActivity: {$this->ignoreUserActivity},
                countdownSmart: {$this->countdownSmart},
                countdownMessage: '{$this->countdownMessage}',
                countdownBar: {$this->countdownBar}
            });
        });
    }
}
", View::POS_END);
        return '';
    }
}