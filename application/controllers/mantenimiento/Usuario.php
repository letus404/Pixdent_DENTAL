<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Usuario extends CI_Controller
{
	private $permisos;
	public function __construct()
	{
		parent::__construct();
		 if(!$this->session->userdata("login")){
            redirect(base_url());
        }
        $this->permisos = $this->backend_lib->control();
		$this->load->model(array("user_model","Roles_model","modelgeneral"));
		# code...
	}

	
	public function index()
	{	
		$data['permisos'] =$this->permisos;
		$data =  array('user' => $this->user_model->getUser(),
					'rol'=>$this->modelgeneral->getTable('rol'),
					'usuario'=> $this->modelgeneral->getTable('usuario'),
				
		 );

		$this->load->view('layouts/header');
		$this->load->view('layouts/aside');
		$this->load->view('admin/usuario/list_usuario',$data);
		$this->load->view('layouts/footer');


	}

	 public function jsonUsu()
     {
        $data['start'] = $this->input->get_post('start', true);
		$data['length'] = $this->input->get_post('length', true);
        $data['sEcho']  = $this->input->get_post('_', true);
        $columns= array('codi_usu','NombreUsuario','logi_usu','rol','email','fecha_registro');
		$orderCampo = $this->input->get_post('order', true);
		$orderCampo = $orderCampo[0]['column'];
		$orderCampo = $columns[$orderCampo];
		$orderDireccion = $this->input->get_post('order', true);
		$orderDireccion = $orderDireccion[0]['dir'];
		$data['orderCampo'] = $orderCampo;
		$data['orderDireccion'] = $orderDireccion;
		$desde = $this->input->get_post('desde');
		$hasta = $this->input->get_post('hasta');
        $usuario = $this->input->get_post('usuario');
        $rol = $this->input->get_post('rol');
		if ($desde!='' AND $hasta!='') {
			$data['desde'] = $desde;
			$data['hasta'] = $hasta;
		}
		if ($usuario!='') {
			$data['usuario'] = $usuario;
		}

		if ($rol!='') {
			$data['rol'] = $rol;
		}
		$datos = $this->user_model->getUsuario($data);
		header('content-type: application/json; charset=utf-8');
		echo json_encode($datos);
     }

	public function add()
	{	
		$data =  array('user' => $this->user_model->getUser(),
					'rol'=>$this->modelgeneral->getTable('rol'),
				
		 );
		
		$this->load->view('layouts/header');
		$this->load->view('layouts/aside');
		$this->load->view('admin/usuario/add',$data);
		$this->load->view('layouts/footer');
	}

	public function user_add()
	{		
			 $fecharegistro = date("Y-m-d H:i:s");
			 $apellido = $this->input->post('apellido');
			 $nombre = $this->input->post('nombre');
			 $telefono = $this->input->post('telefono');
			 $direccion = $this->input->post('direccion');
			 $email = $this->input->post('email');
			 $tipo_documento = $this->input->post('tipo_documento');
			 $documento = $this->input->post('documento');
			 $foto = $this->input->post('foto');
			 $codi_rol = $this->input->post('codi_rol');
			 $logi_usu = $this->input->post('logi_usu');
			 $pass_usu = sha1($this->input->post('pass_usu'));
			 $esta_usu = $this->input->post('esta_usu');
			 $data = array(
					'apellido' => $apellido,
					'nombre' => $nombre,
					'telefono' => $telefono,
					'direccion' => $direccion,
					'email' => $email,
					'tipo_documento' => $tipo_documento,
					'documento' => $documento,
					'foto' => $foto,
					'codi_rol' => $codi_rol,
					'logi_usu' => $logi_usu,
					'pass_usu' => $pass_usu,
					'fecha_registro' => $fecharegistro,
					'esta_usu'=> $esta_usu
		);
		if($this->user_model->agregarusuario($data)){
			redirect(base_url()."mantenimiento/usuario");
		}
		else{
			$this->session->set_flashdata("error","No se pudo guardar el usuario");
			redirect(base_url()."mantenimiento/usuario/user_add");
		}
	
	}

	
	

	  function getUsuario()
	{
		$id = $this->input->get('id');
		$usuario = $this->modelgeneral->getTableWhereRow('usuario',['codi_usu'=>$id]);
		echo json_encode($usuario);
	}

	function editUsuario()
     {
         $this->form_validation->set_rules('id','','required');
         $this->form_validation->set_rules('apellido','','required');
         $this->form_validation->set_rules('nombre','','required');
          $this->form_validation->set_rules('telefono','','required');
         $this->form_validation->set_rules('direccion','','required');
         $this->form_validation->set_rules('email','','required|min_length[3]|valid_email|trim');
         $this->form_validation->set_rules('tipo_documento','','required');
         $this->form_validation->set_rules('documento','','required');
         $this->form_validation->set_rules('codigorol','','required');
         $this->form_validation->set_rules('login','','required');
      //    $this->form_validation->set_rules('fecharegistro','','required');
         $this->form_validation->set_rules('estado','','required');
         if($this->form_validation->run() == TRUE){
 
             $data['apellido'] = $this->input->post('apellido');
             $data['nombre'] = $this->input->post('nombre');
             $data['telefono'] = $this->input->post('telefono');
             $data['direccion'] = $this->input->post('direccion');
             $data['email'] = $this->input->post('email');
             $data['tipo_documento'] = $this->input->post('tipo_documento');
             $data['documento'] = $this->input->post('documento');
             $data['codi_rol'] = $this->input->post('codigorol');
             $data['logi_usu'] = $this->input->post('login');
             if (isset($_POST['passwoord'])) {
                $data['pass_usu'] = sha1($this->input->post('passwoord'));
             }
            $data['esta_usu']= $this->input->post('estado');
             $where['codi_usu'] = $this->input->post('id');
             $edit = $this->modelgeneral->editRegist('usuario',$where,$data);
             $resp =[];
             if(!is_null($edit)){
                 $resp['success'] = true;
             }else{
                 $resp['success'] = false;
             }
             echo json_encode($resp);
         }
     }


	    function anularUsuario()
	     {
        $data['esta_usu'] = 2; //ANULAR	
        $where['codi_usu'] = $this->input->get('id');  
		
		$edit = $this->modelgeneral->editRegist('usuario',$where,$data);
		$resp = [];
		if ($edit) {
			$resp['success'] = true;
		}else{
			$resp['success'] = false;
		}
		echo json_encode($resp);
	     }

}