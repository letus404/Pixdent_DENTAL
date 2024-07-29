<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Listartrama extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model(array("areas_model","user_model", "registrartramasistemas_model","listartramas_model"));
		# code...
	}

	
	public function index()
	{

		// date_default_timezone_set("America/Lima"); 
		 $data =  array(
		 	'listar' => $this->listartramas_model->getlistar(),
	
		  );


		$this->load->view('layouts/header');
		$this->load->view('layouts/aside');	
		$this->load->view('admin/sistemas/listartramas',$data);
		$this->load->view('layouts/footer');
	}

	public function listar_edit($id)
	{
		$data = $this->listartramas_model->getlistar_id($id);

		echo json_encode($data);
	}

	public function listar_update()
	{
		
		$data = array(
			
            'cantidad_factura' =>$this->input->post('cantidad_factura'),
			'fecha_solucionado'=>$this->input->post('fecha_solucionado'),
			'estado'=>$this->input->post('estado'),
			
		);
		$this->listartramas_model->tramas_update(array('secuencia' => $this->input->post('secuencia')),$data);
		echo json_encode(array("status" => TRUE));

	}

	// public function addOcurrencias()
	// {
	// 	// $createDate = date("Y-m-d H:i:s");
	// 	$id_usuario = $this->input->post('id_usuario');
	// 	$id_area = $this->input->post('id_area');
	// 	$id_tipo_problema = $this->input->post('id_tipo_problema');
	// 	$id_tipo_documento = $this->input->post('id_tipo_documento');
	// 	$asunto = $this->input->post('asunto');
	// 	$fecha_registro = date("Y-m-d H:i:s");
	// 	$fecha_problema = date("Y-m-d H:i:s");
	// 	$mensaje = $this->input->post('mensaje');
	// 	$nombre_documento = $this->input->post('nombre_documento');
	// 	$file_name = $_FILES['documento']['name'];
 //   		$file_size = $_FILES['documento']['size'];
 //    	$file_tmp = $_FILES['documento']['tmp_name'];
 //    	$file_type = $_FILES['documento']['type'];
 //    	$fp = fopen($file_tmp, 'r+b');
 //    	$binario = fread($fp, filesize($file_tmp));
 //    	fclose($fp);

 //    	$datos = array(
 //    		'id_usuario' => $id_usuario,
 //    		'id_area' => $id_area,
 //    		'id_tipo_problema' => $id_tipo_problema,
 //    		'id_tipo_documento' => $id_tipo_documento,
 //    		'fecha_registro' => $fecha_registro,
 //    		'fecha_problema' => $fecha_problema,
 //    		'mensaje' => $mensaje,
 //    		'nombre_documento' =>$nombre_documento,
 //    		'documento' => $binario,
 //    		'estado' => 1
 //    	);

 //    	$this->Ocurrencias_model->insertar("ocurrencia",$datos);

 //    	//$this->Ocurrencias_model->insertar($datos);
 //    	//	echo json_encode(array("status"=>TRUE));
	// }

	// public function area_add()
	// {
	// 	$data = array(
	// 		'nombre_area' => $this->input->post('nombre_area'),
	// 		'descripcion_area' => $this->input->post('descripcion_area'),
	// 		'estado'=> 1,
	// 	);
	// 	$insert = $this->Areas_model->add($data);
	// 	echo json_encode(array("status"=>TRUE));
	// }

	// public function area_edit($id)
	// {
	// 	$data = $this->Areas_model->getArea_Id($id);

	// 	echo json_encode($data);
	// }

	// public function area_update()
	// {
	// 	$data = array(
	// 		'nombre_area' => $this->input->post('nombre_area'),
	// 		'descripcion_area' =>$this->input->post('descripcion_area'),
	// 	);
	// 	$this->Areas_model->area_update(array('id_area' => $this->input->post('id_area')),$data);
	// 	echo json_encode(array("status" => TRUE));

	// }

	// public function delete($id)
	// {
	// 	$data = array(
	// 		'estado'=> "0",);
	// 	$this->Areas_model->update_area($id,$data);
	// 	echo "mantenimiento/Area";
		
	// }
}