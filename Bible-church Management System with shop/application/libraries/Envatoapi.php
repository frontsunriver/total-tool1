<?php
class Envatoapi {
    // Bearer, no need for OAUTH token, change this to your bearer string
    // https://build.envato.com/api/#token
    //private static $bearer = "hTl89YLIDJqra1orJvkasA5ojJg9GUgg";
    //private static $bearer = "Ui2Tiq2JyKNh7nNRb1uBrEKYujKyBBhv";
    
    static function getPurchaseData($code) {        
        
        $personal_token = "hTl89YLIDJqra1orJvkasA5ojJg9GUgg";
        $header = array();
        $header[] = 'Authorization: Bearer '.$personal_token;
        $header[] = 'User-Agent: Mozilla/5.0 (Macintosh; Intel Mac OS X 10.11; rv:41.0) Gecko/20100101 Firefox/41.0';
        $header[] = 'timeout: 20';
        
        $product_code = $code;
        $url = "https://api.envato.com/v3/market/author/sale?code=".$product_code;
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_HTTPHEADER,$header);
        
        $envatoRes = curl_exec($curl);
        curl_close($curl);
        $envatoRes = json_decode($envatoRes, true);        
        return $envatoRes;
        
    }
    
    static function verifyPurchase($code) {        
      $verify_obj = self::getPurchaseData($code);       
      return $verify_obj;      
    }
  }
  
?>