<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class RegTuto extends CI_Controller {
	private $permisos;
	public function __construct(){
		parent::__construct();
		if(!$this->session->userdata("login")){
			redirect(base_url());
		}
		$this->permisos = $this->backend_lib->control();
	}
	
	public function index()
	{
		$data['permisos'] =$this->permisos;
		$this->load->view('layouts/header');
		$this->load->view('layouts/aside');
		$this->load->view('home/tutorial',$data);
		$this->load->view('layouts/footer');
	
	}
}
