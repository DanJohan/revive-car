<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class InvoicePartsItemModel extends MY_Model {

	protected $table = 'invoice_parts_items';

	public function __construct()
	{
	    parent::__construct();
	}
}
?>