<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

use Twilio\Rest\Client;

if ( ! function_exists('generate_otp'))
{
    function generate_otp($digits = 4)
    {
        return rand(pow(10, $digits - 1) - 1, pow(10, $digits) - 1);
    }   
}

if ( ! function_exists('send_sms'))
{
    function send_sms($data = array())
    {
        // Your Account SID and Auth Token from twilio.com/console
        try{
			$account_sid = TWILIO_SID;
			$auth_token = TWILIO_TOKEN;
			// In production, these should be environment variables. E.g.:
			// $auth_token = $_ENV["TWILIO_ACCOUNT_SID"]

			// A Twilio number you own with SMS capabilities
			$twilio_number = TWILIO_NUMBER;

			$client = new Client($account_sid, $auth_token);
			$message = $client->messages->create(
			    // Where to send a text message (your cell phone?)
			    $data['phone'],
			    array(
			        'from' => $twilio_number,
			        'body' => $data['body']
			    )
			);
			return $message;
		}catch(Exception $e){
			return $e->getMessage();
		}
    }   
}