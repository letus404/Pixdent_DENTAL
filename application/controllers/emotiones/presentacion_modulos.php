<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class presentacion_modulos extends CI_Controller {
	public function __construct(){
		parent::__construct();
		//$this->load->model('Caritas_model');
		if(!$this->session->userdata("login")){
			redirect(base_url());
		}
	}
	
	public function index()
	{
		
		//$this->load->view('layouts/header');
		$this->load->view('layouts/emotiones');
		$this->load->view('iconos/tipo_modulos');
		$this->load->view('layouts/footer');
	
		//$this->load->view('layouts/footer');
	
	}


	
	
	

	

	
}