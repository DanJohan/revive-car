<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Rest_Controller extends MY_Controller
{


  public function __construct()
  {
    parent::__construct();
    $this->put_json_post();
  }

  public function put_json_post() {

  	$json_post = json_decode(file_get_contents('php://input'), true);
  	$_POST = array_merge($_POST,($json_post && $this->isValidJson()) ? $json_post :array());
  }

  public function isValidJson(){
   	return json_last_error() == JSON_ERROR_NONE;
  }


}
?>