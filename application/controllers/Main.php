<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Main extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->load->model('M_Auth');
	}

	public function index()
	{
		$this->auth_super();
		$this->load->view('auth/Login', FALSE);
	}

	function auth_login(){
		$npm	 	= $this->input->post('npm');
		$password 	= $this->input->post('password');
		$level		= 'mahasiswa';

		$account = [
			'npm' 		=> $npm,
			'password' 	=> md5($password)
		];
		
		// Untuk membuat akun
		// $this->Auth->try($account);
		
		if($this->M_Auth->check($account)->num_rows() > 0){
			$array = array(
				'npm' 		=> $npm,
				'level'	    => $level
			);
			
			$this->session->set_userdata($array);
			$this->auth_super();
		}
		else {
			$this->session->set_flashdata('gagallogin', 'andagagallogin');
			redirect(base_url());
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
			return true;
		}
	}

	function stop_auth(){
		$this->session->sess_destroy();
		redirect(base_url());
	}

	function try_account(){
		$account = [
			'npm' => '1610630062',
			'namaLengkap' => 'Christ Memory',
			'email'	=> 'christmemory5@gmail.com',
			'password' => md5('memory543')
		];
		$this->M_Auth->try($account);
	}
	function pendaftaran(){
		$this->load->view('auth/Pendaftaran', FALSE);
	}
	function pendaftaran_berhasil(){
		$this->load->view('auth/Pendaftaran_berhasil', FALSE);
	}
	function auth_register(){
		$account = [
			'npm' => $this->input->post('npm'),
			'namaLengkap' => $this->input->post('namaLengkap'),
			'email'	=> $this->input->post('email'),
			'password' => md5($this->input->post('password'))
		];
		if($this->M_Auth->try($account)){
			redirect(base_url('main/pendaftaran_berhasil'));
		}
	}


}

/* End of file Main.php */
/* Location: ./application/controllers/Main.php */
