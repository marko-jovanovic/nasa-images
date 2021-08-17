<?php 

namespace NASA\Helper;

class Http {
  public static function get($url) {
    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HEADER, false);

    $data = curl_exec($curl);
    curl_close($curl);

    return json_decode($data, true);
  }
}
