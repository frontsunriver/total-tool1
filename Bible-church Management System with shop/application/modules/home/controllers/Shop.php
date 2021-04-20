<?php defined('BASEPATH') or exit('No direct script access allowed');


use PayPal\Api\ItemList;
use PayPal\Api\Payment;
use PayPal\Api\PaymentExecution;
use PayPal\Api\RedirectUrls;
use Stripe\Stripe;


class Shop extends MX_Controller
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

        //$this->config->load('paypal');
        $this->_api_context = new \PayPal\Rest\ApiContext(
            new \PayPal\Auth\OAuthTokenCredential(
                getBasic()->paypal_client_id,
                getBasic()->paypal_secret
            )
        );

        Stripe::setApiKey(getBasic()->stripe_secret);
    }

    /*****************************/
    /***** Shop Index  ********/
    /*****************************/
    public function index()
    {
        $baselink = "home/product/index";
        $database = "product";
        $perpage = 9;
        $start = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
        $limit = iniPagination($baselink, $database, $perpage);
        $data['product'] = $this->getPagiData($limit, $start);
        $data['pagination'] = $this->pagination->create_links();
        $data['basicinfo'] = $this->getBasicInfo();
        $this->load->view('header');
        $this->load->view('shop/shop', $data);
        $this->load->view('footer', $data);
    }

    /*****************************/
    /***** Shop View  ********/
    /*****************************/
    public function view()
    {
        $data['basicinfo'] = $this->getBasicInfo();
        $data['product'] = $this->getIndividual();
        $data['otherproducts'] = $this->getProductsData();
        $this->load->view('header');
        $this->load->view('shop/view', $data);
        $this->load->view('footer', $data);
    }

    /*****************************/
    /***** Shop View  ********/
    /*****************************/
    public function cart()
    {
        $data['basicinfo'] = $this->getBasicInfo();
        $data['carts'] = $this->getCartProducts();
        $data['otherproducts'] = $this->getProductsData();
        $this->load->view('header');
        $this->load->view('shop/cart', $data);
        $this->load->view('footer', $data);
    }

    /*     * ************************** */
    /*     * *** Adding Into Cart **** */
    /*     * ************************** */

    public function addtocart()
    {

        if ($this->session->userdata('user_id')) {
            $data['cartProductID'] = $this->input->post('productID');
            $data['cartUserID'] = $this->session->userdata('user_id');
            $data['price'] = $this->input->post('price');
            $data['quantity'] = $this->input->post('quantity');
            $data['status'] = "Not Bought";
            $data['cartcdate'] = date("j F Y");
            $inserted = $this->db->insert('cart', $data);
            $this->session->set_flashdata('success', 'Successfully, Added To Cart');
            redirect(base_url() . 'home/shop/', 'refresh');
        } else {
            $this->session->set_flashdata('notsuccess', 'Login is required');
            redirect(base_url() . 'home/shop/', 'refresh');
        }
    }


    /*     * ************************** */
    /*     * *** Cancel Cart Item **** */
    /*     * ************************** */

    public function cancelcart($cartID)
    {

        if ($this->session->userdata('user_id')) {
            $data['status'] = "Cancel";
            $this->db->where('cartID', $cartID);
            $inserted = $this->db->update('cart', $data);
            $this->session->set_flashdata('success', 'Cart Item Successfully Removed');
            redirect(base_url() . 'home/shop/cart', 'refresh');
        } else {
            $this->session->set_flashdata('notsuccess', 'Login is required');
            redirect(base_url() . 'home/shop/cart', 'refresh');
        }
    }


    /*****************************/
    /***** Get Basic Info ********/
    /*****************************/
    public function getBasicInfo()
    {
        $query = $this->db->get('websitebasic');
        return $query->result();
    }

    /*****************************/
    /***** Get Shop Info ********/
    /*****************************/
    public function getShop()
    {
        $query = $this->db->get('product');
        return $query->result();
    }

    /*****************************/
    /***** Get Shop Individual ********/
    /*****************************/
    public function getIndividual()
    {
        $productID = $this->uri->segment(4);
        $query = $this->db->get_where('product', array('productID' => $productID));
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            redirect('home/shop/', 'refresh');
        }
    }

    /*****************************/
    /***** Get Shop Individual ********/
    /*****************************/
    public function getCartProducts()
    {
        $userID = $this->session->userdata('user_id');
        $status = array('Bought', 'Cancel');
        $this->db->join('product', 'product.productID = cart.cartProductID', 'left');
        $this->db->where_not_in('status', $status);
        $query = $this->db->get_where('cart', array('cartUserID' => $userID, 'cartcdate' => date('j F Y')));
        return $query->result();
    }

    /****************************************/
    /********* Get Pagination Shop *************/
    /****************************************/
    public function getPagiData($limit, $start)
    {
        $this->db->limit($limit, $start);
        $query = $this->db->get('product');
        return $query->result();
    }

    /****************************************/
    /********* Get All Products Shop *************/
    /****************************************/
    public function getProductsData()
    {
        $this->db->order_by('productID', 'DESC');
        $this->db->limit(3);
        $query = $this->db->get('product');
        return $query->result();
    }



    /*     * ************************************* */
    /*     * ******* CheckOut By Paypal ************ */
    /*     * ************************************* */

    public function paypal()
    {

        //$this->session->userdata('user_id');
        $name = $this->input->post('name');
        $phone = $this->input->post('phone');
        $address = $this->input->post('address');

        $carts = $this->getCartProducts();
        $totalPrice = array();
        $cartIDs = "";
        $totalItems = 0;

        foreach ($carts as $cart) {
            $totalPrice[] = $cart->price * $cart->quantity;
            $cartIDs .= $cart->cartID . ","; //Sending as Text not Array / Array Will not support in session
            $totalItems++;
        }

        $totalPrice = array_sum($totalPrice);


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

        $item1["name"] = "Order & Purchased By " . $name . " (" . $phone . ")";
        $item1["currency"] = getBasic()->currency;
        $item1["quantity"] = 1;
        $item1["price"] = $totalPrice;

        $itemList = new ItemList();
        $itemList->setItems(array($item1));

        // ### Additional payment details
        // Use this optional field to set additional
        // payment information such as tax, shipping
        // charges etc.

        $details['tax'] = 0.00;
        $details['subtotal'] = $totalPrice;

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

        $transaction['description'] = $totalItems . " Items Purchased By" . $name . " at $" . $totalPrice;
        $transaction['amount'] = $amount;
        $transaction['item_list'] = $itemList;

        // ### Redirect urls
        // Set the urls that the buyer must be redirected to after
        // payment approval/ cancellation.

        $baseUrl = base_url();
        $redirectUrls = new RedirectUrls();
        $redirectUrls->setReturnUrl($baseUrl . "home/shop/getPaypalStatus")
            ->setCancelUrl($baseUrl . "home/shop/getPaypalStatus");

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
            $error =  $ex->getData();
            $this->session->set_flashdata('notsuccess', $error);
            redirect(base_url() . "home/shop/status");
        }

        foreach ($payment->getLinks() as $link) {
            if ($link->getRel() == 'approval_url') {
                $redirect_url = $link->getHref();
                break;
            }
        }

        $this->session->set_userdata('paypal_payment_id', $payment->getId());
        $this->session->set_userdata('payerName', $name);
        $this->session->set_userdata('payerPhone', $phone);
        $this->session->set_userdata('cartIDs', $cartIDs);
        $this->session->set_userdata('address', $address);

        if (isset($redirect_url)) {
            redirect($redirect_url);
        }
    }

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
        $cartIDs = $this->session->userdata('cartIDs');
        $address = $this->session->userdata('address');
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

            $data['orderUserID'] = $this->session->userdata('user_id');
            $data['orderCartIDs'] = $cartIDs;
            $data['orderStatus'] = "Pending";
            $data['orderAmount'] = $payAmount;
            $data['orderMethod'] = "Paypal";
            $data['orderPayment'] = $transactionid;
            $data['orderAddress'] = $address;
            $data['orderCdate'] = date('j F Y');
            $this->db->insert('orders', $data);

            $fundData = array();
            $fundData['fundsdate'] = date('j F Y');
            $fundData['fundsmonth'] = date('F');
            $fundData['fundsyear'] = date('Y');
            $fundData['fundsamount'] = $payAmount;
            $fundData['fundstype'] = "Collect";
            $fundData['receivedby'] = "Admin";
            $fundData['fundssource'] = "Item Sold";
            $fundData['fundsnote'] = "Purchased By " . getUserByID($this->session->userdata('user_id'))->username;
            $fundData['cdate'] = date('j F Y');
            $this->db->insert('funds', $fundData);

            $cartIDsArr = explode(',', $cartIDs);
            for ($x = 0; count($cartIDsArr) > $x; $x++) {
                $cartData = array();
                $cartData['status'] = "Bought";
                $this->db->where_in('cartID', $cartIDsArr[$x]);
                $this->db->update('cart', $cartData);
            }

            $this->session->set_flashdata('success', 'Successfull Ordered, Thank you.');
            redirect(base_url() . "home/shop/status");
        }

        $this->session->set_flashdata('notsuccess', 'Checkout failed, please try again.');
        redirect(base_url() . "home/shop/status");
    }

    public function stripe()
    {

        $name = $this->input->post('name');
        $phone = $this->input->post('phone');
        $address = $this->input->post('address');

        $carts = $this->getCartProducts();
        $totalPrice = array();
        $cartIDs = "";
        $totalItems = 0;

        foreach ($carts as $cart) {
            $totalPrice[] = $cart->price * $cart->quantity;
            $cartIDs .= $cart->cartID . ",";
            $totalItems++;
        }

        $totalPrice = array_sum($totalPrice);
        $totalamount = round($totalPrice * 100); //Amount In Cents

        $token = $this->input->post('stripeToken');
        if (empty($token)) {
            $this->session->set_flashdata('notsuccess', 'Token is not found, you maybe missed something. Please try again.');
            redirect(base_url() . "home/shop/cart/");
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
                $data['orderUserID'] = $this->session->userdata('user_id');
                $data['orderCartIDs'] = $cartIDs;
                $data['orderStatus'] = "Pending";
                $data['orderAmount'] = number_format($stripeAmount / 100, 2);
                $data['orderMethod'] = "Stripe";
                $data['orderPayment'] = $stripeTnxID . " (" . $stripeLastDigit . ")";
                $data['orderAddress'] = $address;
                $data['orderCdate'] = date('j F Y');
                $this->db->insert('orders', $data);

                $fundData = array();
                $fundData['fundsdate'] = date('j F Y');
                $fundData['fundsmonth'] = date('F');
                $fundData['fundsyear'] = date('Y');
                $fundData['fundsamount'] = number_format($stripeAmount / 100, 2);
                $fundData['fundstype'] = "Collect";
                $fundData['receivedby'] = "Admin";
                $fundData['fundssource'] = "Item Sold";
                $fundData['fundsnote'] = "Purchased By " . getUserByID($this->session->userdata('user_id'))->username;
                $fundData['cdate'] = date('j F Y');
                $this->db->insert('funds', $fundData);

                $cartIDsArr = explode(',', $cartIDs);
                for ($x = 0; count($cartIDsArr) > $x; $x++) {
                    $cartData = array();
                    $cartData['status'] = "Bought";
                    $this->db->where_in('cartID', $cartIDsArr[$x]);
                    $this->db->update('cart', $cartData);
                }

                $this->session->set_flashdata('success', 'Successfull Ordered, Thank you.');
                redirect(base_url() . "home/shop/status");
            } else {
                $this->session->set_flashdata('notsuccess', 'Checkout Failed, Please Try Again.');
                redirect(base_url() . "home/shop/status");
            }
        } catch (\Exception $e) {
            $error =  $e->getMessage();
            $this->session->set_flashdata('notsuccess', $error);
            redirect(base_url() . "home/shop/status");
        }
    }


    public function paystack()
    {
        
        $name = $this->input->post('name');
        $phone = $this->input->post('phone');
        $address = $this->input->post('address');

        $carts = $this->getCartProducts();
        $totalPrice = array();
        $cartIDs = "";
        $totalItems = 0;

        foreach ($carts as $cart) {
            $totalPrice[] = $cart->price * $cart->quantity;
            $cartIDs .= $cart->cartID . ",";
            $totalItems++;
        }

        $totalPrice = array_sum($totalPrice);
        $totalamount = round($totalPrice * 100); //Amount In Cents

        $email = getUserByID($this->session->userdata('user_id'))->email;
        if(!isset($email) || empty($email)){
            $email = $this->session->userdata('user_id') . "@biblescript" . rand(5,5) . ".com";
        }

        $paystackSecret = getBasic()->paystack_secret;
        $apiUrl = "https://api.paystack.co/transaction/initialize";
        $amount = $totalamount;  //the amount in kobo. This value is actually NGN 300
        //json post request
        try {
            $client = new \GuzzleHttp\Client();
            $response = $client->request('POST', $apiUrl, [
                'json' => ['amount' => $amount, 'email' => $email, 'reference' => 'shop_payment_' . date('YmdHis')],
                'headers' => [
                    'Authorization' => ' Bearer ' . $paystackSecret,
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
                        'checkout_name' => $name,
                        'checkout_phone' => $phone,
                        'checkout_address' => $address,
                        'checkout_amount' => number_format($amount / 100, 2),
                        'checkout_time' => date('Y-m-d H:i:s'),
                        'checkout_cartIDs' => $cartIDs,
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
                    redirect(base_url() . "home/shop/status");
                }
            } else {
                $this->session->set_flashdata('notsuccess', 'Something Went Wrong, Please Try Again.');
                redirect(base_url() . "home/shop/status");
            }
        } catch (GuzzleHttp\Exception\ClientException $e) {
            $response = $e->getResponse();
            $responseBodyAsString = $response->getBody()->getContents();            
            $this->session->set_flashdata('notsuccess', $responseBodyAsString);
            redirect(base_url() . "home/shop/status");
        } catch (GuzzleHttp\Exception\ConnectException $e) {
            $response = $e->getMessage();
            $this->session->set_flashdata('notsuccess', $response);
            redirect(base_url() . "home/shop/status");
        }
    }


    // Paystack Payment Gateway Functions Start From here
    //====================================================//
    public function paystack_callback()
    {
        $paystackSecret = getBasic()->paystack_secret;        
        $reference = isset($_GET['reference']) ? $_GET['reference'] : '';
        if (!$reference) {            
            $this->session->set_flashdata('notsuccess', "Something Went Wrong, Please Try Again.");
            redirect(base_url() . "home/shop/status");
        }

        if(!empty($reference) && strpos($reference, 'donation_payment_') !== false){
            //paystack paymetn for donation
            //redirect to donation page
            redirect(base_url() . "dashboard/donation/paystack_callback?reference=" . $reference);            
        }

        //paystack payment for shop 
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

                        $checkout_cartIDs = $this->session->checkout_cartIDs;
                        $checkout_address = $this->session->checkout_address;                        

                        if(!isset($checkout_cartIDs) && empty($checkout_cartIDs)){
                            $this->session->set_flashdata('notsuccess', 'Something Went Wrong, Please Try Again.');
                            redirect(base_url() . "home/shop/status");
                        }

                        $data = array();
                        $data['orderUserID'] = $this->session->userdata('user_id');
                        $data['orderCartIDs'] = $checkout_cartIDs;
                        $data['orderStatus'] = "Pending";
                        $data['orderAmount'] = number_format($amount, 2);
                        $data['orderMethod'] = "Paystack";
                        $data['orderPayment'] = $reference;
                        $data['orderAddress'] = $checkout_address;
                        $data['orderCdate'] = date('j F Y');
                        $this->db->insert('orders', $data);

                        $fundData = array();
                        $fundData['fundsdate'] = date('j F Y');
                        $fundData['fundsmonth'] = date('F');
                        $fundData['fundsyear'] = date('Y');
                        $fundData['fundsamount'] = number_format($amount, 2);
                        $fundData['fundstype'] = "Collect";
                        $fundData['receivedby'] = "Admin";
                        $fundData['fundssource'] = "Item Sold";
                        $fundData['fundsnote'] = "Purchased By " . getUserByID($this->session->userdata('user_id'))->username;
                        $fundData['cdate'] = date('j F Y');
                        $this->db->insert('funds', $fundData);

                        $cartIDsArr = explode(',', $checkout_cartIDs);
                        for ($x = 0; count($cartIDsArr) > $x; $x++) {
                            $cartData = array();
                            $cartData['status'] = "Bought";
                            $this->db->where_in('cartID', $cartIDsArr[$x]);
                            $this->db->update('cart', $cartData);
                        }
                        
                        //remove previous session data 
                        $this->session->unset_userdata('checkout_name');
                        $this->session->unset_userdata('checkout_phone');
                        $this->session->unset_userdata('checkout_address');
                        $this->session->unset_userdata('checkout_amount');
                        $this->session->unset_userdata('checkout_time');
                        $this->session->unset_userdata('checkout_cartIDs');

                        $data['basicinfo'] = $this->getBasicInfo();
                        $this->load->view('home/header');
                        $this->load->view('home/checkoutStatus', $data);
                        $this->load->view('home/footer', $data);

                    } else {
                        $this->session->set_flashdata('notsuccess', 'Something Went Wrong, Please Try Again.');
                        redirect(base_url() . "home/shop/status");
                    }
                } else {
                    $this->session->set_flashdata('notsuccess', 'Something Went Wrong, Please Try Again.');
                    redirect(base_url() . "home/shop/status");
                }
            } else {
                $this->session->set_flashdata('notsuccess', 'Something Went Wrong, Please Try Again.');
                redirect(base_url() . "home/shop/status");
            }
        } catch (GuzzleHttp\Exception\ClientException $e) {
            $response = $e->getResponse();
            $responseBodyAsString = $response->getBody()->getContents();
            $this->session->set_flashdata('notsuccess', $responseBodyAsString);
            redirect(base_url() . "home/shop/status");
        } catch (GuzzleHttp\Exception\ConnectException $e) {
            $response = $e->getMessage();
            $this->session->set_flashdata('notsuccess', $response);
            redirect(base_url() . "home/shop/status");
        }
    }



    public function status()
    {
        $data['basicinfo'] = $this->getBasicInfo();
        $this->load->view('home/header');
        $this->load->view('home/checkoutStatus');
        $this->load->view('home/footer', $data);
    }
}
