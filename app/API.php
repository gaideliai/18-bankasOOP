<?php
namespace App;


class API
{
    const API_KEY = '66d4223ea24c04f43c573f0730b1a545';
   
    public static function getRate() {
        $curl_handle = curl_init();

        curl_setopt($curl_handle, CURLOPT_URL, ("http://data.fixer.io/api/latest?access_key=".self::API_KEY));
        curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);

        $server_output = curl_exec($curl_handle); 
        curl_close($curl_handle);
        $result = json_decode($server_output, 1);

        $USDrate = $result['rates']['USD'];
        return $USDrate;
    }

}