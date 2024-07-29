<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 
 */
class Especialidad extends CI_Controller
{
	private $permisos;
    public function __construct()
    {
        parent::__construct();
        if(!$this->session->userdata("login")){
			redirect(base_url());
		}
		$this->permisos = $this->backend_lib->control();
        $this->load->model('especialidad_model');
    }

    public function index()
	{
		$data['permisos'] =$this->permisos;
		$this->load->view('layouts/header');
		$this->load->view('layouts/aside');
		$this->load->view('admin/especialidad/listarespecialidad',$data);
		$this->load->view('layouts/footer');

    }
    
    public function jsonespecialidad()
	{
		$data['start'] = $this->input->get_post('start', true);
		$data['length'] = $this->input->get_post('length', true);
		$data['sEcho']  = $this->input->get_post('_', true);
		$columns= array('cod_especialidad','nombre_especialidad','descripcion_especialidad','estado_especialidad');
		$orderCampo = $this->input->get_post('order', true);
		$orderCampo = $orderCampo[0]['column'];
		$orderCampo = $columns[$orderCampo];
		$orderDireccion = $this->input->get_post('order', true);
		$orderDireccion = $orderDireccion[0]['dir'];
		$data['orderCampo'] = $orderCampo;
		$data['orderDireccion'] = $orderDireccion;
		$especialidad = $this->input->get_post('especialidad');
		if ($especialidad!='') {
			$data['especialidad'] = $especialidad;
		}
		$datos = $this->especialidad_model->getespecialidad($data);
		header('content-type: application/json; charset=utf-8');
		echo json_encode($datos);
    }
    
    public function nuevo()
	{

		$this->load->view('layouts/header');
		$this->load->view('layouts/aside');
		$this->load->view('admin/especialidad/agregarespecialidad');
		$this->load->view('layouts/footer');

    }
    
    public function guardar()
	{
        $this->form_validation->set_rules('nombre','','requerid');
        $this->form_validation->set_rules('descripcion','','');
		$this->form_validation->set_rules('estado','','requerid');
	

		$data = array(
			
            'nombre_especialidad' => $this->input->post('nombre'),
            'descripcion_especialidad' => $this->input->post('descripcion'),
			'estado_especialidad' => $this->input->post('estado')
		);

		$insert = $this->especialidad_model->agregarespecialidad($data);
			if(!is_null($insert)){
				$this->session->set_flashdata('success', 'Te has registrado correctamente en nuestro sistema.<br>Hemos enviado un código de verificación a ');
				$resp['success']=true;
			}
		echo json_encode(array("status" => TRUE));

		redirect(base_url().'mantenimiento/especialidad');
    }
    
    public function editar($id)
	{
		$data['especialidad'] = $this->especialidad_model->getespecialidadid($id);
		$this->load->view('layouts/header');
		$this->load->view('layouts/aside');
		$this->load->view('admin/especialidad/actualizarespecialidad',$data);
		$this->load->view('layouts/footer');
    }
    
    public function update()
	{
			
		$codigo=$this->input->post('codigo');
        $nombre=$this->input->post('nombre_especialidad');
        $descripcion=$this->input->post('descripcion');
		$estado=$this->input->post('estado');

		$NombreActual = $this->especialidad_model->getespecialidadid($codigo);

		if($nombre == $NombreActual->nombre_especialidad){
			$is_unique ="";

		}else{
			$is_unique= '|is_unique[especialidad.nombre_especialidad]';

		}

		$this->form_validation->set_rules("codigo","codigo","required");
        $this->form_validation->set_rules("nombre_especialidad","nombre_especialidad","required".$is_unique);
        $this->form_validation->set_rules("descripcion","descripcion","");
		$this->form_validation->set_rules("estado","estado","required");

		if($this->form_validation->run()==true){
			$data  = array(
				'cod_especialidad' =>$codigo,
                'nombre_especialidad'=>$nombre,
                'descripcion_especialidad'=>$descripcion,
				'estado_especialidad'=>$estado
				);

				
		if($this->especialidad_model->update($codigo,$data)){
				$this->session->set_flashdata('success', 'Te has registrado correctamente en nuestro sistema.<br>Hemos enviado un código de verificación a ');
			redirect(base_url().'mantenimiento/especialidad');
		
			
		}
		else{
		
				redirect(base_url().'mantenimiento/especialidad/editar'.$codigo);

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
			'estado_especialidad'=> 'N');
			$this->especialidad_model->update($id,$data);
			$resp['success'] = true;
			echo json_encode($resp);
	        
	  }
    
}
