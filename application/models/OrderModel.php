<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class OrderModel extends MY_Model {

	protected $table = 'placed_orders';

	public function __construct()
	{
	    parent::__construct();
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

		$order['order_item'] = $order_item;
		$order['order_car_images'] = $order_car_images;
		return $order;
	}

}