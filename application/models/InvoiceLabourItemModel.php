<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class InvoiceLabourItemModel extends MY_Model {

	protected $table = 'invoice_labour_items';

	public function __construct()
	{
	    parent::__construct();
	}

	public function deleteItems($invoice_id,$labour_items_ids){
		$this->db->where('invoice_id',$invoice_id);
		$this->db->where_not_in('id',$labour_items_ids);
		$this->db->delete($this->table);
	}

}
?>