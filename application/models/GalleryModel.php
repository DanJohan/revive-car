<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class GalleryModel extends MY_Model {

	protected $table = 'gallery_images';

	public function __construct()
	{
	    parent::__construct();
	}

}
