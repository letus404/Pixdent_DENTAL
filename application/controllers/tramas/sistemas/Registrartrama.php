<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Registrartrama extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model(array("areas_model","user_model","registrartramasistemas_model"));
		# code...
	}

	
	public function index()
	{
		date_default_timezone_set("America/Lima"); 
		$data =  array(
 			'user' => $this->user_model->getuser(),
 			'area' => $this->areas_model->getareas(),
);
		$this->load->view('layouts/header');
		$this->load->view('layouts/aside');
		
		$this->load->view('admin/sistemas/registrartramas',$data);
		$this->load->view('layouts/footer');
	}

// 	public function add()
// {
// 	date_default_timezone_set("America/Lima"); 
// 		$data =  array(
// 			'user' => $this->User_model->getUser(),
// 			'area' => $this->Areas_model->getAreas(),
// 			'problema' => $this->Problema_Model->GetProblema(),
// 			'tipodocumento' => $this->Tipodocumento_model->getTipodocumento(),
// 			$archivos = $this->Ocurrencias_model->getArchivos(),
//    		 $data['archivos']=$archivos,		
// 		 );


// 		$this->load->view('layouts/header');
// 		$this->load->view('layouts/aside');
		
// 		$this->load->view('movimientos/concurrencias/registrar',$data);
// 		$this->load->view('layouts/footer');

// }
	public function insertar()
	{
		 $createDate = date("Y-m-d H:i:s");
		date_default_timezone_set("America/Lima");
		$secuencia = $this->input->post('secuencia');
		$id_usuario = $this->input->post('id_usuario');
		$id_area = $this->input->post('id_area');
		$lote = $this->input->post('lote');
		$aseguradora = $this->input->post('aseguradora');
		$cantidad_factura =$this->input->post('cantidad_factura');
		$fecha_llegada = $createDate;
		$fecha_solucionado = $this->input->post('fecha_solucionado');
		$observacion = $this->input->post('observacion');
	
		/*$file_name = $_FILES['documento']['name'];
   		$file_size = $_FILES['documento']['size'];
    	$file_tmp = $_FILES['documento']['tmp_name'];
    	$file_type = $_FILES['documento']['type'];
    	$fp = fopen($file_tmp, 'r+b');
    	$binario = fread($fp, filesize($file_tmp));
    	fclose($fp);*/

    	$datos = array(
    		'secuencia' => $secuencia,
    		'id_usuario' => $id_usuario,
    		'id_area' => $id_area,
    		'lote' => $lote,
    		'aseguradora' => $aseguradora,
    		'cantidad_factura' => $cantidad_factura,
    		'fecha_llegada' => $fecha_llegada,
    		'fecha_solucionado' => $fecha_solucionado,
    		'observacion' => $observacion,
    	//	'nombre_documento' =>$nombre_documento,
    		//'documento' => $binario,
    		'estado' => 'P'
    	);
    	if($this->registrartramasistemas_model->insertar("proceso_tramas",$datos)){
    		redirect(base_url().'tramas/sistemas/registrartrama');
    	}
    	else{
    		$this->session->set_flashdata("error","No se puede guardar la información");
    		redirect(base_url()."tramas/sistemas/registrartrama");
    	}
    	

    	
	}

	


}