<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 
 */
class Categoria extends CI_Controller
{
	private $permisos;
	public function __construct()
	{
		parent::__construct();
		if(!$this->session->userdata("login")){
			redirect(base_url());
		}
		$this->permisos = $this->backend_lib->control();
		$this->load->model('categoria_model');
	}


	public function index()
	{
		$data['permisos'] =$this->permisos;
		$this->load->view('layouts/header');
		$this->load->view('layouts/aside');
		$this->load->view('admin/categoria/listarcategoria',$data);
		$this->load->view('layouts/footer');

	}

	public function jsoncategoria()
	{
		$data['start'] = $this->input->get_post('start', true);
		$data['length'] = $this->input->get_post('length', true);
		$data['sEcho']  = $this->input->get_post('_', true);
		$columns= array('codi_cat','nomb_cat','esta_cat');
		$orderCampo = $this->input->get_post('order', true);
		$orderCampo = $orderCampo[0]['column'];
		$orderCampo = $columns[$orderCampo];
		$orderDireccion = $this->input->get_post('order', true);
		$orderDireccion = $orderDireccion[0]['dir'];
		$data['orderCampo'] = $orderCampo;
		$data['orderDireccion'] = $orderDireccion;
		$categoria = $this->input->get_post('categoria');
		if ($categoria!='') {
			$data['categoria'] = $categoria;
		}
		$datos = $this->categoria_model->getcategoria($data);
		header('content-type: application/json; charset=utf-8');
		echo json_encode($datos);
	}


	public function nuevo()
	{

		$this->load->view('layouts/header');
		$this->load->view('layouts/aside');
		$this->load->view('admin/categoria/agregarcategoria');
		$this->load->view('layouts/footer');

	}

	public function guardar()
	{
		$this->form_validation->set_rules('categoria','','requerid');
		$this->form_validation->set_rules('estado','','requerid');
	

		$data = array(
			
			'nomb_cat' => $this->input->post('categoria'),
			'esta_cat' => $this->input->post('estado')
		);

		$insert = $this->categoria_model->agregarcategoria($data);
			if(!is_null($insert)){
				$this->session->set_flashdata('success', 'Te has registrado correctamente en nuestro sistema.<br>Hemos enviado un código de verificación a ');
				$resp['success']=true;
			}
		echo json_encode(array("status" => TRUE));

		redirect(base_url().'mantenimiento/categoria');
	}

	public function editar($id)
	{
		$data['categoria'] = $this->categoria_model->getcategoriaid($id);
		$this->load->view('layouts/header');
		$this->load->view('layouts/aside');
		$this->load->view('admin/categoria/actualizarcategoria',$data);
		$this->load->view('layouts/footer');
	}

	public function update()
	{
		
			
		$codigo=$this->input->post('codigo');
		$descripcion=$this->input->post('categoria');
		$estado=$this->input->post('estado');

		$NombreActual = $this->categoria_model->getcategoriaid($codigo);

		if($nombre == $NombreActual->descripcion){
			$is_unique ="";

		}else{
			$is_unique= '|is_unique[categoria.nomb_cat]';

		}

		$this->form_validation->set_rules("codigo","codigo","required");
		$this->form_validation->set_rules("categoria","categoria","required".$is_unique);
		$this->form_validation->set_rules("estado","Estado","required");

		if($this->form_validation->run()==true){
			$data  = array(
				'codi_cat' =>$codigo,
				'nomb_cat'=>$descripcion,
				'esta_cat'=>$estado
				);


		if($this->categoria_model->update($codigo,$data)){
				$this->session->set_flashdata('success', 'Te has registrado correctamente en nuestro sistema.<br>Hemos enviado un código de verificación a ');
			redirect(base_url().'mantenimiento/categoria');
		}
		else{
		
				redirect(base_url().'mantenimiento/categoria/editar'.$codigo);

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
			'esta_cat'=> 'N');
			$this->categoria_model->update($id,$data);
			$resp['success'] = true;
			echo json_encode($resp);
	        
	  }


}