<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Area extends CI_Controller
{
	private $permisos;
	public function __construct()
	{
		
		parent::__construct();
		$this->permisos = $this->backend_lib->control();
		$this->load->model("Areas_model");
		# code...
	}

	
	public function index()
	{
		$data =  array(
			'permisos' => $this->permisos,
			'area' => $this->Areas_model->getAreas(),
		 );


		$this->load->view('layouts/header');
		$this->load->view('layouts/aside');
		$this->load->view('admin/area/list',$data);
		$this->load->view('layouts/footer');
	}

	public function area_add()
	{
		$data = array(
			'nombre_area' => $this->input->post('nombre_area'),
			'descripcion_area' => $this->input->post('descripcion_area'),
			'estado'=> 1,
		);
		$insert = $this->Areas_model->add($data);
		echo json_encode(array("status"=>TRUE));
	}

	public function area_edit($id)
	{
		$data = $this->Areas_model->getArea_Id($id);

		echo json_encode($data);
	}

	public function area_update()
	{
		$data = array(
			'nombre_area' => $this->input->post('nombre_area'),
			'descripcion_area' =>$this->input->post('descripcion_area'),
		);
		$this->Areas_model->area_update(array('id_area' => $this->input->post('id_area')),$data);
		echo json_encode(array("status" => TRUE));

	}

	public function delete($id)
	{
		$data = array(
			'estado'=> "0",);
		$this->Areas_model->update_area($id,$data);
		echo "mantenimiento/Area/";
		
	}
}