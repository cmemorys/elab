<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Materi extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		//Do your magic here
		$this->load->helper(array('form', 'url'));
		$this->load->model('M_Materi');
		$this->load->model('M_Aslab');
	}

	public function List()
	{
		$data = [
			'title' => 'Dashboard - List Materi | ELABLTE',
			'content' => 'aslab/materi/list',
			'dtable' => 'aslab/materi/dtable_get_list'
		];
		$this->load->view('template/template', $data, FALSE);
	}
	function dtable_get_list(){
		$list = $this->M_Materi->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $field) {
            $no++;
            $namaMK = $this->detail($field->idMkuliah,'mk');
            $row = array(); 
            $row[] = $no;
            $row[] = $namaMK[0]['namaMKuliah'];;
            $row[] = $field->dosen;
            $row[] = '
            	<a class="btn btn-sm btn-danger m-1" href="javascript:void(0)" title="Hapus" onclick="deleteKelas('."'".$field->idMateri."'".')"><i class="fa fa-trash"></i></a>
            	<a class="btn btn-sm btn-primary m-1" href="'.base_url().'uploads/materi/'.$field->namaFile.'" title="Download"><i class="fa fa-download"></i></a>
        			';
 
            $data[] = $row;
        }
 
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->M_Materi->count_all(),
            "recordsFiltered" => $this->M_Materi->count_filtered(),
            "data" => $data,
        );
        //output dalam format JSON
        echo json_encode($output);
	}

	function dtable_drop_row($id){
		if($this->M_Materi->drop_Materi($id)){
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

	public function upload(){
		$data = [
			'title' => 'Dashboard - Upload Materi | ELABLTE',
			'content' => 'aslab/materi/upload',
			'listMataKuliah' => $this->M_Aslab->get_MataKuliah()
		];
		$this->load->view('template/template', $data, FALSE);
	}

	function upload_proses(){
		$nmfile = "materi_".time().rand(1,255);
        $config['upload_path'] = './uploads/materi/';//path folder
        $config['allowed_types'] = 'pdf|docx'; //type yang dapat diakses bisa anda sesuaikan
        $config['file_name'] = $nmfile;
        $config['remove_spaces'] = true;
        $this->load->library('upload',$config);


        if(!empty($_FILES['file_materi']['name']))
        {
            if(!$this->upload->do_upload('file_materi'))
            {
                $this->upload->display_errors();
            }  
            else
            {
                $upload_data = $this->upload->data();
                $gambar = $upload_data['file_name'];
            }
        }

        $idMKuliah	= $this->input->post('idMKuliah');
        $dosen		= $this->input->post('dosen');
        $namaFile	= $gambar;

        $tambahData = [
        	'idMKuliah' => $idMKuliah,
        	'dosen'		=> $dosen,
        	'namaFile'	=> $namaFile
        ];

        if($this->M_Materi->add_Materi($tambahData)){
        	redirect(base_url('aslab/materi/list'));
        }
        else {
        	redirect(base_url('aslab/materi/upload'));
        }
	}


}

/* End of file Materi.php */
/* Location: ./application/controllers/aslab/Materi.php */
?>