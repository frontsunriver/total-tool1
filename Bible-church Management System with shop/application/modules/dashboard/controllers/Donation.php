<?php

defined('BASEPATH') or exit('No direct script access allowed');

use PayPal\Api\ItemList;
use PayPal\Api\Payment;
use PayPal\Api\PaymentExecution;
use PayPal\Api\RedirectUrls;
use Stripe\Stripe;

class Donation extends MX_Controller
{
    /*
      | -----------------------------------------------------
      | PRODUCT NAME: ONEZEROART CHURCH MANAGEMENT SYSTEM (CHMS)
      | -----------------------------------------------------
      | AUTHOR: ONEZEROART TEAM
      | -----------------------------------------------------
      | EMAIL: support@onezeroart.com
      | -----------------------------------------------------
      | COPYRIGHT: RESERVED BY ONEZEROART.COM
      | -----------------------------------------------------
      | WEBSITE: http://onezeroart.com
      | -----------------------------------------------------
     */

    function __construct()
    {
        parent::__construct();

        $language = $this->session->userdata('lang');
        $this->lang->load('dashboard', $language);

        //$this->config->load('paypal');
        $this->_api_context = new \PayPal\Rest\ApiContext(
            new \PayPal\Auth\OAuthTokenCredential(
                getBasic()->paypal_client_id,
                getBasic()->paypal_secret
            )
        );

        Stripe::setApiKey(getBasic()->stripe_secret);
    }

    //donation by paypal
    public function paypal()
    {

        $totalamount = $this->input->post('amount');
        $name = $this->input->post('name');
        $email = $this->input->post('email');
        $phone = $this->input->post('phone');

        // setup PayPal api context
        //$this->_api_context->setConfig($this->config->item('settings'));
        // ### Payer
        // A resource representing a Payer that funds a payment
        // For direct credit card payments, set payment method
        // to 'credit_card' and add an array of funding instruments.

        $payer['payment_method'] = 'paypal';

        // ### Itemized information
        // (Optional) Lets you specify item wise
        // information

        $item1["name"] = "Donation from" . $name;
        $item1["currency"] = getBasic()->currency;
        $item1["quantity"] = 1;
        $item1["price"] = $totalamount;

        $itemList = new ItemList();
        $itemList->setItems(array($item1));

        // ### Additional payment details
        // Use this optional field to set additional
        // payment information such as tax, shipping
        // charges etc.

        $details['tax'] = 0.00;
        $details['subtotal'] = $totalamount;

        // ### Amount
        // Lets you specify a payment amount.
        // You can also specify additional details
        // such as shipping, tax.

        $amount['currency'] = getBasic()->currency;
        $amount['total'] = $details['subtotal'];

        //$amount['details'] = $details;
        // ### Transaction
        // A transaction defines the contract of a
        // payment - what is the payment for and who
        // is fulfilling it.

        $transaction['description'] = "Donation from" . $name;
        $transaction['amount'] = $amount;
        $transaction['item_list'] = $itemList;

        // ### Redirect urls
        // Set the urls that the buyer must be redirected to after
        // payment approval/ cancellation.

        $baseUrl = base_url();
        $redirectUrls = new RedirectUrls();
        $redirectUrls->setReturnUrl($baseUrl . "dashboard/donation/getPaypalStatus")
            ->setCancelUrl($baseUrl . "dashboard/donation/getPaypalStatus");

        // ### Payment
        // A Payment Resource; create one using
        // the above types and intent set to sale 'sale'

        $payment = new Payment();
        $payment->setIntent("sale")
            ->setPayer($payer)
            ->setRedirectUrls($redirectUrls)
            ->setTransactions(array($transaction));

        try {
            $payment->create($this->_api_context);
        } catch (Exception $ex) {
            $error = $ex->getData();
            $this->session->set_flashdata('notsuccess', $error);
            redirect(base_url() . "dashboard/donation/status");
        }

        foreach ($payment->getLinks() as $link) {
            if ($link->getRel() == 'approval_url') {
                $redirect_url = $link->getHref();
                break;
            }
        }

        $this->session->set_userdata('paypal_payment_id', $payment->getId());
        $this->session->set_userdata('payerName', $name);
        $this->session->set_userdata('payerEmail', $email);
        $this->session->set_userdata('payerPhone', $phone);

        if (isset($redirect_url)) {
            /** redirect to paypal * */
            redirect($redirect_url);
        }
    }

