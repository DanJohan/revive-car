<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class InvoiceModel extends MY_Model {

	protected $table = 'invoices';

	public function __construct()
	{
	    parent::__construct();
	}

	public function getAllInvoice($order_id,$manager_id){
		$this->db->select('i.*, o.hash');
		$this->db->from($this->table.' AS i');
		$this->db->join('placed_orders as o','i.order_id=o.id');
		$this->db->where('i.order_id',$order_id);
		$this->db->where('i.created_by',$manager_id);
		$query = $this->db->get();
		$result = $query->result_array();
		return (!empty($result))? $result : false;
	}

	// used in w_crm, api web
	public function getInvoiceById($id,$manager_id=null){
		$this->db->select('i.*,o.hash,ii.id as item_id,ii.item_name, ii.price');
		$this->db->from($this->table.' AS i');
		$this->db->join('placed_orders as o','i.order_id=o.id');
		$this->db->join('invoice_items AS ii','i.id=ii.invoice_id','left');
		$this->db->where('i.id',$id);
		if($manager_id) {
			$this->db->where('i.created_by',$manager_id);
		}
		$query = $this->db->get();
		$result = $query->result_array();
		return (!empty($result))? $result : false;
	}

	// user in api
	public function getInvoiceByUserId($user_id){
		$this->db->select('i.id,i.invoice_number, i.client_name,i.client_phone,i.client_email,i.client_address,i.vehicle_reg_no,i.vehicle_brand_name,i.vehicle_model_name,i.vehicle_vin_no,i.vehicle_kms,i.date_created,i.due_date,i.sa_name,i.gst,i.gst_amount,i.discount_amount,i.sub_total,i.total_amount,i.total_pay_amount,i.notes,i.paid,i.created_at,ii.id as item_id,ii.item_name,ii.price');
		$this->db->from($this->table.' AS i');
		$this->db->join('invoice_items AS ii','i.id=ii.invoice_id','left');
		$this->db->where('i.user_id',$user_id);
		$this->db->where('i.fwd_to_customer',1);
		$query = $this->db->get();
		$result = $query->result_array();
		return (!empty($result))? $result : false;
	}
}

?>
