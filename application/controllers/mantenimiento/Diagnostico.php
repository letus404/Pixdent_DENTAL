<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Diagnostico extends CI_Controller
{
	private $permisos;
	public function __construct()
	
	{
		parent::__construct();
		if(!$this->session->userdata("login")){
			redirect(base_url());
		}
		$this->permisos = $this->backend_lib->control();

		$this->load->model('diagnostico_model');
		# code...
	}

	public function index()
	{
		$data['permisos'] =$this->permisos;
		$this->load->view('layouts/header');
		$this->load->view('layouts/aside');
		$this->load->view('admin/diagnostico/listardiagnostico',$data);
		$this->load->view('layouts/footer');


	}

	public function jsondiagnostico()
	{
		$data['start'] = $this->input->get_post('start', true);
		$data['length'] = $this->input->get_post('length', true);
		$data['sEcho']  = $this->input->get_post('_', true);
		$columns= array('codi_enf','desc_enf','esta_enf');
		$orderCampo = $this->input->get_post('order', true);
		$orderCampo = $orderCampo[0]['column'];
		$orderCampo = $columns[$orderCampo];
		$orderDireccion = $this->input->get_post('order', true);
		$orderDireccion = $orderDireccion[0]['dir'];
		$data['orderCampo'] = $orderCampo;
		$data['orderDireccion'] = $orderDireccion;
		$enfermedad = $this->input->get_post('enfermedad');
		if ($enfermedad!='') {
			$data['enfermedad'] = $enfermedad;
		}
		$datos = $this->diagnostico_model->getdiagnostico($data);
		header('content-type: application/json; charset=utf-8');
		echo json_encode($datos);
	}

	public function nuevo()
	{

		
		$this->load->view('layouts/header');
		$this->load->view('layouts/aside');
		$this->load->view('admin/diagnostico/agregardiagnostico');
		$this->load->view('layouts/footer');
	}


	public function guardar()
	{
		$this->form_validation->set_rules('cie10','','requerid');
		$this->form_validation->set_rules('descripcion','','requerid');
		$this->form_validation->set_rules('estado','','requerid');
	

		$data = array(
			
			'codi_enf' => $this->input->post('cie10'),
			'desc_enf' => $this->input->post('descripcion'),
			  'esta_enf' => $this->input->post('estado')
		);

		$insert = $this->diagnostico_model->agregardiagnostico($data);
			if(!is_null($insert)){
				$this->session->set_flashdata('success', 'Te has registrado correctamente en nuestro sistema.<br>Hemos enviado un código de verificación a ');
				$resp['success']=true;
			}
		echo json_encode(array("status" => TRUE));

		redirect(base_url().'mantenimiento/diagnostico');
	}


	public function editar($id)
	{
		$data['diagnostico'] = $this->diagnostico_model->getdiagnosticoid($id);
		$this->load->view('layouts/header');
		$this->load->view('layouts/aside');
		$this->load->view('admin/diagnostico/actualizardiagnostico',$data);
		$this->load->view('layouts/footer');
	}


	public function update()
	{
		
		$descripcion=$this->input->post('descripcion');
		$estado=$this->input->post('estado');

		$this->form_validation->set_rules("descripcion","descripcion","required".$is_unique);
		$this->form_validation->set_rules("estado","Estado","required");

		if($this->form_validation->run()==true){
			$data  = array(
				'codi_enf' =>$this->input->post('codigo'),
				'desc_enf'=>$descripcion,
				'esta_enf'=>$estado
				);


		if($this->diagnostico_model->update($codi_enf,$data)){
				$this->session->set_flashdata('success', 'Te has registrado correctamente en nuestro sistema.<br>Hemos enviado un código de verificación a ');
			redirect(base_url().'mantenimiento/diagnostico');
		}
		else{
		
				redirect(base_url().'mantenimiento/diagnostico/editar'.$codi_enf);

		}
		}
		else{
			$this->editar($codi_enf);
		}
	}

		

	

		public function anular()
	   	 {
	   	 	$id = $this->input->get('id');
			$data = array(
			'esta_enf'=> 'N');
			$this->diagnostico_model->update($id,$data);
			$resp['success'] = true;
			echo json_encode($resp);
	        
	   	 }


}