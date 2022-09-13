<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Custom404 extends CI_Controller {
	public function index()
	{
		$this ->load->view('backend/error404');
	}
}
