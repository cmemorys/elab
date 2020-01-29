<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Aslabloginform extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('M_Auth');
	}

	public function index()
	{
		$this->load->view('Auth/loginaslab', FALSE);
	}

	function auth_login(){
		$username	= $this->input->post('username');
		$password 	= $this->input->post('password');
		$level		= 'aslab';

		$account = [
			'username'	=> $username,
			'password' 	=> md5($password)
		];
		
		// Untuk membuat akun
		// $this->Auth->try($account);
		
		if($this->M_Auth->checkAslab($account)->num_rows() > 0){
			$getDataAslab = $this->M_Auth->checkAslab($account)->result_array();
			$array = array(
				'npm' 		=> $username,
				'level'	    => $level,
				'id'		=> $getDataAslab[0]['idAslab']
			);
			
			$this->session->set_userdata($array);
			$this->auth_super();
		}
		else {
			$this->session->set_flashdata('gagallogin', 'andagagallogin');
			redirect(base_url('Aslabloginform'));
		}

	}
	function auth_super(){
		if (isset($this->session->level)) {
			if($this->session->level == 'mahasiswa'){
				redirect(base_url('mahasiswa/Main'));
			}
			elseif($this->session->level == 'aslab'){
				redirect(base_url('aslab/Main'));
			}	
		}
		else {
			redirect(base_url());
		}
	}

	function stop_auth(){
		$this->session->sess_destroy();
		redirect(base_url());
	}

	function try_account(){
		$account = [
			'username' => 'chimchim',
			'namaLengkap' => 'CHIMCHIM',
			'password' => md5('memory543')
		];
		$this->M_Auth->tryAslab($account);
	}

}

/* End of file Aslabloginform.php */
/* Location: ./application/controllers/Aslabloginform.php */

?>