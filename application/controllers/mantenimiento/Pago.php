<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 
 */
class Pago extends CI_Controller
{
	
	public function __construct()
	{
		parent::__construct();
		if(!$this->session->userdata("login")){
			redirect(base_url());
		}
		$this->load->model('pago_model');
		# code...
	}


	public function index(){
		
			$this->load->view('layouts/header');
			$this->load->view('layouts/aside');
			$this->load->view('admin/pago/listarpago');
			$this->load->view('layouts/footer');

		}


	public function jsonpago()
	{
		$data['start'] = $this->input->get_post('start', true);
		$data['length'] = $this->input->get_post('length', true);
		$data['sEcho']  = $this->input->get_post('_', true);
		$columns= array('cod_tipopago','descripcion','estado');
		$orderCampo = $this->input->get_post('order', true);
		$orderCampo = $orderCampo[0]['column'];
		$orderCampo = $columns[$orderCampo];
		$orderDireccion = $this->input->get_post('order', true);
		$orderDireccion = $orderDireccion[0]['dir'];
		$data['orderCampo'] = $orderCampo;
		$data['orderDireccion'] = $orderDireccion;
		$tipo_pago = $this->input->get_post('tipo_pago');
		if ($tipo_pago!='') {
			$data['tipo_pago'] = $tipo_pago;
		}
		$datos = $this->pago_model->getpago($data);
		header('content-type: application/json; charset=utf-8');
		echo json_encode($datos);
	}




	public function nuevo()
	{
		
			$this->load->view('layouts/header');
			$this->load->view('layouts/aside');
			$this->load->view('admin/pago/agregarpago');
			$this->load->view('layouts/footer');

	}


	public function guardar()
	{
		$this->form_validation->set_rules('descripcion','','requerid');
		$this->form_validation->set_rules('estado','','requerid');
	

		$data = array(
			
			'descripcion' => $this->input->post('descripcion'),
			'estado' => $this->input->post('estado')
		);

		$insert = $this->pago_model->agregarpago($data);
			if(!is_null($insert)){
				$this->session->set_flashdata('success', 'Te has registrado correctamente en nuestro sistema.<br>Hemos enviado un código de verificación a ');
				$resp['success']=true;
			}
		echo json_encode(array("status" => TRUE));

		redirect(base_url().'mantenimiento/pago');
	}


	public function editar($id)
	{
		$data['pago'] = $this->pago_model->getpagoid($id);
		$this->load->view('layouts/header');
		$this->load->view('layouts/aside');
		$this->load->view('admin/pago/actualizarpago',$data);
		$this->load->view('layouts/footer');
	}


	public function update()
	{
		
			
		$codigo=$this->input->post('codigo');
		$descripcion=$this->input->post('nombre');
		$estado=$this->input->post('estado');

		$NombreActual = $this->pago_model->getpagoid($codigo);

		if($nombre == $NombreActual->nombre){
			$is_unique ="";

		}else{
			$is_unique= '|is_unique[tipo_pago.descripcion]';

		}

		$this->form_validation->set_rules("codigo","codigo","required");
		$this->form_validation->set_rules("nombre","nombre","required".$is_unique);
		$this->form_validation->set_rules("estado","Estado","required");

		if($this->form_validation->run()==true){
			$data  = array(
				'cod_tipopago' =>$codigo,
				'descripcion'=>$descripcion,
				'estado'=>$estado
				);


		if($this->pago_model->update($codigo,$data)){
				$this->session->set_flashdata('success', 'Te has registrado correctamente en nuestro sistema.<br>Hemos enviado un código de verificación a ');
			redirect(base_url().'mantenimiento/pago');
		}
		else{
		
				redirect(base_url().'mantenimiento/pago/editar'.$codigo);

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
			$this->pago_model->update($id,$data);
			$resp['success'] = true;
			echo json_encode($resp);
	        
	  }





}