<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class icoemergencia extends CI_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->model('Reportes_emergmodel');
		if(!$this->session->userdata("login")){
			redirect(base_url());
		}
	}


public function index()
	{
		$data =  array(
			'years' => $this->Reportes_emergmodel->years(),
			'excelente' => $this->Reportes_emergmodel->rowCount(),
			'bueno' => $this->Reportes_emergmodel->RowCountbueno(),
			'regular' => $this->Reportes_emergmodel->RowCountRegular(),
			'pesimo' => $this->Reportes_emergmodel->RowCountPesimo(),
			'malo' => $this->Reportes_emergmodel->RowCountMalo(),
		//	'cantidad'=>$this->Reportes_model->rowCount(),
		
			
		 );
		$this->load->view('layouts/header');
		$this->load->view('layouts/aside');
		$this->load->view('reportes/emergencia',$data);
		$this->load->view('layouts/footer');
	
		//$this->load->view('layouts/footer');
	
	}

	public function getData(){
		$year = $this->input->post("year");
		$resultados = $this->Reportes_model->total($year);
		echo json_encode($resultados);
	}

}