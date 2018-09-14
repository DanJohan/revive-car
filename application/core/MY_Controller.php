<?php defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller
{
  protected $data = array();

  public function __construct()
  {
    parent::__construct();

  }

  protected function render($the_view = NULL, $template = 'admin/layout')
  {
    if($template == 'json' || $this->input->is_ajax_request())
    {
      header('Content-Type: application/json');
      echo json_encode($this->data);
    }
    else
    {
      $this->data['view'] = (is_null($the_view)) ? '' : $this->load->view($the_view,$this->data, TRUE);;
      $this->load->view($template, $this->data);
    }
  }

  protected function withStatus($code) {
     http_response_code($code);
     return $this;
  }

  protected function renderJson($data) {
    header('Content-Type: application/json');
    echo json_encode($data);
    exit;
  }

  public function do_upload($file,$path,$params=array())
  {
      $config['upload_path'] = $path;
      $config['allowed_types']= (isset($params['allowed_types']))?$params['allowed_types']:'jpg|png|jpeg';
      $config['max_size']= (isset($params['max_size']))?$params['max_size']:0;
      $config['max_width'] =(isset($params['max_width']))?$params['max_width']:0;
      $config['max_height']=(isset($params['max_height']))?$params['max_height']: 0;


      if(isset($params['new_name']) && $params['new_name'] ==true) { 
        $new_name =  time().'_'.uniqid(mt_rand(1000,9999)).'_'.$_FILES[$file]['name'];
        $config['file_name'] =  $new_name;
      }else{
          $config['encrypt_name'] =true;   
      }

      $this->upload->initialize($config);
      if ( ! $this->upload->do_upload($file))
      {
             return array('error' => $this->upload->display_errors());

      }
      else
      {
            return array('upload_data' => $this->upload->data());

      }
  }
}

// include other controllers that extent My_controller
require_once 'Rest_Controller.php';
?>