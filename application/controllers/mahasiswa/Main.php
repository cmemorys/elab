<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Main extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('M_HasilTugas');
		$this->load->model('M_Aslab');
	}

	public function index()
	{
		$data = [
			'title' => 'Dashboard | ELABLTE',
			'content' => 'mahasiswa/main',
			'dtable' => 'mahasiswa/dtable_get_list'
		];
		$this->load->view('template/template', $data, FALSE);
	}

	function dtable_get_list(){
		$list = $this->M_HasilTugas->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $field) {
        	if($field->npm == $this->session->npm){
        		$no++;
	            $row = array(); 
	            $row[] = $no;
	            $row[] = $this->detail($field->idKelas,'kl');
	            $row[] = $field->tanggalKirim;
	            $row[] = '
	            	<a class="btn btn-sm btn-danger m-1" href="javascript:void(0)" title="Hapus" onclick="deleteTugas('."'".$field->id."'".')"><i class="fa fa-trash"></i></a>
	            	<a class="btn btn-sm btn-primary m-1" href="'.base_url().'uploads/tugas/'.$field->namaFile.'" title="Download"><i class="fa fa-download"></i></a>
	        			';
	 
	            $data[] = $row;
        	}
        }
 
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->M_HasilTugas->count_all(),
            "recordsFiltered" => $this->M_HasilTugas->count_filtered(),
            "data" => $data,
        );
        //output dalam format JSON
        echo json_encode($output);
	}

	function dtable_drop_row($id){
		if($this->M_HasilTugas->drop_HasilTugas($id)){
			return true;
		}
	}

	function detail($id, $action){
		$data = 0;
		if($action == 'mk'){
			$data = $this->M_Aslab->get_nmMataKuliah($id);
		}
		elseif ($action == 'as') {
			$data = $this->M_Aslab->get_nmAslab($id);
		}
		elseif ($action == 'kl') {
			$kelas = $this->M_Aslab->get_kelasById($id);
			$namaMKul = $this->M_Aslab->get_nmMataKuliah($kelas[0]['idMataKuliah']);
			$data = $namaMKul[0]['namaMKuliah'].' '.$kelas[0]['tahun'].' '.$kelas[0]['hurufKelas'];
		}
		return $data;
	}


}

/* End of file Main.php */
/* Location: ./application/controllers/Mahasiswa/Main.php */
?>