    //donation by paypal callback
    public function getPaypalStatus()
    {

        // paypal credentials

        /** Get the payment ID before session clear * */
        $payment_id = $this->input->get("paymentId");
        $PayerID = $this->input->get("PayerID");
        $token = $this->input->get("token");

        $payment_id = $this->session->userdata('paypal_payment_id');

        $payerName = $this->session->userdata('payerName');
        $payerPhone = $this->session->userdata('payerPhone');
        $payerEmail = $this->session->userdata('payerEmail');

        $this->session->unset_userdata('paypal_payment_id');

        /** clear the session payment ID * */
        if (empty($PayerID) || empty($token)) {
            $this->session->set_flashdata('notsuccess', 'Payment failed');
            redirect('home');
        }

        $payment = Payment::get($payment_id, $this->_api_context);

        /** PaymentExecution object includes information necessary * */
        /** to execute a PayPal account payment. * */
        /** The payer_id is added to the request query parameters * */
        /** when the user is redirected from paypal back to your site * */
        $execution = new PaymentExecution();
        $execution->setPayerId($this->input->get('PayerID'));

        /*         * Execute the payment * */
        $result = $payment->execute($execution, $this->_api_context);

        //  DEBUG RESULT, remove it later **/
        if ($result->getState() == 'approved') {

            $transactionid = $result->getId();
            $trans = $result->getTransactions();
            $payAmount = $trans[0]->getAmount()->getTotal();

            $data = array();

            $data['donationdate'] = date('d/m/Y');
            $data['donationmonth'] = date('F');
            $data['donationyear'] = date('Y');
            $data['donationamount'] = $payAmount;
            $data['donationsource'] = "Donation From (" . $payerName . ") (" . $payerEmail . ") (" . $payerPhone . ")";
            $data['donationby'] = "Paypal";
            $data['donationinfo'] = $transactionid;
            $data['donationreceivedby'] = " ";
            $data['donationnote'] = "Donation Currecny " . getBasic()->currency;;
            $data['cdate'] = date('j F Y');

            $this->db->insert('donation', $data);

            $this->session->set_flashdata('success', 'Successfull Donated, Thank you.');
            redirect(base_url() . "dashboard/donation/status");
        }

        $this->session->set_flashdata('notsuccess', 'Donation failed, please try again.');
        redirect(base_url() . "dashboard/donation/status");
    }

    //donation by stripe
    public function stripe()
    {

        $totalamount = round((int) $this->input->post('amount') * 100); //Amount In Cents

        $name = $this->input->post('name');
        $email = $this->input->post('email');
        $phone = $this->input->post('phone');

        $token = $this->input->post('stripeToken');
        if (empty($token)) {
            $this->session->set_flashdata('notsuccess', 'Token is not found, you maybe missed something. Please try again.');
            redirect(base_url() . "dashboard/donation/status");
        }

        try {

            // This is a $20.00 charge in US Dollar.
            $charge = \Stripe\Charge::create(
                array(
                    'amount' => $totalamount,
                    'currency' => getBasic()->currency,
                    'source' => $token
                )
            );


            //retrieve charge details
            $chargeJson = $charge->jsonSerialize();
            $stripeID = $chargeJson['id'];
            $stripeStatus = $chargeJson['status'];
            $stripeAmount = $chargeJson['amount'];
            $stripeTnxID = $chargeJson['balance_transaction'];
            $stripeCreated = $chargeJson['created'];
            $stripeCurrency = $chargeJson['currency'];
            $stripePaid = $chargeJson['paid'];
            $stripeSourceID = $chargeJson['source']['id'];
            $stripeLastDigit = $chargeJson['source']['last4'];

            if ($stripeStatus == "succeeded") {

                $data = array();

                $data['donationdate'] = date('d/m/Y');
                $data['donationmonth'] = date('F');
                $data['donationyear'] = date('Y');
                $data['donationamount'] = number_format($stripeAmount / 100, 2);
                $data['donationsource'] = "Donation From (" . $name . ") (" . $email . ") (" . $phone . ")";
                $data['donationby'] = "Stripe";
                $data['donationinfo'] = $stripeTnxID . " (" . $stripeLastDigit . ")";
                $data['donationreceivedby'] = " ";
                $data['donationnote'] = "Donation Currency " . getBasic()->currency;
                $data['cdate'] = date('j F Y');

                $this->db->insert('donation', $data);

                $this->session->set_flashdata('success', 'Successfull Donated, Thank you.');
                redirect(base_url() . "dashboard/donation/status");
            } else {
                $this->session->set_flashdata('notsuccess', 'Something Went Wrong, Please Try Again.');
                redirect(base_url() . "dashboard/donation/status");
            }
        } catch (\Exception $e) {
            $error =  $e->getMessage();
            $this->session->set_flashdata('notsuccess', $error);
            redirect(base_url() . "dashboard/donation/status");
        }
    }

