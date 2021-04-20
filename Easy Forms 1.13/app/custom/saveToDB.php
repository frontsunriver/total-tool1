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
 * Save Form Submission in a MySql DB
 * Ready to use with a Form based on the Mailing List template
 *
 * This simple script shows how to:
 * - Verify the handshake key, to avoid spam
 * - Save a form submission in a mysql database using PDO
 *
 * Steps:
 * 1. Create a database: test
 *   CREATE DATABASE 'test';
 * 2. Create a database table: subscribers, with 4 fields: id, name, email and ip_address
 *   CREATE TABLE `test`.`subscribers` (
 *      `id` INT(11) NOT NULL AUTO_INCREMENT ,
 *      `name` VARCHAR(255) NOT NULL ,
 *      `email` VARCHAR(255) NOT NULL ,
 *      `ip_address` VARCHAR(255) NOT NULL ,
 *   PRIMARY KEY (`id`)) ENGINE = InnoDB;
 * 3. Configure your database information (PHP Constants)
 *
 * Also keep in mind, that the key of the $_POST array is the name attribute of the form field.
 * You can check this in Form Builder -> Code tab.
 */

define('DB_SERVER', "localhost");
define('DB_USER', "root");
define('DB_PASSWORD', "");
define('DB_DATABASE', "test");
define('DB_DRIVER', "mysql");

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $my_handshake_key = 'my_handshake_key';

    if (isset($_POST['handshake_key']) && $_POST['handshake_key'] == $my_handshake_key) {

        $name = isset($_POST['text_0']) ? $_POST['text_0'] : '';
        $email = isset($_POST['email_0']) ? $_POST['email_0'] : '';
        $ip_address = isset($_POST['ip_address']) ? $_POST['ip_address'] : '';

        try {
            $db = new PDO(DB_DRIVER . ":dbname=" . DB_DATABASE . ";host=" . DB_SERVER, DB_USER, DB_PASSWORD);
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $stmt = $db->prepare("INSERT INTO subscribers(name, email, ip_address) VALUES (:name, :email, :ip_address)");

            $stmt->bindParam(':name', $name, PDO::PARAM_STR, 255);
            $stmt->bindParam(':email', $email, PDO::PARAM_STR, 255);
            $stmt->bindParam(':ip_address', $ip_address, PDO::PARAM_STR, 255);

            $stmt->execute();

            $db = null;
        } catch(PDOException $e) {
            $fp = file_put_contents('request.log', var_export($e->getMessage(), true), FILE_APPEND);
        }
    }
}
