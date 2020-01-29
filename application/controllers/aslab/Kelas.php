<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kelas extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->load->model('M_Aslab');
		$this->load->model('M_Tugas');
	}

	public function List()
	{
		$data = [
			'title' => 'Dashboard - List Kelas | ELABLTE',
			'content' => 'aslab/kelas/list',
			'dtable' => 'aslab/kelas/dtable_get_list'
		];
		$this->load->view('template/template', $data, FALSE);
	}
	function dtable_get_list(){
		$list = $this->M_Aslab->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $field) {
            $no++;
            $row = array(); 
			$namaMK = $this->detail($field->idMataKuliah,'mk');
			$namaJurusan = $this->detail($field->idMataKuliah,'jr');
            $namaAS = $this->detail($field->idAslab,'as');
            $row[] = $no;
            $row[] = $namaMK[0]['namaMKuliah'].' ('.$namaJurusan[0]['jurusan'].')';
            $row[] = $field->semester;
            $row[] = $field->tahun;
            $row[] = $field->hurufKelas;
            $row[] = $namaAS[0]['namaLengkap'];
            $row[] = '
            	<a class="btn btn-sm btn-danger m-1" href="javascript:void(0)" title="Hapus" onclick="deleteKelas('."'".$field->idKelas."'".')"><i class="fa fa-trash"></i></a>
        			';
 
            $data[] = $row;
        }
 
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->M_Aslab->count_all(),
            "recordsFiltered" => $this->M_Aslab->count_filtered(),
            "data" => $data,
        );
        //output dalam format JSON
        echo json_encode($output);
	}

	function detail($id, $action){
		$data = 0;
		if($action == 'mk'){
			$data = $this->M_Aslab->get_nmMataKuliah($id);
		}
		elseif ($action == 'as') {
			$data = $this->M_Aslab->get_nmAslab($id);
		}
		elseif ($action == 'jr') {
			$data = $this->M_Aslab->get_nmJurusanKuliah($id);
		}
		elseif ($action == 'kl') {
			$kelas = $this->M_Aslab->get_kelasById($id);
			$namaMKul = $this->M_Aslab->get_nmMataKuliah($kelas[0]['idMataKuliah']);
			$data = $namaMKul[0]['namaMKuliah'].' '.$kelas[0]['tahun'].' '.$kelas[0]['hurufKelas'];
		}
		return $data;
	}

	function dtable_drop_row($id){
		if($this->M_Aslab->drop_kelas($id)){
			return true;
		}
	}

	public function Buat()
	{
		$data = [
			'title' => 'Dashboard - Buat Kelas | ELABLTE',
			'content' => 'aslab/kelas/buat',
			'listMataKuliah' => $this->M_Aslab->get_MataKuliah()
		];
		$this->load->view('template/template', $data, FALSE);
	}
	function Buat_proses()
	{
		$data =$_POST;
		$data['idAslab'] = $this->session->id;
		if($this->M_Aslab->create_kelas($data)){
			redirect(base_url('aslab/kelas/list'));
		}
	}

	public function Tugas()
	{
		$lk = $this->M_Aslab->get_kelas();
		$listKelas = [];
		$no = 0;
		foreach ($lk as $value) {
			$namaMKul = $this->detail($value['idMataKuliah'],'mk');
			$namaMKul = $namaMKul[0]['namaMKuliah'].' '.$value['tahun'].$value['hurufKelas'];
			$listKelas[$no] = [
				'id' => $value['idKelas'],
				'nama' => $namaMKul
			];
			$no++;
		}
		$data = [
			'title' => 'Dashboard - Tugas Kelas | ELABLTE',
			'content' => 'aslab/kelas/tugas',
			'dtable' => 'aslab/kelas/dtable_get_list_tugas',
			'listKelas' => $listKelas
		];
		$this->load->view('template/template', $data, FALSE);
	}
	function dtable_get_list_tugas(){
		$list = $this->M_Tugas->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $field) {
            $no++;
            $row = array(); 

            $row[] = $no;
            $row[] = $this->detail($field->idKelas,'kl');
            $row[] = $field->kodeTugas;
            $row[] = $field->pertemuan;
            $row[] = $field->deadLine;
            $row[] = $field->dibuat;
            $row[] = '
            	<a class="btn btn-sm btn-danger m-1" href="javascript:void(0)" title="Hapus" onclick="deleteTugas('."'".$field->idTugas."'".')"><i class="fa fa-trash"></i></a>
            	<a class="btn btn-sm btn-primary m-1" href="javascript:void(0)" title="Detail" onclick="viewTugas('."'".$field->idTugas."'".')"><i class="fa fa-eye"></i></a>
        			';
 
            $data[] = $row;
        }
 
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->M_Tugas->count_all(),
            "recordsFiltered" => $this->M_Tugas->count_filtered(),
            "data" => $data,
        );
        //output dalam format JSON
        echo json_encode($output);
	}
	function dtable_drop_row_tugas($id){
		if($this->M_Tugas->drop_tugas($id)){
			return true;
		}
	}
	function Tugas_proses(){
		$data = $this->input->post();
		$data['dibuat'] = date('Y-m-d H:i:s');
		if($this->M_Tugas->create_tugas($data)){
			redirect(base_url('aslab/kelas/tugas'));
		}
	}
	function get_list_tugas($idTugas){
		if($this->M_Tugas->get_list_tugas($idTugas)){
			$listTugas = $this->M_Tugas->get_list_tugas($idTugas);
			$message = [
				'status' => true,
				'message' => $listTugas
			];
			echo json_encode($listTugas);
		}
		else {
			echo json_encode('false');
		}
	}


}

/* End of file Kelas.php */
/* Location: ./application/controllers/aslab/Kelas.php */
