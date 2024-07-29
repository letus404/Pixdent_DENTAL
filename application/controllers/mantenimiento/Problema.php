<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Problema extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model("problema_model");
		# code...
	}

	
	public function index()
	{
		$data =  array('problema' => $this->problema_model->GetProblema(),
		 );


		$this->load->view('layouts/header');
		$this->load->view('layouts/aside');
		$this->load->view('admin/tipo_problema/list_problema',$data);
		$this->load->view('layouts/footer');
	}

	public function problema_add()
	{
		$data = array(
			'tipo_nombre' => $this->input->post('tipo_nombre'),
			'estado'=> 1,
		);
		$insert = $this->problema_model->add($data);
		echo json_encode(array("status"=>TRUE));
	}

	public function problema_edit($id)
	{
		$data = $this->Problema_Model->getProblema_Id($id);

		echo json_encode($data);
	}

	public function problema_update()
	{
		$data = array(
			'tipo_nombre' => $this->input->post('tipo_nombre'),
			
		);
		$this->Problema_Model->problema_update(array('id_tipo_problema' => $this->input->post('id_tipo_problema')),$data);
		echo json_encode(array("status" => TRUE));

	}

	public function delete($id)
	{
		$data = array(
			'estado'=> "0",);
		$this->Problema_model->update_problema($id,$data);
		echo "mantenimiento/Problema";
		
	}
}