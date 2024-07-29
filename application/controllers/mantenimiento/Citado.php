<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 
 */

 class Citado extends CI_Controller
 {
     private $permisos;
     public function __construct()
     {
        parent::__construct();
        if(!$this->session->userdata("login")){
            redirect(base_url());
        }
        $this->permisos = $this->backend_lib->control();
        $this->load->model('citado_model');
     }

     public function index()
     {
        $data['permisos'] =$this->permisos;
         $this->load->view('layouts/header');
         $this->load->view('layouts/aside');
         $this->load->view('admin/citado/listarcitado',$data);
         $this->load->view('layouts/footer');
 
     }

     public function jsoncitado()
     {
         $data['start'] = $this->input->get_post('start', true);
         $data['length'] = $this->input->get_post('length', true);
         $data['sEcho']  = $this->input->get_post('_', true);
         $columns= array('cod_citado','nomb_citado','esta_citado');
         $orderCampo = $this->input->get_post('order', true);
         $orderCampo = $orderCampo[0]['column'];
         $orderCampo = $columns[$orderCampo];
         $orderDireccion = $this->input->get_post('order', true);
         $orderDireccion = $orderDireccion[0]['dir'];
         $data['orderCampo'] = $orderCampo;
         $data['orderDireccion'] = $orderDireccion;
         $tipo_citado = $this->input->get_post('tipo_citado');
         if ($tipo_citado!='') {
             $data['tipo_citado'] = $tipo_citado;
         }
         $datos = $this->citado_model->getcitado($data);
         header('content-type: application/json; charset=utf-8');
         echo json_encode($datos);
     }

     public function nuevo()
     {
 
         $this->load->view('layouts/header');
         $this->load->view('layouts/aside');
         $this->load->view('admin/citado/agregarcitado');
         $this->load->view('layouts/footer');
 
     }

     public function validaCitado()
	{
		if ($this->input->is_ajax_request()) {
			$citado = $this->input->get('nomb_citado');
			$verifica = $this->modelgeneral->verificaUnico('tipo_citado','nomb_citado',$citado);
			if ($verifica) {
				echo 'true';
			}else{
				echo 'false';
			}
		}
	}

     public function guardar()
     {
         $this->form_validation->set_rules('nombre','','required|is_unique[tipo_citado.nomb_citado]|validaCitado');
         $this->form_validation->set_rules('estado','','requerid');
     
 
         $data = array(
             
             'nomb_citado' => $this->input->post('nombre'),
             'esta_citado' => $this->input->post('estado')
         );
 
         $insert = $this->citado_model->agregarcitado($data);
             if(!is_null($insert)){
                 $this->session->set_flashdata('success', 'Te has registrado correctamente en nuestro sistema.<br>Hemos enviado un código de verificación a ');
                 $resp['success']=true;
             }
         echo json_encode(array("status" => TRUE));
 
         redirect(base_url().'mantenimiento/citado');
     }

     public function editar($id)
	{
		$data['citado'] = $this->citado_model->getcitadoid($id);
		$this->load->view('layouts/header');
		$this->load->view('layouts/aside');
		$this->load->view('admin/citado/actualizarcitado',$data);
		$this->load->view('layouts/footer');
    }
    
    public function update()
	{
			
		$codigo=$this->input->post('codigo');
        $nombre=$this->input->post('nombre');
		$estado=$this->input->post('estado');

		$NombreActual = $this->citado_model->getcitadoid($codigo);

		if($nombre == $NombreActual->nomb_citado){
			$is_unique ="";

		}else{
			$is_unique= '|is_unique[tipo_citado.nomb_citado]';

		}

		$this->form_validation->set_rules("codigo","codigo","required");
        $this->form_validation->set_rules("nombre","nombre","required".$is_unique);
		$this->form_validation->set_rules("estado","estado","required");

		if($this->form_validation->run()==true){
			$data  = array(
				'cod_citado' =>$codigo,
                'nomb_citado'=>$nombre,
				'esta_citado'=>$estado
				);

				
		if($this->citado_model->update($codigo,$data)){
				$this->session->set_flashdata('success', 'Te has registrado correctamente en nuestro sistema.<br>Hemos enviado un código de verificación a ');
			redirect(base_url().'mantenimiento/citado');
			//var_dump($data);
			
		}
		else{
		
				redirect(base_url().'mantenimiento/citado/editar'.$codigo);

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
			'esta_citado'=> 'N');
			$this->citado_model->update($id,$data);
			$resp['success'] = true;
			echo json_encode($resp);
	        
	  }
     


    
 }