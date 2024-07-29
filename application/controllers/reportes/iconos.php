<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class iconos extends CI_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->model('Reportes_model');
		if(!$this->session->userdata("login")){
			redirect(base_url());
		}
	}


public function index()
	{
		$data =  array(
			'years' => $this->Reportes_model->years(),
			'excelente' => $this->Reportes_model->rowCount(),
			'bueno' => $this->Reportes_model->RowCountbueno(),
			'regular' => $this->Reportes_model->RowCountRegular(),
			'pesimo' => $this->Reportes_model->RowCountPesimo(),
			'malo' => $this->Reportes_model->RowCountMalo(),
		//	'cantidad'=>$this->Reportes_model->rowCount(),
		
			
		 );
		$this->load->view('layouts/header');
		$this->load->view('layouts/aside');
		$this->load->view('reportes/iconos',$data);
		$this->load->view('layouts/footer');
	
		//$this->load->view('layouts/footer');
	
	}

	public function getData(){
		$year = $this->input->post("year");
		$resultados = $this->Reportes_model->total($year);
		echo json_encode($resultados);
	}

}