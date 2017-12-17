<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Not_found404 extends CI_Controller {

	public function index()
	{
		$this->load->view('view_404');
	}

}