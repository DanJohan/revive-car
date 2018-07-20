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


  protected function renderJson($data) {
    header('Content-Type: application/json');
    echo json_encode($data);
    exit;
  }
}
?>