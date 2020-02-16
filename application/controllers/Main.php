<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Main extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->load->model('M_Auth');
		$this->load->model('M_Email');
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
			'password' 	=> md5($password),
			'active_status' => 'active'
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
	function pendaftaran_berhasil($message){
		$data = [
			'message' => $message
		];
		$this->load->view('auth/Pendaftaran_berhasil', $data);
	}
	function auth_register(){
		$account = [
			'npm' => $this->input->post('npm'),
			'namaLengkap' => $this->input->post('namaLengkap'),
			'email'	=> $this->input->post('email'),
			'password' => md5($this->input->post('password')),
			'email_verification_code' => md5($this->input->post('email'))
		];
		if($this->sendVerificatinEmail($this->input->post('email'),md5($this->input->post('email')))){
			if($this->M_Auth->try($account)){
				$message = 'Pendaftaran Berhasil, silahkan cek email untuk konfirmasi!';
			}
			{
				$message = 'Pendaftaran gagal, silahkan coba ulang';
			}	
		}
		else {
			$message = 'Pendaftaran gagal, silahkan coba lagi';
		}
		$this->pendaftaran_berhasil($message);
	}

	function verify($verificationText=NULL){  
		$noRecords = $this->M_Email->verifyEmailAddress($verificationText);  
		if ($noRecords > 0){
		 	$error =  "Email berhasil diverifikasi!"; 
		}else{
		 	$error = "Maaf kami gagal memverifikasi email anda!"; 
		}
		$data['errormsg'] = $error; 
		$this->load->view('auth/verifikasi_berhasil', $data);   
	}

	function sendVerificatinEmail($email,$verificationText){
        $this->load->library('email');
        $config = Array(
            'protocol' => 'smtp',
            'smtp_host' => 'ssl://mail.labkompunsika.com',
            'smtp_port' => 465,
            'smtp_user' => 'admin@labkompunsika.com', // change it to yours
            'smtp_pass' => 'UNSIKAJAYA', // change it to yours
            'mailtype' => 'html',
            'charset' => 'iso-8859-1',
            'wordwrap' => TRUE
        );
        
        $this->load->library('email', $config);
        $this->email->set_newline("\r\n");
        $this->email->from('admin@labkompunsika.com', "Admin Asisten Laboratorium");
        $this->email->to($email);  
        $this->email->subject("Verification Email");
        $this->email->message("Dear User, \nPlease click on below URL or paste into your browser to verify your Email Address\n\n http://elearning.labkompunsika.com/verify/".$verificationText."\n"."\n\nThanks\nAdmin Team");
        $this->email->send();
    }
	   


}

/* End of file Main.php */
/* Location: ./application/controllers/Main.php */
