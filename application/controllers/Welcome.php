<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
		redirect('admin/auth/login');
		die;
		$this->load->view('user');
		
	}

	public function test(){
		if(!empty($_FILES) || $this->input->is_ajax_request()) {
			echo "here";
			dd($_POST['files'][0],false);
			dd($_FILES);

		}
		$this->load->view('test/file_upload');
	}

	public function testauth(){

		 // function authenticate() {
		    header('WWW-Authenticate: Basic realm="Sistema autentificaci�n UnoAutoSur"');
		    header('HTTP/1_0 401 Unauthorized');
		//    header("Status: 401 Access Denied"); 
		    echo "Unauthorized\n";
		    dd(getallheaders(),false);
		    dd($_SERVER);
		    exit;
		//  }

	}

	public function testHasH() {
		//dd("here");
		$factory = new RandomLib\Factory;
		$generator =$factory->getMediumStrengthGenerator();
		$randomInt = $generator->generateInt(100000, 999999);
		echo $randomInt,"<br>";
		echo $generator->generateString(3,'ABCDEFGHIJKLMNOPQRSTUVWXYZ');
	}

	public function insert_coupan(){
		for($i=2; $i<=1545;$i++) {
			$coupan []= array(
				'service_id'=>$i,
				'discount_value'=>'500.00',
				'valid_untill' => date('Y-m-d H:i:s'),
				'coupan_code' => 'REVIVE500',
				'created_at' => date('Y-m-d H:i:s')
			);
		}
		$this->db->insert_batch('services_discount',$coupan);
	}

	public function update_service(){
		die();
		for($i=16 ;$i<=17;$i++){
			for($j=1; $j<=107; $j++){
				if($j==45 || $j==67 || $j==83 || $j==100) {
					continue;
				}
				if($i==16){
					$category_id = 5;
				}else if($i==17){
					$category_id = 4;
				}

				$insert_data[] = array(
					'service_id'=>$i,
					'model_id' => $j,
					'category_id'=> $category_id,
					'price' => 14999,
					'created_at' =>date("Y-m-d H:i:s")
				);
				
				
			}
		}
		//dd($insert_data);
		$insert_id = $this->db->insert_batch('services',$insert_data);
	}
}// END OF CLASS