    //donation by paystack
    public function paystack()
    {
        $amount = $this->input->post("amount");
        $name = $this->input->post("name");
        $email = $this->input->post("email");
        $phone = $this->input->post("phone");

        $paystackSecret = getBasic()->paystack_secret;  
        $apiUrl = "https://api.paystack.co/transaction/initialize";
        $amount = ($amount * 100);  //the amount in kobo. This value is actually NGN 300
        //json post request
        try {
            $client = new \GuzzleHttp\Client();
            $response = $client->request('POST', $apiUrl, [
                'json' => ['amount' => $amount, 'email' => $email, 'reference' => 'donation_payment_' . date('YmdHis')],
                'headers' => [
                    'authorization' => 'Bearer ' . $paystackSecret,
                    'content-type'     => 'application/json',
                    'cache-control'      => 'no-cache'
                ]
            ]);
            $response->getStatusCode();
            $response->getHeaderLine('content-type');
            $responseBody = $response->getBody();
            if (isset($responseBody) && !empty($responseBody)) {
                $response = json_decode($response->getBody(), true); // returns array
                if (isset($response) && is_array($response)) {

                    //setting session data for later use in callback function
                    $newdata = array(
                        'donate_name' => $name,
                        'donate_phone' => $phone,
                        'donate_email' => $email,
                        'donate_amount' => number_format($amount/100, 2),
                        'donate_time' => date('Y-m-d H:i:s'),
                    );                    
                    $this->session->set_userdata($newdata);

                    $status =  $response['status'];
                    $message =  $response['message'];
                    $authorization_url =  $response['data']['authorization_url'];
                    $access_code =  $response['data']['access_code'];
                    $reference =  $response['data']['reference'];
                    //redirect to payment page
                    redirect($authorization_url);
                    
                } else {
                    $this->session->set_flashdata('notsuccess', 'Something Went Wrong, Please Try Again.');
                    redirect(base_url() . "dashboard/donation/status");
                }
            } else {
                $this->session->set_flashdata('notsuccess', 'Something Went Wrong, Please Try Again.');
                redirect(base_url() . "dashboard/donation/status");
            }
        } catch (GuzzleHttp\Exception\ClientException $e) {
            $response = $e->getResponse();
            $responseBodyAsString = $response->getBody()->getContents();
            $this->session->set_flashdata('notsuccess', $responseBodyAsString);
            redirect(base_url() . "dashboard/donation/status");
        } catch (GuzzleHttp\Exception\ConnectException $e) {
            $response = $e->getMessage();
            $this->session->set_flashdata('notsuccess', $response);
            redirect(base_url() . "dashboard/donation/status");
        }
    }

