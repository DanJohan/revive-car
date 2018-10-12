<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class OrderItemModel extends MY_Model {

	protected $table = 'order_items';

	public function __construct()
	{
	    parent::__construct();
	}

}
