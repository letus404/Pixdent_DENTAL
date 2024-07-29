<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 
 */
class Alergia extends CI_Controller
{
	private $permisos;
	public function __construct()
	{
		parent::__construct();
		if(!$this->session->userdata("login")){
			redirect(base_url());
		}

		$this->load->model('alergia_model');
		$this->permisos = $this->backend_lib->control();
		# code...
	}


	public function index(){
		
		    $data['permisos'] =$this->permisos;
			$this->load->view('layouts/header');
			$this->load->view('layouts/aside');
			$this->load->view('admin/alergia/listar',$data);
			$this->load->view('layouts/footer');

		}


	public function jsonAlergia()
	{
		$data['start'] = $this->input->get_post('start', true);
		$data['length'] = $this->input->get_post('length', true);
		$data['sEcho']  = $this->input->get_post('_', true);
		$columns= array('cod_ale','nombre_ale');
		$orderCampo = $this->input->get_post('order', true);
		$orderCampo = $orderCampo[0]['column'];
		$orderCampo = $columns[$orderCampo];
		$orderDireccion = $this->input->get_post('order', true);
		$orderDireccion = $orderDireccion[0]['dir'];
		$data['orderCampo'] = $orderCampo;
		$data['orderDireccion'] = $orderDireccion;
		$alergia = $this->input->get_post('alergia');
		if ($alergia!='') {
			$data['alergia'] = $alergia;
		}
		$datos = $this->alergia_model->getAlergia($data);
		header('content-type: application/json; charset=utf-8');
		echo json_encode($datos);
	}




	public function nuevo()
	{
		
			$this->load->view('layouts/header');
			$this->load->view('layouts/aside');
			$this->load->view('admin/alergia/agregar');
			$this->load->view('layouts/footer');

	}


	public function guardar()
	{
		$this->form_validation->set_rules('descripcion','','requerid');
		$this->form_validation->set_rules('estado','','requerid');
	

		$data = array(
			
			'nombre_ale' => $this->input->post('descripcion')
			
		);

		$insert = $this->alergia_model->agregarAlergia($data);
			if(!is_null($insert)){
				$this->session->set_flashdata('success', 'Te has registrado correctamente en nuestro sistema.<br>Hemos enviado un código de verificación a ');
				$resp['success']=true;
			}
		echo json_encode(array("status" => TRUE));

		redirect(base_url().'mantenimiento/alergia');
	}


	public function editar($id)
	{
		$data['alergia'] = $this->alergia_model->getAlergiaid($id);
		$this->load->view('layouts/header');
		$this->load->view('layouts/aside');
		$this->load->view('admin/alergia/actualizar',$data);
		$this->load->view('layouts/footer');
	}


	public function update()
	{
		
			
		$codigo=$this->input->post('codigo');
		$descripcion=$this->input->post('nombre');


		$NombreActual = $this->alergia_model->getAlergiaid($codigo);

		if($nombre == $NombreActual->nombre){
			$is_unique ="";

		}else{
			$is_unique= '|is_unique[alergia.nombre_ale]';

		}

		$this->form_validation->set_rules("codigo","codigo","required");
		$this->form_validation->set_rules("nombre","nombre","required".$is_unique);


		if($this->form_validation->run()==true){
			$data  = array(
				'cod_ale' =>$codigo,
				'nombre_ale'=>$descripcion
			
				);


		if($this->alergia_model->update($codigo,$data)){
				$this->session->set_flashdata('success', 'Te has registrado correctamente en nuestro sistema.<br>Hemos enviado un código de verificación a ');
			redirect(base_url().'mantenimiento/alergia');
		}
		else{
		
				redirect(base_url().'mantenimiento/alergia/editar'.$codigo);

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
			'estado'=> '2');
			$this->alergia_model->update($id,$data);
			$resp['success'] = true;
			echo json_encode($resp);
	        
	  }





}