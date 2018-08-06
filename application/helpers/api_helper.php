<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


if ( ! function_exists('getRandomString'))
{
	function getRandomString($length=5) 
	{

	    $characters = "0123456789ABCDEFGHIJKLMNOPQRSTUVWZYZ";

	    $real_string_length = strlen($characters) ;     
	    $string=''; 
	    for ($p = 0; $p < $length; $p++) 
	    {
	        $string .= $characters[mt_rand(0, $real_string_length-1)];
	    }

	    return strtolower($string);
	}
}

if(!function_exists('send_push_notification')){
	function send_push_notification($data,$key){
		$url = 'https://fcm.googleapis.com/fcm/send';
		$serverApiKey = $key;
		$headers = array(
			'Content-Type:application/json',
			'Authorization:key=' .$serverApiKey
		);	
	
				 $ch = curl_init();
				 curl_setopt($ch, CURLOPT_URL, $url);
				 curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
				 curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
				 curl_setopt($ch, CURLOPT_POST, true);
				 curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				 curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));     
				 $response = curl_exec($ch);
				 curl_close($ch);
				 $result_ = json_decode($response,true);
				 return $result_;
	}
}
