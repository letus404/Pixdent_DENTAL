<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ubigeo extends CI_Controller {

	public function index()
	{
		$this->load->view('admin/paciente/agregarpaciente');
	}

	Public function get_departamento()
	{
		$query=$this->db->get('departamento');
        $result= $query->result();
        $data=array();
		foreach($result as $r)
		{
			$data['value']=$r->departamento_id;
			$data['label']=$r->departamento_nombre;
			$json[]=$data;


		}
		echo json_encode($json);



	}

	Public function get_provincia()
	{

		  $result=$this->db->where('departamento_id',$_POST['provincia_id'])
						->get('provincia')
						->result();

        $data=array();
		foreach($result as $r)
		{
			$data['value']=$r->provincia_id;
			$data['label']=$r->provincia_nombre;
			$json[]=$data;


		}
		echo json_encode($json);

	}

		Public function get_distrito()
	{

		  $result=$this->db->where('provincia_id',$_POST['distrito_id'])
						->get('distrito')
						->result();

        $data=array();
		foreach($result as $r)
		{
			$data['value']=$r->distrito_id;
			$data['label']=$r->distrito_nombre;
			$json[]=$data;


		}
		echo json_encode($json);

	}


}
