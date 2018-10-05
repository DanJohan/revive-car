<?php
use  Firebase\JWT\JWT;
class JwtAuth {
	private $secretKey = JWT_KEY;
	private $ci;
	private $user;
	
	public function __construct(){
		$this->ci= & get_instance();
	}

	public function generateToken($user){
		    	$tokenId    = base64_encode(uniqid());
    			$issuedAt   = time();
    			$notBefore  = $issuedAt + 10;             //Adding 10 seconds
   			// $expire     = $notBefore + '100years';            // Adding 60 seconds
    			$serverName = base_url(); // Retrieve the server name from config file
    			$data = [
    			   'sub' =>$user['id'],
		        'iat'  => $issuedAt,         // Issued at: time when the token was generated
		        'jti'  => $tokenId,          // Json Token Id: an unique identifier for the token
		        'iss'  => $serverName,       // Issuer
		        'nbf'  => $notBefore,        // Not before
		       // 'exp'  => $expire,           // Expire
		    ];

		    $jwt = JWT::encode($data, $this->secretKey,'HS512');
            
		    return ($jwt) ? array('token'=>$jwt) :false;
	}

	public function authenticate(){
		dd($this->ci->input->request_headers());
		$authorization = $this->ci->input->get_request_header('Authorization');

		list($jwt) = sscanf( $authorization, 'Bearer %s');

		if (!empty($jwt)){
            try {
                $secret_key = $this->secretKey;
                $claims = JWT::decode($jwt, $secret_key, array('HS512'));
                $this->user=$claims->sub;

            }catch (Exception $e) {
            	 $this->withStatus(401)->renderJson(array('status'=>false,'message'=>$e->getMessage()));
            }
        } else {
        	$this->withStatus(400)->renderJson(array('status'=>false,'message'=>'Token is required'));
        }
        return;
	}

	public function getUser(){
		$criteria['field'] = 'id,name,email,phone,created_at';
		$criteria['conditions'] = array('id'=>$this->user);
		$criteria['returnType'] = 'single';
		$user = $this->ci->UserModel->search($criteria);
		return ($user) ? $user :null;
	}

	public function getDriver(){
		$criteria['field'] = 'id,name,email,phone,created_at';
		$criteria['conditions'] = array('id'=>$this->user);
		$criteria['returnType'] = 'single';
		$user = $this->ci->UserModel->search($criteria);
		return ($user) ? $user :null;
	}

	public function getUserId(){
		return $this->user;
	}

	private function withStatus($code) {
     	http_response_code($code);
     	return $this;
  	}

	private function renderJson($data) {
	    header('Content-Type: application/json');
	    echo json_encode($data);
	    exit;
	 }
}// end of class
?>
