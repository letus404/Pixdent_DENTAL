<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tipodocumento extends CI_Controller
{
	private $permisos;
	public function __construct()
	{
		parent::__construct();
		if(!$this->session->userdata("login")){
			redirect(base_url());
		}
		$this->permisos = $this->backend_lib->control();
		$this->load->model('tipodocumento_model');
		$this->load->model('modelgeneral');
		# code...
	}

	
	public function index()
	{
		$data['permisos'] =$this->permisos;
		$data['documentos'] = $this->modelgeneral->getTable('tipo_documento');
		$this->load->view('layouts/header');
		$this->load->view('layouts/aside');
		$this->load->view('admin/documento/listartipodocumento',$data);
		$this->load->view('layouts/footer');
	}

	public function jsondocumento()
	{
		$data['start'] = $this->input->get_post('start', true);
		$data['length'] = $this->input->get_post('length', true);
		$data['sEcho']  = $this->input->get_post('_', true);
		$columns= array('descripcion','abreviatura','serie','inicio','fin','correlativo_actual','estado');
		$orderCampo = $this->input->get_post('order', true);
		$orderCampo = $orderCampo[0]['column'];
		$orderCampo = $columns[$orderCampo];
		$orderDireccion = $this->input->get_post('order', true);
		$orderDireccion = $orderDireccion[0]['dir'];
		$data['orderCampo'] = $orderCampo;
		$data['orderDireccion'] = $orderDireccion;
		$tipo_documento = $this->input->get_post('tipo_documento');
		if ($tipo_documento!='') {
			$data['tipo_documento'] = $tipo_documento;
		}
		$datos = $this->tipodocumento_model->getdocumento($data);
		header('content-type: application/json; charset=utf-8');
		echo json_encode($datos);
	}


	public function nuevo()
	{
		$this->load->view('layouts/header');
		$this->load->view('layouts/aside');
		$this->load->view('admin/documento/agregardocumento');
		$this->load->view('layouts/footer');
	}


	public function guardar()
	{
		$this->form_validation->set_rules('nombre','','required|trim|is_unique[tipo_documento.descripcion]');
		$this->form_validation->set_rules('abreviatura','','requerid');
		$this->form_validation->set_rules('serie','','requerid');
		$this->form_validation->set_rules('inicio','','requerid');
		$this->form_validation->set_rules('fin','','requerid');
		$this->form_validation->set_rules('correlativo','','requerid');
		$this->form_validation->set_rules('estado','','requerid');
	

		$data = array(
			
			'descripcion' => $this->input->post('nombre'),
			'abreviatura' => $this->input->post('abreviatura'),
			'serie' => $this->input->post('serie'),
			'inicio' => $this->input->post('inicio'),
			'fin' => $this->input->post('fin'),
			'correlativo_actual' => $this->input->post('correlativo'),
			'estado' => $this->input->post('estado')
		);

		$insert = $this->tipodocumento_model->agregardocumento($data);
			if(!is_null($insert)){
				$this->session->set_flashdata('success', 'Te has registrado correctamente en nuestro sistema.<br>Hemos enviado un código de verificación a ');
				$resp['success']=true;
			}
		echo json_encode(array("status" => TRUE));

		redirect(base_url().'mantenimiento/tipodocumento');
	}

	public function getTipoDocumento()
	{
		$id = $this->input->get('id');
		$documento = $this->modelgeneral->getTableWhereRow('tipo_documento',['cod_tipodocumento	'=>$id]);
		echo json_encode($documento);
    }
    

	public function editTipoDocumento()
	{
		$this->form_validation->set_rules('id', '', 'required');
		$this->form_validation->set_rules("nombre","nombre","required");
		$this->form_validation->set_rules("abreviatura","abreviatura","required");
		$this->form_validation->set_rules("serie","serie","required");
		$this->form_validation->set_rules("inicio","inicio","required");
		$this->form_validation->set_rules("fin","fin","required");
		$this->form_validation->set_rules("correlativo","correlativo","required");
		$this->form_validation->set_rules("estado","estado","required");

		if ($this->form_validation->run() == TRUE){
			$data['descripcion'] = $this->input->post('nombre');
			$data['abreviatura'] = $this->input->post('abreviatura');
			$data['serie'] = $this->input->post('serie');
			$data['inicio'] = $this->input->post('inicio');
			$data['fin'] = $this->input->post('fin');
			$data['estado']= $this->input->post('estado');
			$data['correlativo_actual'] = $this->input->post('correlativo');
			$where['cod_tipodocumento'] = $this->input->post('id');
			$edit  = $this->modelgeneral->editRegist('tipo_documento',$where,$data);

			$resp = [];
			if ($edit){
				$resp['success'] = true;
			}else{
				$resp['success'] = false;
			}
			echo json_encode($resp);
		}

	}

	public function anular()
	 {
	   	 	$id = $this->input->get('id');
			$data = array(
			'estado'=> '2');
			$this->tipodocumento_model->update($id,$data);
			$resp['success'] = true;
			echo json_encode($resp);
	        
	  }
     
}