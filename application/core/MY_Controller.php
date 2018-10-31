<?php defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller
{
  protected $data = array();

  public function __construct()
  {
    parent::__construct();
    
    require_once APPPATH."config/MY_constants.php";
  }


  protected function render($the_view = NULL,$data=array() ,$layout = 'admin/layouts/main')
  {	
  	$tabs= $this->initSidebarTab();
  	$data['cur_tab'] = $tabs['cur_tab'];
  	$data['cur_tab_link'] = $tabs['cur_tab_link'];
     $data['content'] = (is_null($the_view)) ? '' : $this->load->view($the_view,$data, TRUE);
      //dd($this->widget);
      $this->load->view($layout, $data);  
  }

  protected function initSidebarTab(){
  	$cur_tab = $this->uri->segment(2)==''?'dashboard': $this->uri->segment(2);
	$cur_tab_link =   $this->uri->segment(3)==''?'index': $this->uri->segment(3);
	if($cur_tab=='enquiry'){
	  $cur_tab_link="e_".$cur_tab_link;
	}
	return array('cur_tab_link'=>$cur_tab_link, 'cur_tab'=>$cur_tab);
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
  }// end of do_upload method

  protected function filterJobCardData($job_card =array()){
  	if(!empty($job_card)){
  		$job_card_images = array_filter_by_value(array_unique(array_column_multi($job_card, array('image','image_id')),SORT_REGULAR),'image_id','');
		$repair_orders = array_filter_by_value(array_unique(array_column_multi($job_card, array('repair_order_id','parts_name','customer_request','sa_remarks','qty','labour_price','parts_price','total_price','status')),SORT_REGULAR),'repair_order_id','');
		$enquiry_images = array_filter_by_value(array_unique(array_column_multi($job_card, array('enquiry_image_id','enquiry_image')),SORT_REGULAR),'enquiry_image_id','');
		$job_card = $job_card[0];
		$removeKeys=array('image','image_id','repair_order_id','parts_name','customer_request','sa_remarks','labour_price','parts_price','total_price','enquiry_image_id','enquiry_image');
		foreach($removeKeys as $key) {
		   unset($job_card[$key]);
		}
		$job_card['images_data']=$job_card_images;
		$job_card['repair_orders']=$repair_orders;
		$job_card['enquiry_images'] = $enquiry_images;
  	}
  	return $job_card;

  }

}// end of MY_Controller class

// include other controllers that extent My_controller
require_once 'Rest_Controller.php';
?>