    //donation by paystack callback
    public function paystack_callback()
    {
        $paystackSecret = getBasic()->paystack_secret;     
        $reference = isset($_GET['reference']) ? $_GET['reference'] : '';
        if (!$reference) {
            $this->session->set_flashdata('notsuccess', "Something Went Wrong, Please Try Again.");
            redirect(base_url() . "dashboard/donation/status");
        }

        if(!empty($reference) && strpos($reference, 'shop_payment_') !== false){
            //paystack paymetn for shop
            //redirect to shop page
            redirect(base_url() . "home/shop/paystack_callback?reference=" . $reference);            
        }

        $apiUrl = "https://api.paystack.co/transaction/verify/" . rawurlencode($reference);
        //json post request
        try {
            $client = new \GuzzleHttp\Client();
            $response = $client->request('GET', $apiUrl, [
                'headers' => [
                    'authorization' => 'Bearer ' . $paystackSecret,
                    'content-type'     => 'application/json',
                    'cache-control'      => 'no-cache'
                ]
            ]);
            $response->getStatusCode();
            $response->getHeaderLine('content-type');
            $responseBody = $response->getBody();
            if (isset($responseBody) && !empty($responseBody)) {
                $response = json_decode($response->getBody(), true); // returns array
                if (isset($response) && is_array($response)) {
                    $status =  $response['status'];
                    $amount =  $response['data']['amount'] / 100;
                    $reference =  $response['data']['reference'];
                    //$first_name =  $response['data']['customer']['first_name'];
                    //$last_name =  $response['data']['customer']['last_name'];
                    $email =  $response['data']['customer']['email'];
                    if ($status == "status") {

                        $donate_name = $this->session->donate_name;
                        $donate_email = $this->session->donate_email;
                        $donate_phone = $this->session->donate_phone;

                        if($donate_email == $email){
                            $donateSourceInfo = "Donation From " . $donate_name . " " . $donate_email . " " . $donate_phone;
                        }else{
                            $this->session->unset_userdata('donate_name');
                            $this->session->unset_userdata('donate_phone');
                            $this->session->unset_userdata('donate_email');
                            $this->session->unset_userdata('donate_amount');
                            $this->session->unset_userdata('donate_time');
                            $donateSourceInfo = "Donation From " . $email;
                        }

                        $data = array();
                        $data['donationdate'] = date('d/m/Y');
                        $data['donationmonth'] = date('F');
                        $data['donationyear'] = date('Y');
                        $data['donationamount'] = number_format($amount, 2);
                        $data['donationsource'] = $donateSourceInfo;
                        $data['donationby'] = "Paystack";
                        $data['donationinfo'] = $reference;
                        $data['donationreceivedby'] = " ";
                        $data['donationnote'] = "Donation Currency " . getBasic()->currency;
                        $data['cdate'] = date('j F Y');
                        $this->db->insert('donation', $data);
                        
                        $data['basicinfo'] = $this->getBasicInfo();
                        $this->load->view('home/header');
                        $this->load->view('home/donationStatus', $data);
                        $this->load->view('home/footer', $data);
                        
                    } else {
                        $this->session->set_flashdata('notsuccess', 'Something Went Wrong, Please Try Again.');
                        redirect(base_url() . "dashboard/donation/status");
                    }
                } else {
                    $this->session->set_flashdata('notsuccess', 'Something Went Wrong, Please Try Again.');
                    redirect(base_url() . "dashboard/donation/status");
                }
            } else {
                $this->session->set_flashdata('notsuccess', 'Something Went Wrong, Please Try Again.');
                redirect(base_url() . "dashboard/donation/status");
            }
        } catch (GuzzleHttp\Exception\ClientException $e) {
            $response = $e->getResponse();
            $responseBodyAsString = $response->getBody()->getContents();
            $this->session->set_flashdata('notsuccess', $responseBodyAsString);
            redirect(base_url() . "dashboard/donation/status");
        } catch (GuzzleHttp\Exception\ConnectException $e) {
            $response = $e->getMessage();
            $this->session->set_flashdata('notsuccess', $response);
            redirect(base_url() . "dashboard/donation/status");
        }
    }

    //donation status
    public function status()
    {
        $data['basicinfo'] = $this->getBasicInfo();
        $this->load->view('home/header');
        $this->load->view('home/donationStatus');
        $this->load->view('home/footer', $data);
    }

    public function getBasicInfo()
    {
        $query = $this->db->get('websitebasic');
        return $query->result();
    }
}
