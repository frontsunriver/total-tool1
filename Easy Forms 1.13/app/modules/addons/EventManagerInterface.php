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

namespace app\modules\addons;

/**
 * Interface that must be implemented by each sub-module.
 *
 * This interface defines basic methods to attaches events
 * to all app through Addons Module.
 */
interface EventManagerInterface
{

    /**
     * Global Event Handlers
     *
     * Structure: [
     *      $eventName => $eventHandler
     * ]
     *
     * @return void|array events
     */
    public function attachGlobalEvents();

    /**
     * Class-Level Event Handlers
     *
     * Structure: [
     *      $eventSenderClassName => [
     *          $eventName => [
     *              [$handlerClassName, $handlerMethodName]
     *          ]
     *      ]
     * ]
     *
     * @return void|array events
     */
    public function attachClassEvents();
}
