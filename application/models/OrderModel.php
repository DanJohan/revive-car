<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class OrderModel extends MY_Model {

	protected $table = 'placed_orders';

	public function __construct()
	{
	    parent::__construct();
	}

	private function getOrderColumn(){
		return array('o.order_no','o.user_id','o.pick_up_date', 'o.pick_up_time', 'o.net_pay_amount', 'o.paid', 'o.status','o.created_at');
	}

	public function getOrders($start,$limit,$orders,$search) {
		$this->db->select('SQL_CALC_FOUND_ROWS o.id, o.order_no,o.user_id,o.pick_up_date, o.pick_up_time, o.net_pay_amount, o.paid, o.status,o.created_at',false);
		$this->db->from($this->table.' AS o');
		if(!empty($search['value'])){
			$this->db->or_like(
				array(
					'o.order_no'=>$search['value'],
					'o.user_id' =>$search['value'],
					'o.pick_up_date' =>$search['value'],
					'o.pick_up_time' => $search['value'],
					'o.net_pay_amount'=>$search['value'],
					'o.paid' => $search['value'],
					'o.status' => $search['value'],
					'o.created_at' => $search['value'],
				)
			);
		}
	
		$columns = $this->getOrderColumn();
		//dd($columns);
		foreach ($columns as $c_index => $column) {
			if($orders[0]['column'] == $c_index) {
				$this->db->order_by($column,$orders[0]['dir']);
			}
		}

		$this->db->limit($limit,$start);
		$query = $this->db->get();
		$result = $query->result_array();
		return (!empty($result))? $result :false;
	}

	// used in api
	public function getById($order_id) {
		$this->db->select('o.id, o.order_no,sc.name as service_type,scl.name as service_center,o.loaner_vehicle,o.pick_up_date, o.pick_up_time, o.sub_total, o.discount_amount, o.net_pay_amount,o.lv_reg_no,o.paid,pt.name as payment_type, o.status,o.created_at, oi.id as order_item_id,oi.order_id as order_item_order_id ,oi.service_id,,oi.name as service_name,oi.price,cd.name as customer_name, cd.email as customer_email, cd.phone as customer_phone, cd.address as customer_address,cd.latitude, cd.longitude,c.registration_no,cb.brand_name,cm.model_name,u.profile_image,oci.id AS car_image_id,oci.image AS car_image');

		$this->db->from($this->table." AS o");
		$this->db->join('order_items AS oi', 'o.id = oi.order_id');
		$this->db->join('customer_details AS cd', 'o.id = cd.order_id');
		$this->db->join('services_category AS sc', 'o.service_type = sc.id');
		$this->db->join('service_centers AS scl', 'o.service_center = scl.id');
		$this->db->join('payment_types AS pt', 'o.payment_type_id=pt.id', 'left');
		$this->db->join('cars AS c','o.car_id =  c.id');
		$this->db->join('car_brands AS cb','c.brand_id =  cb.id');
		$this->db->join('car_models AS cm','c.model_id =  cm.id');
		$this->db->join('order_car_images AS oci','o.id =  oci.order_id','left');
		$this->db->join('users AS u','o.user_id =  u.id');
		$this->db->where('o.id',$order_id);
		$this->db->where('o.status !=',2);
		$result = $this->db->get()->result_array();
		return $result;
	}

	// used in api
	public function getOrdersByUser($user_id){
		$this->db->select('o.id, o.order_no,sc.name as service_type,scl.name as service_center,o.loaner_vehicle,o.pick_up_date, o.pick_up_time, o.sub_total, o.discount_amount, o.net_pay_amount,o.paid,pt.name as payment_type, o.status,o.created_at, oi.id as order_item_id,oi.order_id as order_item_order_id ,oi.service_id,,oi.name as service_name,oi.price,cd.name as customer_name, cd.email as customer_email, cd.phone as customer_phone, cd.address as customer_address,cd.latitude, cd.longitude,c.registration_no,cb.brand_name,cm.model_name');
		$this->db->from($this->table." AS o");
		$this->db->join('order_items AS oi', 'o.id = oi.order_id');
		$this->db->join('customer_details AS cd', 'o.id = cd.order_id');
		$this->db->join('services_category AS sc', 'o.service_type = sc.id');
		$this->db->join('service_centers AS scl', 'o.service_center = scl.id');
		$this->db->join('payment_types AS pt', 'o.payment_type_id=pt.id' ,'left');
		$this->db->join('cars AS c','o.car_id =  c.id');
		$this->db->join('car_brands AS cb','c.brand_id =  cb.id');
		$this->db->join('car_models AS cm','c.model_id =  cm.id');
		$this->db->where('o.user_id',$user_id);
		$this->db->where('o.status !=',2);
		$result = $this->db->get()->result_array();
		return $result;
	}

	// used in crm
	public function getOrderById($id){
		$this->db->select('o.id, o.order_no,sc.name as service_type,scl.name as service_center,o.loaner_vehicle,o.pick_up_date, o.pick_up_time, o.sub_total, o.discount_amount, o.net_pay_amount,o.paid,pt.name as payment_type, o.status,o.created_at, oi.id as order_item_id,oi.order_id as order_item_order_id ,oi.service_id,,oi.name as service_name,oi.price,cd.name as customer_name, cd.email as customer_email, cd.phone as customer_phone, cd.address as customer_address,cd.latitude, cd.longitude,c.registration_no,cb.brand_name,cm.model_name,oci.image AS car_image');

		$this->db->from($this->table." AS o");
		$this->db->join('order_items AS oi', 'o.id = oi.order_id');
		$this->db->join('customer_details AS cd', 'o.id = cd.order_id');
		$this->db->join('services_category AS sc', 'o.service_type = sc.id');
		$this->db->join('service_centers AS scl', 'o.service_center = scl.id');
		$this->db->join('payment_types AS pt', 'o.payment_type_id=pt.id','left');
		$this->db->join('cars AS c','o.car_id =  c.id');
		$this->db->join('car_brands AS cb','c.brand_id =  cb.id');
		$this->db->join('car_models AS cm','c.model_id =  cm.id');
		$this->db->join('order_car_images AS oci','o.id =  oci.order_id','left');
		$this->db->where('o.id',$id);
		$result = $this->db->get()->result_array();
		return $result;
	}


	public function arrangeOrderData($order= array()){

		$order_item_keys = array('order_item_id', 'order_item_order_id', 'service_id', 'service_name','price');
		$order_item = array_filter_by_value(array_unique(array_column_multi($order,$order_item_keys),SORT_REGULAR),'order_item_id','');
		
		$image_key = array('car_image','car_image_id');
		$order_car_images =array_filter_by_value(array_unique(array_column_multi($order,$image_key),SORT_REGULAR),'car_image_id','');
		if(!empty($order_car_images)){
			foreach ($order_car_images as $index => &$order_car_image) {
				if($order_car_image['car_image']){
					$order_car_image['car_image'] = base_url().'uploads/app/'.$order_car_image['car_image'];
				}
			}
		}

		$order = $order[0];
		$removeKeys = array_merge($order_item_keys, $image_key);
		foreach($removeKeys as $key) {
		   unset($order[$key]);
		}

		$order['order_item'] = array_values($order_item);
		$order['order_car_images'] = $order_car_images;
		return $order;
	}

	public function getOrderNotification() {
		$this->db->select('o.id,o.loaner_vehicle,o.created_at,cb.brand_name,cm.model_name,u.name');
		$this->db->from($this->table.' AS o');
		$this->db->join('cars AS c','o.car_id = c.id');
		$this->db->join('car_brands AS cb','c.brand_id = cb.id');
		$this->db->join('car_models AS cm','c.model_id = cm.id');
		$this->db->join('users AS u','o.user_id = u.id');
		$this->db->where('o.admin_seen',0);
		$this->db->order_by('o.id','DESC');
		$query = $this->db->get();
		$result = $query->result_array();
		return (!empty($result))? $result : false;
	}

	public function markOrderSeen($id){
		$this->db->where(array('id'=>$id));
		$this->db->update($this->table, array('admin_seen'=>1));
	}

	public function getWorkshopOrderNotification($manager_id) {
		$this->db->select('o.id,o.hash,o.loaner_vehicle,o.created_at,cb.brand_name,cm.model_name,u.name');
		$this->db->from($this->table.' AS o');
		$this->db->join('cars AS c','o.car_id = c.id');
		$this->db->join('car_brands AS cb','c.brand_id = cb.id');
		$this->db->join('car_models AS cm','c.model_id = cm.id');
		$this->db->join('users AS u','o.user_id = u.id');
		$this->db->where('o.workshop_seen=0 AND o.assign_workshop_id='.$manager_id);
		$this->db->order_by('o.id','DESC');
 		$query = $this->db->get();
		$result = $query->result_array();
		return (!empty($result))? $result : false;
	}
	
	public function markOrderWorkshopSeen($id){
		$this->db->where(array('id'=>$id));
		$this->db->update($this->table, array('workshop_seen'=>1));
	}

}
