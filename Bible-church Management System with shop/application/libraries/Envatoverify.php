<?php

/*
 * Envato API PHP Class
 *
 * This PHP Class was created in order to communicate with the new Envato API.
 *
 * Source: https://radiumthemes.com/?p=677
 * API Documentation: https://build.envato.com/api/
 *
 * Copyright 2017: RadiumThemes
 * 
 * Ui2Tiq2JyKNh7nNRb1uBrEKYujKyBBhv
 */
class Envatoverify {

	private $api_url = 'https://api.envato.com/v3/market'; // base URL to envato api
        
	/** Constructor */
	function __construct() {
        $this->api_key = 'Ui2Tiq2JyKNh7nNRb1uBrEKYujKyBBhv';
	}

	/**
	 * General purpose function to query the Envato API.
	 *
	 * @param string $url The url to access, via curl.
	 * @return object The results of the curl request.
	 */
	protected function curl( $url ) {

		if ( empty( $url) ) return false;

		$api_key = $this->api_key;

		// Send request to envato to verify purchase
		$ch = curl_init( $url );
		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
		curl_setopt( $ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; Envato API Wrapper PHP)' );

		$header = array();
		$header[] = 'Content-length: 0';
		$header[] = 'Content-type: application/json';
		$header[] = 'Authorization: Bearer '. $api_key;

		curl_setopt( $ch, CURLOPT_HTTPHEADER, $header );
		curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, 0);

		$data = curl_exec( $ch );
		curl_getinfo( $ch,CURLINFO_HTTP_CODE );
		curl_close( $ch );

		$response = json_decode( $data, true );

		return $response; // string or null
	}

	/**
	 * Verify purchase code and checks if
	 * code already used
	 *
	 * @since 	1.0
	 *
	 * @return 	array - purchase data
	 */
	public function verify_purchase( $purchase_code = '' ) {

		// Check for empty fields
		if ( empty( $purchase_code ) ) {
			return false;
		}

		// Gets author data & prepare verification vars
		$purchase_code 	= urlencode( $purchase_code );

		$url = $this->api_key . '/author/sale?code=' . $purchase_code;

	    $response = $this->curl( $url );

    	if ( isset( $response['error'] ) && $response['error'] == '404' ) {
    		return false;
    	} else {
            return true;
        }

	}
}
