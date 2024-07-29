<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class caritas_hospitalizacion extends CI_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->model('Caritas_model');
		if(!$this->session->userdata("login")){
			redirect(base_url());
		}
	}
	
	public function index()
	{
		$data =  array(
			'caritas_hospitalizacion' => $this->Caritas_model->getCaritasHospitalizacion(),
		
			
		 );
		//$this->load->view('layouts/header');
		$this->load->view('layouts/emotiones');
		$this->load->view('iconos/emotiones_hospitalizacion',$data);
	
		//$this->load->view('layouts/footer');
	
	}


	public function excelente_hospitalizacion(){
		$c_date= date("Y-m-d H:i:s");
		$estado=E;
		$tipo_carita=$estado;
		$fecha_like=$c_date;
		$data = array(
			'tipo_carita' => $tipo_carita,
			'fecha_registro' => $fecha_like,
		);
		$this->Caritas_model->GuardarHospitalizacion($data);
	}

	public function buena_hospitalizacion(){
		$c_date= date("Y-m-d H:i:s");
		$estado=B;
		$tipo_carita=$estado;
		$fecha_like=$c_date;
		$data = array(
			'tipo_carita' => $tipo_carita,
			'fecha_registro' => $fecha_like,
		);
		$this->Caritas_model->GuardarHospitalizacion($data);
	}

	public function regular_hospitalizacion(){
		$c_date= date("Y-m-d H:i:s");
		$estado=R;
		$tipo_carita=$estado;
		$fecha_like=$c_date;
		$data = array(
			'tipo_carita' => $tipo_carita,
			'fecha_registro' => $fecha_like,
		);
		$this->Caritas_model->GuardarHospitalizacion($data);
	}

	public function pesimo_hospitalizacion(){
		$c_date= date("Y-m-d H:i:s");
		$estado=P;
		$tipo_carita=$estado;
		$fecha_like=$c_date;
		$data = array(
			'tipo_carita' => $tipo_carita,
			'fecha_registro' => $fecha_like,
		);
		$this->Caritas_model->GuardarHospitalizacion($data);
	}

	public function malo_hospitalizacion(){
		$c_date= date("Y-m-d H:i:s");
		$estado=M;
		$tipo_carita=$estado;
		$fecha_like=$c_date;
		$data = array(
			'tipo_carita' => $tipo_carita,
			'fecha_registro' => $fecha_like,
		);
		$this->Caritas_model->GuardarHospitalizacion($data);
	}
}