<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class Mailer {

	private $mail;

	public function __construct(){

		$this->mail = new PHPMailer(true);
		$this->mail->SMTPDebug = 3;                                
	    $this->mail->isSMTP();                                      
	    $this->mail->Host = MAIL_HOST;
	    $this->mail->SMTPAuth = true;                        
	    $this->mail->Username = MAIL_USERNAME;    
	    $this->mail->Password = MAIL_PASSWORD;
	    $this->mail->SMTPSecure = 'tls';  
	    $this->mail->Port =MAIL_PORT; 
	    
	}

	public function setFrom($email,$name=''){
		$this->mail->setFrom($email,$name);
	}

	public function addAddress($email,$name='') {
		$this->mail->addAddress($email,$name);
	}

	public function addReplyTo($email,$name='') {
		$this->mail->addReplyTo($email, $name);
	}

	public function subject($subject){
		$this->mail->Subject=$subject;
	}

	public function body($body){
		$this->mail->Body=$body;
	}

	public function altBody($body){
		$this->mail->AltBody=$body;
	}

	public function send(){
		try{
			return $this->mail->send();
		}catch(\Exception $e){
			return $this->mail->ErrorInfo;
		}
	}

	public function isHTML($is_html=true){
		$this->mail->isHTML($is_html);
	}


}


?>