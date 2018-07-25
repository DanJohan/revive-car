<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use Twilio\Rest\Client;

class TextMessage {
	private $account_sid = TWILIO_SID;
	private $auth_token = TWILIO_TOKEN;
	private $twilio_number = TWILIO_NUMBER;
	private $client;

	public function __construct(){
		$this->client = new Client($this->account_sid, $this->auth_token);
	}

	public function send($data=array()){

		try{
			$message = $this->client->messages->create(
				    // Where to send a text message (your cell phone?)
				    $data['phone'],
				    array(
				        'from' => $this->twilio_number,
				        'body' => $data['body']
				    )
				);
			return $message;
		}catch(Exception $e){
			return $e->getMessage();
		}
	}
}

?>