<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class SequenceModel extends MY_Model {

	protected $table = 'sequences';

	public function __construct()
	{
	    parent::__construct();
	}
}