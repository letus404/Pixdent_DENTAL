<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Rol extends CI_Controller
{
	private $permisos;
	public function __construct()
	{
		parent::__construct();
		 if(!$this->session->userdata("login")){
            redirect(base_url());
        }
		$this->load->model('roles_model');
		$this->load->model('modelgeneral');
		$this->permisos = $this->backend_lib->control();
		# code...
	}

	
	public function index()
	{
		$data['permisos'] =$this->permisos;
		 $data['roles'] = $this->modelgeneral->getTable('rol');
		$this->load->view('layouts/header');
		$this->load->view('layouts/aside');
		$this->load->view('admin/rol/list_rol',$data);
		$this->load->view('layouts/footer');
	}

	public function jsonRol()
	{
		$data['start'] = $this->input->get_post('start', true);
		$data['length'] = $this->input->get_post('length', true);
		$data['sEcho']  = $this->input->get_post('_', true);
		$columns= array('codi_rol','nomb_rol','estado');
		$orderCampo = $this->input->get_post('order', true);
		$orderCampo = $orderCampo[0]['column'];
		$orderCampo = $columns[$orderCampo];
		$orderDireccion = $this->input->get_post('order', true);
		$orderDireccion = $orderDireccion[0]['dir'];
		$data['orderCampo'] = $orderCampo;
		$data['orderDireccion'] = $orderDireccion;
		$rol = $this->input->get_post('rol');
		if ($rol!='') {
			$data['rol'] = $rol;
		}
		$datos = $this->roles_model->getRoles($data);
		header('content-type: application/json; charset=utf-8');
		echo json_encode($datos);
	}


	public function add()
	{
		
		$this->load->view('layouts/header');
		$this->load->view('layouts/aside');
		$this->load->view('admin/rol/add_rol');
		$this->load->view('layouts/footer');
	}

	public function rol_add()
	{
		 $nombre = $this->input->post("nomb_rol");
		$data = array(
			'nomb_rol' => $nombre,
			'esta_rol'=> "1"
		);
		if($this->roles_model->add($data)){
			redirect(base_url()."mantenimiento/rol");
		}
		else{
			$this->session->set_flashdata("error","No se pudo guardar el rol");
			redirect(base_url()."mantenimiento/rol/add");
		}
	
	}

	 function getRol()
	{
		$id = $this->input->get('id');
		$rol = $this->modelgeneral->getTableWhereRow('rol',['codi_rol'=>$id]);
		echo json_encode($rol);
	}

		function editRol()
     {
         $this->form_validation->set_rules('id','','required');
         $this->form_validation->set_rules('nombre','','required');
         $this->form_validation->set_rules('estado','','required');
         if($this->form_validation->run() == TRUE){

             $data['nomb_rol'] = $this->input->post('nombre');
            $data['esta_rol']= $this->input->post('estado');
             $where['codi_rol'] = $this->input->post('id');
             $edit = $this->modelgeneral->editRegist('rol',$where,$data);
             $resp =[];
             if(!is_null($edit)){
                 $resp['success'] = true;
             }else{
                 $resp['success'] = false;
             }
             echo json_encode($resp);
         }
     }
	

	function anularRol()
	     {
        $data['esta_rol'] = 2; //ANULAR	
        $where['codi_rol'] = $this->input->get('id');  
		
		$edit = $this->modelgeneral->editRegist('rol',$where,$data);
		$resp = [];
		if ($edit) {
			$resp['success'] = true;
		}else{
			$resp['success'] = false;
		}
		echo json_encode($resp);
	     }
}