<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Redashboard extends CI_Controller {
	public function __construct(){
		parent::__construct();
		
		if(!$this->session->userdata("login")){
			redirect(base_url());
		}

		$this->load->model('reports_model');
	}


public function index()
	{
		$data =  array(
			'cantpacientes' => $this->reports_model->rowCountPacientes(),
		    'cantratamientopag' => $this->reports_model->rowCountTratamientos(),
			 'cantratamientocob' => $this->reports_model->rowCountTratamientosCobrar(),
			'cantmedicos' => $this->reports_model->rowCountMedicos(),
			'years' => $this->reports_model->years(),
			// 'pesimo' => $this->Reportes_model->RowCountPesimo(),
			// 'malo' => $this->Reportes_model->RowCountMalo(),
			// 'cantidad'=>$this->Reportes_model->rowCount(),
		
			
		);
		$this->load->view('layouts/header');
		$this->load->view('layouts/aside');
		$this->load->view('reportes/grafictrat',$data);
		$this->load->view('layouts/footer');
	
		//$this->load->view('layouts/footer');
	
	}

	public function getData(){
		$year = $this->input->post("year");
		$resultados = $this->reports_model->GeTrataCobrado($year);
		echo json_encode($resultados);
	}

}