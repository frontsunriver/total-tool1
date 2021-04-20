/**
 * Copyright (C) Baluart.COM - All Rights Reserved
 *
 * @since 1.6.4
 * @author Baluart E.I.R.L.
 * @copyright Copyright (c) 2015 - 2021 Baluart E.I.R.L.
 * @license http://codecanyon.net/licenses/faq Envato marketplace licenses
 * @link https://easyforms.dev/ Easy Forms
 */
$( document ).ready(function() {

    /**
     * Auto Submit
     * Submit form automatically
     *
     * The form will be automatically sent
     * when the user select a radio button
     * without press the "submit" button
     *
     * Useful for quizzes with radio buttons
     */

    $('input[type=radio]').on('click', function() {
        formEl.submit()
    });
});
