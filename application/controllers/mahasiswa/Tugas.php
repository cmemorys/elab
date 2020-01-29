<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tugas extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->load->model('M_HasilTugas');
	}

	public function upload()
	{
		$data = [
			'title' => 'Dashboard - Upload Tugas | ELABLTE',
			'content' => 'mahasiswa/tugas/upload',
			'js' => 'mahasiswa/tugas/js'
		];
		$this->load->view('template/template', $data, FALSE);
	}

	function cekKode($kode){
		if($this->M_HasilTugas->cekKode($kode)){
			$kode = $this->M_HasilTugas->cekKode($kode);
			if(date('Y-m-d H:i:s') < $kode[0]['deadLine']){
				$message = [
					'status' => true,
					'message' => 'Kode ditemukan! Anda bisa mengirim tugas'
				];
				echo json_encode($message);
			}
			else {
				$message = [
					'status' => false,
					'message' => 'Anda sudah melewati waktu yang ditentukan'
				];
				echo json_encode($message);
			}
			
		}
		else{
			$message = [
				'status' => false,
				'message' => 'Kode tidak ditemukan'
			];
			echo json_encode($message);
		}
		// $dat = $this->M_HasilTugas->cekKode($kode);
		// echo json_encode($dat);
	}
	function cekKodeN($kode){
		if($this->M_HasilTugas->cekKode($kode)){
			$kode = $this->M_HasilTugas->cekKode($kode);
			if(date('Y-m-d H:i:s') < $kode[0]['deadLine']){
				$message = [
					'status' => true,
					'message' => 'Kode ditemukan! Anda bisa mengirim tugas'
				];
				return json_encode($message);
			}
			else {
				$message = [
					'status' => false,
					'message' => 'Anda sudah melewati waktu yang ditentukan'
				];
				return json_encode($message);
			}
			
		}
		else{
			$message = [
				'status' => false,
				'message' => 'Kode tidak ditemukan'
			];
			return json_encode($message);
		}
		// $dat = $this->M_HasilTugas->cekKode($kode);
		// echo json_encode($dat);
	}

	function upload_proses(){
		$detailTugas = $this->M_HasilTugas->get_detailTugas($this->input->post('idTugas'));
		if($detailTugas){
			$statusTugas = json_decode($this->cekKodeN($detailTugas[0]['idTugas']));
			if($statusTugas['status'] == true){
				$nmfile = "tugas_".time().rand(1,255);
				$config['upload_path'] = './uploads/tugas/';//path folder
				$config['allowed_types'] = 'pdf|docx|rar|zip'; //type yang dapat diakses bisa anda sesuaikan
				$config['file_name'] = $nmfile;
				$config['remove_spaces'] = true;
				$this->load->library('upload',$config);


				if(!empty($_FILES['file_tugas']['name']))
				{
					if(!$this->upload->do_upload('file_tugas'))
					{
						$this->upload->display_errors();
					}  
					else
					{
						$upload_data = $this->upload->data();
						$gambar = $upload_data['file_name'];
					}
				}
				

				$idTugas		= $detailTugas[0]['idTugas'];
				$idKelas		= $detailTugas[0]['idKelas'];
				$npm			= $this->session->npm;
				$tanggalKirim 	= date('Y-m-d H:i:s');
				$namaFile		= $gambar;


				$tambahData = [
					'idTugas' 		=> $idTugas,
					'idKelas'		=> $idKelas,
					'npm'			=> $npm,
					'tanggalKirim'	=> $tanggalKirim,
					'namaFile'		=> $namaFile
				];
				// var_dump($tambahData);
				if($this->M_HasilTugas->add_HasilTugas($tambahData)){
					redirect(base_url('mahasiswa/main'));
				}
				else {
					redirect(base_url('mahasiswa/tugas/upload'));
				}
			}
			
		}
		else {
			$this->session->set_flashdata('tidakbolehuploadtugas', 'tidakbolehuploadtugas');
			redirect(base_url('mahasiswa/tugas/upload'));
			
		}
	}

}

/* End of file Tugas.php */
/* Location: ./application/controllers/mahasiswa/Tugas.php */
?>