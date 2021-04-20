/**
 * Copyright (C) Baluart.COM - All Rights Reserved
 *
 * @since 1.7.3
 * @author Baluart E.I.R.L.
 * @copyright Copyright (c) 2015 - 2021 Baluart E.I.R.L.
 * @license http://codecanyon.net/licenses/faq Envato marketplace licenses
 * @link https://easyforms.dev/ Easy Forms
 */
$( document ).ready(function() {

    /**
     * Redirect after success submit
     * Submit form automatically
     *
     * The form will be automatically redirected
     * after 5 seconds, when it was successfully submitted
     *
     * Useful for showing a confirmation message for some moments
     * and then proceed with the redirection
     */

    formEl.on('success', function(event){
        setTimeout(function () {
            Utils.postMessage({
                url: "https://easyforms.dev"
            });
        }, 5000)
    });
});