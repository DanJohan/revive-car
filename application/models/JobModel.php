<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

	class JobModel extends MY_Model {

		protected $table = 'jobs';

		public function __construct()
		{
		    parent::__construct();
		}
	}
