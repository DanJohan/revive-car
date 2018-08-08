<?php
use  Firebase\JWT\JWT;
class JwtAuth {
	private $secretKey = JWT_KEY;
	private $ci;
	
	public function __construct(){
		$this->ci= & get_instance();
	}

	public function verify_request(){
		$authorization = $this->ci->input->get_request_header('Authorization');
		list($jwt) = sscanf( $authorization, 'Bearer %s');
		if (!empty($jwt)) {
            try {
                $secret_key = base64_decode($this->secretKey);
                $token = JWT::decode($jwt, $secret_key, array('HS512'));

            } catch (Exception $e) {
                echo json_encode(array('status'=>false,'message'=>$e->getMessage()));
                header('HTTP/1.0 401 Unauthorized');
                die;
            }
        } else {
        	echo json_encode(array('status'=>false,'message'=>'Token is required'));
            header('HTTP/1.0 400 Bad Request');
            die;
        }
	}
}// end of class
?>