<?php
defined('BASEPATH') or exit('No direct script access allowed');
/*
| -------------------------------------------------------------------------
| HybridAuth settings
| -------------------------------------------------------------------------
| Your HybridAuth config can be specified below.
|
| See: https://github.com/hybridauth/hybridauth/blob/v2/hybridauth/config.php
*/
$config['hybridauth'] = array(
  "providers" => array(
    // openid providers
    "Google" => array(
      "enabled" => true,
      "keys" => array("id" => "1036080670451-m0tlrbobbjekivf2ev53ogj8941t4f1n.apps.googleusercontent.com", "secret" => "WZFhTmJppuXxdmRiJVcYIvWY"),
    ),
    "Facebook" => array(
      "enabled" => true,
      "keys" => array("id" => "1959877937615152", "secret" => "e25a73ef6ec84dc4dc7433f8a7e9896c"),
      "trustForwarded" => false,
    ),
    "Twitter" => array(
      "enabled" => true,
      "keys" => array("key" => "MPoeJllWq869VJHgtfQJ0mmTS", "secret" => "TZVMcpQwkZTUSSebetSmQpl34Gn2quIGB2lFqwpE9eGKXE5uND"),
      "includeEmail" => false,
    ),
  ),

  // If you want to enable logging, set 'debug_mode' to true.
  // You can also set it to
  // - "error" To log only error messages. Useful in production
  // - "info" To log info and error messages (ignore debug messages)
  "debug_mode" => ENVIRONMENT === 'development',
  // Path to file writable by the web server. Required if 'debug_mode' is not false
  "debug_file" => APPPATH . 'logs/hybridauth.log',


);
