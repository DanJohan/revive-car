<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Rest_Controller extends MY_Controller
{


  public function __construct()
  {
    parent::__construct();
    $this->put_json_post();
    $this->checkApiKey();
  }

  protected function put_json_post() {

  	$json_post = json_decode(file_get_contents('php://input'), true);
  	$_POST = array_merge($_POST,($json_post && $this->isValidJson()) ? $json_post :array());
  }

  protected function isValidJson(){
   	return json_last_error() == JSON_ERROR_NONE;
  }

  protected function checkApiKey(){
  	$headers = getallheaders();
  	if(!empty($headers['X-Api-Key'])){
  		$api_key = $headers['X-Api-Key'];
  		$query = $this->db->get_where('rest_keys', array('api_key' => $api_key));
  		if($query->num_rows() ==0){
  			$this->withStatus(403)->renderJson(array('status'=>false,'message'=>'Invalid api key!'));
  		}
  	}else{
  		$this->withStatus(403)->renderJson(array('status'=>false,'message'=>'Api key required!'));
  	}
  }

}
?>
