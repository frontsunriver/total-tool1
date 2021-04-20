<?php

/**
 * Copyright (C) Baluart.COM - All Rights Reserved
 *
 * @since 1.3.6
 * @author Baluart E.I.R.L.
 * @copyright Copyright (c) 2015 - 2021 Baluart E.I.R.L.
 * @license http://codecanyon.net/licenses/faq Envato marketplace licenses
 * @link https://easyforms.dev/ Easy Forms
 */

/**
 * Save Form Submission in a TXT file
 *
 * This simple script shows how to:
 * - Verify the handshake key, to avoid spam
 * - Save a form submission in a text file: http://yourdomain.com/custom/request.txt
 *
 * Also keep in mind, that the key of the $_POST array is the name attribute of the form field.
 * You can check this in Form Builder -> Code tab.
 */

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $my_handshake_key = 'my_handshake_key';

    if (isset($_POST['handshake_key']) && $_POST['handshake_key'] == $my_handshake_key) {
        $fp = file_put_contents('request.log', var_export($_REQUEST, true), FILE_APPEND);
    }
}
