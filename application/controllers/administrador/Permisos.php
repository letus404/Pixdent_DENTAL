<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 
 */

/**
 * 
 */
class permisos extends CI_Controller
{
	private $permisos;
	public function __construct()
	{
		parent::__construct();
		
		if(!$this->session->userdata("login")){
			redirect(base_url());
		}
		$this->permisos = $this->backend_lib->control();
		$this->load->model('permisos_model');
		$this->load->model('modelgeneral');
	}

	public function index()
	{
		$data['permisos'] =$this->permisos;
		$data = array(
			'permisos' => $this->permisos_model->getPermisos(),
			'rol' =>$this->modelgeneral->getTable('rol'),
			'menus' =>$this->modelgeneral->getTable('menus')
		);

		$this->load->view('layouts/header');
		$this->load->view('layouts/aside');
		$this->load->view('admin/permisos/listar',$data);
		$this->load->view('layouts/footer');
	}


	public function jsonPermisos()
	{
		$data['start'] = $this->input->get_post('start', true);
		$data['length'] = $this->input->get_post('length', true);
		$data['sEcho']  = $this->input->get_post('_', true);

		$columns = array('id_permiso','NombreMenu','NombreRol');
		$orderCampo = $this->input->get_post('order', true);
		$orderCampo = $orderCampo[0]['column'];
		$orderCampo = $columns[$orderCampo];
		$orderDireccion = $this->input->get_post('order', true);
		$orderDireccion = $orderDireccion[0]['dir'];
		$data['orderCampo'] = $orderCampo;
		$data['orderDireccion'] = $orderDireccion;
		$menus = $this->input->get_post('menus');
		$rol = $this->input->get_post('rol');

		if ($menus!='') {
			$data['menus'] = $menus;
		}

		if ($rol!='') {
			$data['rol'] = $rol;
		}
			
		$datos = $this->permisos_model->getPerm($data);
		header('content-type: application/json; charset=utf-8');
		echo json_encode($datos);
	}


	public function add(){

		$data = array(
			'roles' =>  $this->modelgeneral->getTable('rol'),
			'menus' => $this->permisos_model->getMenus(),

		);

		$this->load->view('layouts/header');
		$this->load->view('layouts/aside');
		$this->load->view('admin/permisos/add',$data);
		$this->load->view('layouts/footer');
	}


	public function store(){
		$menu =$this->input->post('menu');
		$rol = $this->input->post('rol');
		$read= $this->input->post('read');
		$insert = $this->input->post('insert');
		$update = $this->input->post('update');
		$delete = $this->input->post('delete');

		$data = array(

		'id_menu' => $menu,
		'codi_rol' => $rol,
		'read' => $read,
		'insert' =>$insert,
		'update' =>$update,
		'delete' =>$delete,	
		);

		if($this->permisos_model->save($data)){
			redirect(base_url().'administrador/permisos');
		}else{
			$this->session->set_flashdata('error','no se pudo guardar la informacion');
			redirect(base_url().'administrador/permisos/add');
		}
	}

	public function edit($id){
		$data = array(
			'roles' => $this->modelgeneral->getTable('rol'),
			'menus' => $this->permisos_model->getMenus(),
			'permiso' => $this->permisos_model->getPermiso($id),
		);

		$this->load->view('layouts/header');
		$this->load->view('layouts/aside');
		$this->load->view('admin/permisos/edit',$data);
		$this->load->view('layouts/footer');


	}

	public function update(){
		$idpermiso = $this->input->post('idpermiso');
		$menu =$this->input->post('menu');
		$rol = $this->input->post('rol');
		$read= $this->input->post('read');
		$insert = $this->input->post('insert');
		$update = $this->input->post('update');
		$delete = $this->input->post('delete');

			$data = array(
		'read' => $read,
		'insert' =>$insert,
		'update' =>$update,
		'delete' =>$delete,	
		);

			if($this->permisos_model->update($idpermiso,$data)){
			redirect(base_url().'administrador/permisos');
		}else{
			$this->session->set_flashdata('error','no se pudo guardar la informacion');
			redirect(base_url().'administrador/permisos/edit');
		}

	}
}