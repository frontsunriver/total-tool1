<?php
//require_once 'braintreeBraintree.php';
require_once app_path('braintree/braintree/lib/Braintree.php');
// /dd(app_path('braintree/index.php'));

$gateway = new Braintree\Gateway([
    'environment' => 'sandbox',
    'merchantId' => 'wrv3cwbft6n3bg5g',
    'publicKey' => '2bz5kxcj2gs3hdbx',
    'privateKey' => '55ae08cb061e36dca59aaf2a883190bf'
]);

// $clientToken = $gateway->clientToken()->generate([
//     "customerId" => $aCustomerId
// ]);


if($is_transaction=='0'){
	//generate token
  $clientToken = $gateway->clientToken()->generate();
  // echo($clientToken = $gateway->clientToken()->generate());
}else if($is_transaction=='1'){
	//action againts generated nonce
	$result = $gateway->transaction()->sale([
		  'amount' => $order_price,
		  'taxAmount' => $total_tax,
		  //'orderId' => '123',
		  'paymentMethodNonce' => $nonce,
		  'customer' => [
			'firstName' => $delivery_firstname,
			'lastName' => $delivery_lastname,
			//'phone' => $customers_telephone,
			'email' => $email
		  ],
		  'shipping' => [
			'firstName' => $delivery_firstname,
			'lastName' => $delivery_lastname,
			'streetAddress' => $delivery_street_address,
			'locality' => $delivery_postcode,
			'region' => $delivery_state,
			'postalCode' => $billing_postcode,
			'countryName' => $delivery_country
		  ],
		  'billing' => [
			'firstName' => $billing_firstname,
			'lastName' => $billing_lastname,
			'streetAddress' => $billing_street_address,
			'locality' => $billing_city,
			'region' => $billing_state,
			'postalCode' => $billing_postcode,
			'countryName' => $billing_country
		  ],
		  'options' => [
			'submitForSettlement' => true
		  ]
	]);
		//print_r($result);
}


// $result = $gateway->transaction()->sale([
//     'amount' => '10.00',
//     'paymentMethodNonce' => $clientToken,
//     'deviceData' => $deviceDataFromTheClient,
//     'options' => [
//       'submitForSettlement' => True
//     ]
// ]);

// $result = $gateway->transaction()->sale([
//     'amount' => '100.00',
//     'taxAmount' => '1.2',
//     //'orderId' => '123',
//     'paymentMethodNonce' => $deviceDataFromTheClient,
//     'customer' => [
//       'firstName' => 'nasir ali',
//       'lastName' => 'nasir ali',
//       //'phone' => $customers_telephone,
//       'email' => $email
//     ],
//     'shipping' => [
//       'firstName' => 'nasir ali',
//       'lastName' => 'nasir ali',
//       'streetAddress' => 'address',
//       'locality' => '38000',
//       'region' => 'punjab',
//       'postalCode' => '3800',
//       'countryName' => 'USA'
//     ],
//     'billing' => [
//       'firstName' => 'nasir ali ',
//       'lastName' => 'ali',
//       'streetAddress' => 'address',
//       'locality' => '3800',
//       'region' => '3800',
//       'postalCode' => '3800',
//       'countryName' => 'USA'
//     ],
//     'options' => [
//       'submitForSettlement' => true
//     ]
// ]);


// if ($result->success) {
//     print_r("success!: " . $result->transaction->id);
// } else if ($result->transaction) {
//     print_r("Error processing transaction:");
//     print_r("\n  code: " . $result->transaction->processorResponseCode);
//     print_r("\n  text: " . $result->transaction->processorResponseText);
// } else {
//    // print_r("Validation errors: \n");
//     //print_r($result->errors->deepAll());
//     echo '<pre>'.print_r($result->errors->deepAll(), true).'</pre>';
// }

//echo '<pre>'.print_r($result, true).'</pre>';

// $gateway = new Braintree\Gateway($config);

// // Then, create a transaction:
// $result = $gateway->transaction()->sale([
//     'amount' => '1000.00',
//     'paymentMethodNonce' => 'nonceFromTheClient',
//     'options' => [ 'submitForSettlement' => true ]
// ]);

// if ($result->success) {
//     print_r("success!: " . $result->transaction->id);
// } else if ($result->transaction) {
//     print_r("Error processing transaction:");
//     print_r("\n  code: " . $result->transaction->processorResponseCode);
//     print_r("\n  text: " . $result->transaction->processorResponseText);
// } else {
//     print_r("Validation errors: \n");
//     print_r($result->errors->deepAll());
// }

//echo '<pre>'.print_r($gateway, true).'</pre>';

