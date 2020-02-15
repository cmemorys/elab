<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Main extends CI_Controller {

	public function index()
	{
		$data = [
			'title' => 'Dashboard | ELABLTE',
			'content' => 'aslab/Main'
		];
		$this->load->view('template/template', $data, FALSE);
	}

}

/* End of file Main.php */
/* Location: ./application/controllers/aslab/Main.php */