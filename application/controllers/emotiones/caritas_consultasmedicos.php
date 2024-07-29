<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class caritas_consultasmedicos extends CI_Controller {
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
			'caritas_consultasmedicos' => $this->Caritas_model->getCaritasMedico(),
		
			
		 );
		//$this->load->view('layouts/header');
		$this->load->view('layouts/emotiones');
		$this->load->view('iconos/emotiones_medicos',$data);
	
		//$this->load->view('layouts/footer');
	
	}


	public function excelente_medico(){
		$c_date= date("Y-m-d H:i:s");
		$estado= E;
		$tipo_carita=$estado;
		$fecha_like=$c_date;
		$data = array(
			'tipo_carita' => $tipo_carita,
			'fecha_registro' => $fecha_like,
		);
		$this->Caritas_model->GuardarMedico($data);
	}

	public function buena_medico(){
		$c_date= date("Y-m-d H:i:s");
		$estado=B;
		$tipo_carita=$estado;
		$fecha_like=$c_date;
		$data = array(
			'tipo_carita' => $tipo_carita,
			'fecha_registro' => $fecha_like,
		);
		$this->Caritas_model->GuardarMedico($data);
	}

	public function regular_medico(){
		$c_date= date("Y-m-d H:i:s");
		$estado=R;
		$tipo_carita=$estado;
		$fecha_like=$c_date;
		$data = array(
			'tipo_carita' => $tipo_carita,
			'fecha_registro' => $fecha_like,
		);
		$this->Caritas_model->GuardarMedico($data);
	}

	public function pesimo_medico(){
		$c_date= date("Y-m-d H:i:s");
		$estado=P;
		$tipo_carita=$estado;
		$fecha_like=$c_date;
		$data = array(
			'tipo_carita' => $tipo_carita,
			'fecha_registro' => $fecha_like,
		);
		$this->Caritas_model->GuardarMedico($data);
	}

	public function malo_medico(){
		$c_date= date("Y-m-d H:i:s");
		$estado=M;
		$tipo_carita=$estado;
		$fecha_like=$c_date;
		$data = array(
			'tipo_carita' => $tipo_carita,
			'fecha_registro' => $fecha_like,
		);
		$this->Caritas_model->GuardarMedico($data);
	}
}