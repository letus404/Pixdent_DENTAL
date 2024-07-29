<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class caritasfeliz extends CI_Controller {
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
			'caritas' => $this->Caritas_model->getCaritas(),
		
			
		 );
		//$this->load->view('layouts/header');
		$this->load->view('layouts/emotiones');
		$this->load->view('iconos/emotiones',$data);
	
		//$this->load->view('layouts/footer');
	
	}


	public function excelente_admision(){
		$c_date= date("Y-m-d H:i:s");
		$estado=E;
		$tipo_carita=$estado;
		$fecha_like=$c_date;
		$data = array(
			'tipo_carita' => $tipo_carita,
			'fecha_registro' => $fecha_like,
		);
		$this->Caritas_model->GuardarAdmision($data);
	}

	public function buena_admision(){
		$c_date= date("Y-m-d H:i:s");
		$estado=B;
		$tipo_carita=$estado;
		$fecha_like=$c_date;
		$data = array(
			'tipo_carita' => $tipo_carita,
			'fecha_registro' => $fecha_like,
		);
		$this->Caritas_model->GuardarAdmision($data);
	}

	public function regular_admision(){
		$c_date= date("Y-m-d H:i:s");
		$estado=R;
		$tipo_carita=$estado;
		$fecha_like=$c_date;
		$data = array(
			'tipo_carita' => $tipo_carita,
			'fecha_registro' => $fecha_like,
		);
		$this->Caritas_model->GuardarAdmision($data);
	}

	public function pesimo_admision(){
		$c_date= date("Y-m-d H:i:s");
		$estado=P;
		$tipo_carita=$estado;
		$fecha_like=$c_date;
		$data = array(
			'tipo_carita' => $tipo_carita,
			'fecha_registro' => $fecha_like,
		);
		$this->Caritas_model->GuardarAdmision($data);
	}

	public function malo_admision(){
		$c_date= date("Y-m-d H:i:s");
		$estado=M;
		$tipo_carita=$estado;
		$fecha_like=$c_date;
		$data = array(
			'tipo_carita' => $tipo_carita,
			'fecha_registro' => $fecha_like,
		);
		$this->Caritas_model->GuardarAdmision($data);
	}
}