
<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class NotificationModel extends MY_Model {
	protected $table = 'notifications';
	public function __construct()
	{
	    parent::__construct();
	}
	public function getByUserId($user_id) {
		$this->db->select('*');
		$this->db->from($this->table);
		$this->db->where(array('user_id'=>$user_id));
		$this->db->order_by('id','DESC');
		$query = $this->db->get();
		$result = $query->result_array();
		return (!empty($result))? $result : null;
	}
}// end of class