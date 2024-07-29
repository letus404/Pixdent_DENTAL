<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 
 */
class Moneda extends CI_Controller
{
	private $permisos;
	public function __construct()
	{
		parent::__construct();
		if(!$this->session->userdata("login")){
			redirect(base_url());
		}
		$this->permisos = $this->backend_lib->control();

		$this->load->model('moneda_model');
		# code...
	}


	public function index(){
			$data['permisos'] =$this->permisos;
			$this->load->view('layouts/header');
			$this->load->view('layouts/aside');
			$this->load->view('admin/moneda/listarmoneda',$data);
			$this->load->view('layouts/footer');

		}


	public function jsonmoneda()
	{
		$data['start'] = $this->input->get_post('start', true);
		$data['length'] = $this->input->get_post('length', true);
		$data['sEcho']  = $this->input->get_post('_', true);
		$columns= array('cod_tipomoneda','descripcion','estado');
		$orderCampo = $this->input->get_post('order', true);
		$orderCampo = $orderCampo[0]['column'];
		$orderCampo = $columns[$orderCampo];
		$orderDireccion = $this->input->get_post('order', true);
		$orderDireccion = $orderDireccion[0]['dir'];
		$data['orderCampo'] = $orderCampo;
		$data['orderDireccion'] = $orderDireccion;
		$tipo_moneda = $this->input->get_post('tipo_moneda');
		if ($tipo_moneda!='') {
			$data['tipo_moneda'] = $tipo_moneda;
		}
		$datos = $this->moneda_model->getmoneda($data);
		header('content-type: application/json; charset=utf-8');
		echo json_encode($datos);
	}




	public function nuevo()
	{
		
			$this->load->view('layouts/header');
			$this->load->view('layouts/aside');
			$this->load->view('admin/moneda/agregarmoneda');
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

		$insert = $this->moneda_model->agregarmoneda($data);
			if(!is_null($insert)){
				$this->session->set_flashdata('success', 'Te has registrado correctamente en nuestro sistema.<br>Hemos enviado un código de verificación a ');
				$resp['success']=true;
			}
		echo json_encode(array("status" => TRUE));

		redirect(base_url().'mantenimiento/moneda');
	}


	public function editar($id)
	{
		$data['moneda'] = $this->moneda_model->getmonedaid($id);
		$this->load->view('layouts/header');
		$this->load->view('layouts/aside');
		$this->load->view('admin/moneda/actualizarmoneda',$data);
		$this->load->view('layouts/footer');
	}


	public function update()
	{
		
			
		$codigo=$this->input->post('codigo');
		$descripcion=$this->input->post('nombre');
		$estado=$this->input->post('estado');

		$NombreActual = $this->moneda_model->getmonedaid($codigo);

		if($nombre == $NombreActual->nombre){
			$is_unique ="";

		}else{
			$is_unique= '|is_unique[tipo_moneda.descripcion]';

		}

		$this->form_validation->set_rules("codigo","codigo","required");
		$this->form_validation->set_rules("nombre","nombre","required".$is_unique);
		$this->form_validation->set_rules("estado","Estado","required");

		if($this->form_validation->run()==true){
			$data  = array(
				'cod_tipomoneda' =>$codigo,
				'descripcion'=>$descripcion,
				'estado'=>$estado
				);


		if($this->moneda_model->update($codigo,$data)){
				$this->session->set_flashdata('success', 'Te has registrado correctamente en nuestro sistema.<br>Hemos enviado un código de verificación a ');
			redirect(base_url().'mantenimiento/moneda');
		}
		else{
		
				redirect(base_url().'mantenimiento/moneda/editar'.$codigo);

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
			$this->moneda_model->update($id,$data);
			$resp['success'] = true;
			echo json_encode($resp);
	        
	  }





}