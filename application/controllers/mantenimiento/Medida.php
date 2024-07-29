<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 
 */
class Medida extends CI_Controller
{
	private $permisos;
	public function __construct()
	{
		
		parent::__construct();
		if(!$this->session->userdata("login")){
			redirect(base_url());
		}
		$this->permisos = $this->backend_lib->control();

		$this->load->model('unidadmedida_model');
		# code...
	}


	public function index(){
			$data['permisos'] =$this->permisos;
			$this->load->view('layouts/header');
			$this->load->view('layouts/aside');
			$this->load->view('admin/medida/listarmedida',$data);
			$this->load->view('layouts/footer');

		}


	public function jsonmedida()
	{
		$data['start'] = $this->input->get_post('start', true);
		$data['length'] = $this->input->get_post('length', true);
		$data['sEcho']  = $this->input->get_post('_', true);
		$columns= array('id_medida','nom_medida','estado');
		$orderCampo = $this->input->get_post('order', true);
		$orderCampo = $orderCampo[0]['column'];
		$orderCampo = $columns[$orderCampo];
		$orderDireccion = $this->input->get_post('order', true);
		$orderDireccion = $orderDireccion[0]['dir'];
		$data['orderCampo'] = $orderCampo;
		$data['orderDireccion'] = $orderDireccion;
		$unidad_medida = $this->input->get_post('unidad_medida');
		if ($unidad_medida!='') {
			$data['unidad_medida'] = $unidad_medida;
		}
		$datos = $this->unidadmedida_model->getmedida($data);
		header('content-type: application/json; charset=utf-8');
		echo json_encode($datos);
	}




	public function nuevo()
	{
		
			$this->load->view('layouts/header');
			$this->load->view('layouts/aside');
			$this->load->view('admin/medida/agregarmedida');
			$this->load->view('layouts/footer');

	}


	public function guardar()
	{
		$this->form_validation->set_rules('descripcion','','requerid');
		$this->form_validation->set_rules('estado','','requerid');
	

		$data = array(
			
			'nom_medida' => $this->input->post('descripcion'),
			'estado' => $this->input->post('estado')
		);

		$insert = $this->unidadmedida_model->agregarmedida($data);
			if(!is_null($insert)){
				$this->session->set_flashdata('success', 'Te has registrado correctamente en nuestro sistema.<br>Hemos enviado un código de verificación a ');
				$resp['success']=true;
			}
		echo json_encode(array("status" => TRUE));

		redirect(base_url().'mantenimiento/medida');
	}


	public function editar($id)
	{
		$data['medida'] = $this->unidadmedida_model->getmedidaid($id);
		$this->load->view('layouts/header');
		$this->load->view('layouts/aside');
		$this->load->view('admin/medida/actualizarmedida',$data);
		$this->load->view('layouts/footer');
	}


	public function update()
	{
		
			
		$codigo=$this->input->post('codigo');
		$descripcion=$this->input->post('descripcion');
		$estado=$this->input->post('estado');

		$NombreActual = $this->unidadmedida_model->getmedidaid($codigo);

		if($nombre == $NombreActual->descripcion){
			$is_unique ="";

		}else{
			$is_unique= '|is_unique[unidad_medida.nom_medida]';

		}

		$this->form_validation->set_rules("codigo","codigo","required");
		$this->form_validation->set_rules("descripcion","descripcion","required".$is_unique);
		$this->form_validation->set_rules("estado","Estado","required");

		if($this->form_validation->run()==true){
			$data  = array(
				'id_medida' =>$codigo,
				'nom_medida'=>$descripcion,
				'estado'=>$estado
				);


		if($this->unidadmedida_model->update($codigo,$data)){
				$this->session->set_flashdata('success', 'Te has registrado correctamente en nuestro sistema.<br>Hemos enviado un código de verificación a ');
			redirect(base_url().'mantenimiento/medida');
		}
		else{
		
				redirect(base_url().'mantenimiento/medida/editar'.$codigo);

		}
		}
		else{
			$this->editar($codigo);
		}

	}

	public function anular()
	 {
	   	 	$id = $this->input->get('id');
			$data = array(
			'estado'=> 'N');
			$this->unidadmedida_model->update($id,$data);
			$resp['success'] = true;
			echo json_encode($resp);
	        
	  }





}