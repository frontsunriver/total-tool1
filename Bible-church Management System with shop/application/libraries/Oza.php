<?php

class Oza
{

  public function getPurchaseData($code, $server)
  {

    $code = $code;
    $server = $server;

    $url = "https://bible_license.onezeroart.com/verify?code=" . $code . "server=" . $server;
    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    $bibleRes = curl_exec($curl);
    curl_close($curl);
    if (isset($bibleRes) && !empty($bibleRes)) {
      $bibleRes = json_decode($bibleRes, true);
      return $bibleRes;
    } else {
      return false;
    }

  }

  public function verifyPurchase($code, $server)
  {
    $verify_obj = $this->getPurchaseData($code, $server);
    return $verify_obj;
  }

}
