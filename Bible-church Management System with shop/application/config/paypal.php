<?php
/** set your Paypal credential **/

//$config['client_id'] = 'Adx465SgkzVfGrNW125cDCatCqiYqj7hKDbJk0og08jkVoBVV-b1SlDuL60z4aztGgSgMVdb5xPaNLzl';
//$config['secret'] = 'ELyLozS1eVoORdlvYZFaitwlKRXtKgAOMEdG_Za-jcLRyPN2LjfY-XteUU4O6VSLj9dJHYjWBcZlQ1K4';

/** set your Stripe credential **/
//$config['stripe_apikey'] = 'sk_test_mi57FrKIBSffQz88cpLzHGxS';

/**
 * SDK configuration
 */
/**
 * Available option 'sandbox' or 'live'
 */
$config['settings'] = array(

    'mode' => 'sandbox', // change to live when your application is live
    /**
     * Specify the max request time in seconds
     */
    'http.ConnectionTimeOut' => 1000,
    /**
     * Whether want to log to a file
     */
    'log.LogEnabled' => true,
    /**
     * Specify the file that want to write on
     */
    'log.FileName' => 'application/logs/paypal.log',
    /**
     * Available option 'FINE', 'INFO', 'WARN' or 'ERROR'
     *
     * Logging is most verbose in the 'FINE' level and decreases as you
     * proceed towards ERROR
     */
    'log.LogLevel' => 'FINE'
);
