<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class InvoiceModel extends MY_Model {

	protected $table = 'invoices';

	public function __construct()
	{
	    parent::__construct();
	}

	public function getInvoiceById($id,$manager_id=null){
		$this->db->select('i.*, il.id AS invoice_labour_id, il.item AS invoice_labour_item, il.hour AS invoice_labour_hour, il.rate AS invoice_labour_rate, il.cost AS invoice_labour_cost, il.gst AS invoice_labour_gst, il.gst_amount AS invoice_labour_gst_amount, il.total AS invoice_labour_total, ip.id AS invoice_parts_id, ip.item AS invoice_parts_item, ip.quantity AS invoice_parts_quantity, ip.cost AS invoice_parts_cost, ip.gst AS invoice_parts_gst, ip.gst_amount as invoice_parts_gst_amount,ip.total AS invoice_parts_total');
		$this->db->from($this->table.' AS i');
		$this->db->join('invoice_labour_items AS il','i.id=il.invoice_id','left');
		$this->db->join('invoice_parts_items AS ip','i.id=ip.invoice_id','left');
		$this->db->where('i.id',$id);
		if($manager_id) {
			$this->db->where('i.created_by',$manager_id);
		}
		$query = $this->db->get();
		$result = $query->result_array();
		return (!empty($result))? $result : false;
	}
}

?>