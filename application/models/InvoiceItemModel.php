<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class InvoiceItemModel extends MY_Model {

	protected $table = 'invoice_items';

	public function __construct()
	{
	    parent::__construct();
	}
}//end of class
?>
