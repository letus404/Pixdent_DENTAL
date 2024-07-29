<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class caritas_farmacia extends CI_Controller {
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
			'caritas_farmacia' => $this->Caritas_model->getCaritasFarmacia(),
		
			
		 );
		//$this->load->view('layouts/header');
		$this->load->view('layouts/emotiones');
		$this->load->view('iconos/emotiones_farmacia',$data);
	
		//$this->load->view('layouts/footer');
	
	}


	public function excelente_farmacia(){
		$c_date= date("Y-m-d H:i:s");
		$estado= E;
		$tipo_carita=$estado;
		$fecha_like=$c_date;
		$data = array(
			'tipo_carita' => $tipo_carita,
			'fecha_registro' => $fecha_like,
		);
		$this->Caritas_model->GuardarFarmacia($data);
	}

	public function buena_farmacia(){
		$c_date= date("Y-m-d H:i:s");
		$estado=B;
		$tipo_carita=$estado;
		$fecha_like=$c_date;
		$data = array(
			'tipo_carita' => $tipo_carita,
			'fecha_registro' => $fecha_like,
		);
		$this->Caritas_model->GuardarFarmacia($data);
	}

	public function regular_farmacia(){
		$c_date= date("Y-m-d H:i:s");
		$estado=R;
		$tipo_carita=$estado;
		$fecha_like=$c_date;
		$data = array(
			'tipo_carita' => $tipo_carita,
			'fecha_registro' => $fecha_like,
		);
		$this->Caritas_model->GuardarFarmacia($data);
	}

	public function pesimo_farmacia(){
		$c_date= date("Y-m-d H:i:s");
		$estado=P;
		$tipo_carita=$estado;
		$fecha_like=$c_date;
		$data = array(
			'tipo_carita' => $tipo_carita,
			'fecha_registro' => $fecha_like,
		);
		$this->Caritas_model->GuardarFarmacia($data);
	}

	public function malo_farmacia(){
		$c_date= date("Y-m-d H:i:s");
		$estado=M;
		$tipo_carita=$estado;
		$fecha_like=$c_date;
		$data = array(
			'tipo_carita' => $tipo_carita,
			'fecha_registro' => $fecha_like,
		);
		$this->Caritas_model->GuardarFarmacia($data);
	}
}