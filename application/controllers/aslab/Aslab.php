<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Aslab extends CI_Controller {

    public function __construct()
	{
		parent::__construct();
        $this->load->model('M_Aslab');
        $this->load->model('M_Auth');
	}

    function list(){
		$data = [
			'title' => 'Dashboard - List Aslab | ELABLTE',
			'content' => 'aslab/aslab/list',
			'dtable' => 'aslab/aslab/dtable_get_list'
		];
		$this->load->view('template/template', $data, FALSE);
    }

    function dtable_get_list(){
		$list = $this->M_Auth->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $field) {
            $no++;
            $row = array(); 
            $row[] = $no;
            $row[] = $field->namaLengkap;
            $row[] = $field->username;
            $data[] = $row;
        }
 
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->M_Auth->count_all(),
            "recordsFiltered" => $this->M_Auth->count_filtered(),
            "data" => $data,
        );
        //output dalam format JSON
        echo json_encode($output);
    }
    
    public function tambah()
	{
		$data = [
			'title' => 'Dashboard - Tambah Aslab | ELABLTE',
			'content' => 'aslab/aslab/tambah'
		];
		$this->load->view('template/template', $data, FALSE);
    }
    
    function tambah_proses()
	{
        $data =$_POST;
        $data['password'] = md5($data['password']);
		if($this->M_Auth->tryAslab($data)){
			redirect(base_url('aslab/aslab/list'));
		}
	}

}

/* End of file Praktikum.php */
