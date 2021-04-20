<?php

//Loads configuration from database into global CI config
function load_config()
{

    $ci = & get_instance(); //get main CodeIgniter object
    $ci->load->database(); //load databse library
    $settings = $ci->db->get('websitebasic')->result()[0];

    //Mailgun API Keys
    $ci->config->set_item('mailgun_api', $settings->mailgun_api);
    $ci->config->set_item('mailgun_from', $settings->mailgun_from);
    $ci->config->set_item('mailgun_domain', $settings->mailgun_domain);

    //Nexmo API Keys
    $ci->config->set_item('nexmo_api', $settings->nexmo_api);
    $ci->config->set_item('nexmo_secret', $settings->nexmo_secret);
    $ci->config->set_item('nexmo_from', $settings->nexmo_from);

    //Paypal API Keys
    $ci->config->set_item('paypal_client_id', $settings->paypal_client_id);
    $ci->config->set_item('paypal_secret', $settings->paypal_secret);

    //Stripe API Keys
    $ci->config->set_item('stripe_api', $settings->stripe_apikey);
    $ci->config->set_item('stripe_secret', $settings->stripe_secret);

    $ci->config->set_item('twilio_sid', $settings->twilio_sid);
    $ci->config->set_item('twilio_token', $settings->twilio_token);
    $ci->config->set_item('twilio_sender', $settings->twilio_sender);

}
