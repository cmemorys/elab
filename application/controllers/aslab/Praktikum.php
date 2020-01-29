<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Praktikum extends CI_Controller {

    public function __construct()
	{
		parent::__construct();
        $this->load->model('M_Praktikum');
        $this->load->model('M_Aslab');
	}

    function list(){
		$data = [
			'title' => 'Dashboard - List Praktikum | ELABLTE',
			'content' => 'aslab/praktikum/list',
			'dtable' => 'aslab/praktikum/dtable_get_list'
		];
		$this->load->view('template/template', $data, FALSE);
    }

    function dtable_get_list(){
		$list = $this->M_Praktikum->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $field) {
            $no++;
            $row = array(); 
            $row[] = $no;
            $row[] = $field->namaMKuliah;
            $row[] = $field->jurusan;
            $data[] = $row;
        }
 
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->M_Praktikum->count_all(),
            "recordsFiltered" => $this->M_Praktikum->count_filtered(),
            "data" => $data,
        );
        //output dalam format JSON
        echo json_encode($output);
    }
    
    public function tambah()
	{
		$data = [
			'title' => 'Dashboard - Tambah Matkul | ELABLTE',
			'content' => 'aslab/praktikum/tambah'
		];
		$this->load->view('template/template', $data, FALSE);
    }
    
    function tambah_proses()
	{
		$data =$_POST;
		if($this->M_Aslab->create_praktikum($data)){
			redirect(base_url('aslab/praktikum/list'));
		}
	}

}

/* End of file Praktikum.php */
