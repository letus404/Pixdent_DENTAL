<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 
 */
class Concepto extends CI_Controller
{
	private $permisos;
	public function __construct()
	{
		parent::__construct();
		if(!$this->session->userdata("login")){
			redirect(base_url());
		}
		$this->permisos = $this->backend_lib->control();
		$this->load->model('concepto_model');
	}

	public function index()
	{
		$data['permisos'] =$this->permisos;
		$this->load->view('layouts/header');
		$this->load->view('layouts/aside');
		$this->load->view('admin/concepto/listarconcepto',$data);
		$this->load->view('layouts/footer');

	}

	public function jsonconcepto()
	{
		$data['start'] = $this->input->get_post('start', true);
		$data['length'] = $this->input->get_post('length', true);
		$data['sEcho']  = $this->input->get_post('_', true);
		$columns= array('id_tipoconcepto','nombre_concepto','estado_tipo');
		$orderCampo = $this->input->get_post('order', true);
		$orderCampo = $orderCampo[0]['column'];
		$orderCampo = $columns[$orderCampo];
		$orderDireccion = $this->input->get_post('order', true);
		$orderDireccion = $orderDireccion[0]['dir'];
		$data['orderCampo'] = $orderCampo;
		$data['orderDireccion'] = $orderDireccion;
		$tipo_concepto = $this->input->get_post('tipo_concepto');
		if ($tipo_concepto!='') {
			$data['tipo_concepto'] = $tipo_concepto;
		}
		$datos = $this->concepto_model->getconcepto($data);
		header('content-type: application/json; charset=utf-8');
		echo json_encode($datos);
	}


	public function nuevo()
	{

		
		$this->load->view('layouts/header');
		$this->load->view('layouts/aside');
		$this->load->view('admin/concepto/agregarconcepto');
		$this->load->view('layouts/footer');
	}

	public function guardar()
	{
		$this->form_validation->set_rules('concepto','','requerid');
		$this->form_validation->set_rules('estado','','requerid');
	

		$data = array(
			
			'nombre_concepto' => $this->input->post('concepto'),
			'estado_tipo' => $this->input->post('estado')
		);

		$insert = $this->concepto_model->agregarconcepto($data);
			if(!is_null($insert)){
				$this->session->set_flashdata('success', 'Te has registrado correctamente en nuestro sistema.<br>Hemos enviado un código de verificación a ');
				$resp['success']=true;
			}
		echo json_encode(array("status" => TRUE));

		redirect(base_url().'mantenimiento/concepto');
	}


	public function editar($id)
	{
		$data['concepto'] = $this->concepto_model->getconceptoid($id);
		$this->load->view('layouts/header');
		$this->load->view('layouts/aside');
		$this->load->view('admin/concepto/actualizarconcepto',$data);
		$this->load->view('layouts/footer');
	}

	public function update()
	{
		
			
		$codigo=$this->input->post('codigo');
		$descripcion=$this->input->post('concepto');
		$estado=$this->input->post('estado');

		$NombreActual = $this->concepto_model->getconceptoid($codigo);

		if($nombre == $NombreActual->descripcion){
			$is_unique ="";

		}else{
			$is_unique= '|is_unique[tipo_concepto.nombre_concepto]';

		}

		$this->form_validation->set_rules("codigo","codigo","required");
		$this->form_validation->set_rules("concepto","descripcion","required".$is_unique);
		$this->form_validation->set_rules("estado","Estado","required");

		if($this->form_validation->run()==true){
			$data  = array(
				'id_tipoconcepto' =>$codigo,
				'nombre_concepto'=>$descripcion,
				'estado_tipo'=>$estado
				);


		if($this->concepto_model->update($codigo,$data)){
				$this->session->set_flashdata('success', 'Te has registrado correctamente en nuestro sistema.<br>Hemos enviado un código de verificación a ');
			redirect(base_url().'mantenimiento/concepto');
		}
		else{
		
				redirect(base_url().'mantenimiento/concepto/editar'.$codigo);

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
			'estado_tipo'=> 'N');
			$this->concepto_model->update($id,$data);
			$resp['success'] = true;
			echo json_encode($resp);
	        
	  }







}