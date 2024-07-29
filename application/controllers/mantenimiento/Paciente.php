<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Paciente extends CI_Controller
{
	private $permisos;
	public function __construct()
	{
		parent::__construct();
		if(!$this->session->userdata("login")){
			redirect(base_url());
		}
		$this->load->model('pacientes_model');
		$this->load->model('modelgeneral');
		$this->permisos = $this->backend_lib->control();
		# code...
	}


	public function index()
	{
		
		$data['permisos'] =$this->permisos;
		$this->load->view('layouts/header');
		$this->load->view('layouts/aside');
		$this->load->view('admin/paciente/listarpaciente',$data);
		$this->load->view('layouts/footer');


	}

	public function jsonpaciente()
	{
		$data['start'] = $this->input->get_post('start', true);
		$data['length'] = $this->input->get_post('length', true);
		$data['sEcho']  = $this->input->get_post('_', true);
		$columns = array('codi_pac','NombrePaciente','edad_pac','dni_pac','dire_pac','fecha_registro','esta_pac');
		$orderCampo = $this->input->get_post('order', true);
		$orderCampo = $orderCampo[0]['column'];
		$orderCampo = $columns[$orderCampo];
		$orderDireccion = $this->input->get_post('order', true);
		$orderDireccion = $orderDireccion[0]['dir'];
		$data['orderCampo'] = $orderCampo;
		$data['orderDireccion'] = $orderDireccion;
		$desde = $this->input->get_post('desde');
		$hasta = $this->input->get_post('hasta');
		$paciente = $this->input->get_post('paciente');
		
		if ($desde!='' AND $hasta!='') {
			$data['desde'] = $desde;
			$data['hasta'] = $hasta;
		}
		if ($paciente!='') {
			$data['paciente'] = $paciente;
		}
		
		$datos = $this->pacientes_model->getpaciente($data);
		header('content-type: application/json; charset=utf-8');
		echo json_encode($datos);
	}



	public function add()
	{
		$data['pais'] = $this->modelgeneral->getTable('paises');
		$data['departamentos'] = $this->modelgeneral->getTable('departamento');
		

		$this->load->view('layouts/header');
		$this->load->view('layouts/aside');
		$this->load->view('admin/paciente/agregarpaciente',$data);
		$this->load->view('layouts/footer');
	}



	public function getProvincias()
	{
		if($this->input->is_ajax_request()){
			$departamento = $this->input->get('departamento');
			$provincias = $this->modelgeneral->getTableWhere('provincia',['departamento_id'=>$departamento]);
			echo json_encode($provincias);
		}
	}

	public function getDistritos()
	{
			if($this->input->is_ajax_request()){
			$provincia = $this->input->get('provincia');
			$distritos = $this->modelgeneral->getTableWhere('distrito',['provincia_id'=>$provincia]);
			echo json_encode($distritos);
		}
	}

	public function guardar()
	{

		$this->form_validation->set_rules('nombre','','requerid');
		$this->form_validation->set_rules('apellidos','','requerid');
		$this->form_validation->set_rules('edad','','requerid');
		$this->form_validation->set_rules('ocupacion','','requerid');
		$this->form_validation->set_rules('lugarnacimiento','','requerid');
		$this->form_validation->set_rules('direccion','','requerid');
		$this->form_validation->set_rules('telefono','','requerid');
		$this->form_validation->set_rules('dni','','requerid');
		$this->form_validation->set_rules('fechanacimiento','','requerid');
		$this->form_validation->set_rules('sexo','','requerid');
		$this->form_validation->set_rules('estadocivil','','requerid');
		$this->form_validation->set_rules('email','','requerid');
		$this->form_validation->set_rules('pais','','requerid');
		$this->form_validation->set_rules('departamento','','requerid');

		$data = array(
			'nomb_pac' => $this->input->post('nombre'),
			'apel_pac' => $this->input->post('apellidos'),
			  'edad_pac' => $this->input->post('edad'),
			  'ocupacion' =>$this->input->post('ocupacion'),
			 'lugar_nacimiento' => $this->input->post('lugarnacimiento'),
			  'dire_pac'  => $this->input->post('direccion'),
			 'telf_pac' => $this->input->post('telefono'),
			 'dni_pac' =>$this->input->post('dni'),
			 'fena_pac' => $this->input->post('fechanacimiento'),
			 'sexo_pac' => $this->input->post('sexo'),
			 'civi_pac' =>$this->input->post('estadocivil'),
			'afil_pac' => $this->input->post('afiliado'),
			 'aler_pac' => $this->input->post('alergia'),
			  'emai_pac' => $this->input->post('email'),
			  'pais_id' => $this->input->post('pais'),
			 'departamento_id' => $this->input->post('departamento'),
			 'provincia_id' => $this->input->post('provincia'),
			 'distrito_id' => $this->input->post('distrito'),
			  'observacion'=> $this->input->post('observacion'),
			  'esta_pac' => $this->input->post('estado')
		);

		$config['upload_path'] = 'assets/uploads/pacientes/';
		$config['allowed_types'] = 'png|jpg|jpeg';
		$config['max_size'] = '40000';
		$config['max_width'] = '40000';
		$config['max_height'] = '40000';
		$this->upload->initialize($config);
		if ($this->upload->do_upload('foto_paciente')) {
			$fileData = $this->upload->data();
			$data['foto_paciente'] = $fileData['file_name'];
		}

		$insert = $this->pacientes_model->agregarpaciente($data);
		$primary['codi_pac'] = $insert;
		$this->modelgeneral->insertRegist('paciente_enfermedadactual',$primary);
		$this->modelgeneral->insertRegist('paciente_consulta',$primary);
		$this->modelgeneral->insertRegist('paciente_exploracion',$primary);

		redirect(base_url().'mantenimiento/paciente');
	}

	// else{
	// 	ECHO '<PRE>';
	// 	var_dump($_POST);
	// 	echo 'error validacion';
	// }

   public function editarPaciente($id)
	{
		$data['pacientes'] = $this->pacientes_model->getpacientes_id($id);
		$data['departamentos'] = $this->modelgeneral->getTable('departamento');
		$data['provincias'] = $this->modelgeneral->getTableWhere('provincia',['departamento_id'=>$data['pacientes']->departamento_id]);
		$data['distritos'] = $this->modelgeneral->getTableWhere('distrito',['provincia_id'=>$data['pacientes']->provincia_id]);	
		$this->load->view('layouts/header');
		$this->load->view('layouts/aside');
		$this->load->view('admin/paciente/editpaciente',$data);
		$this->load->view('layouts/footer');
	}








private function _do_upload()
	{
		$config['upload_path']          = 'upload/';
        $config['allowed_types']        = 'gif|jpg|png';
        $config['max_size']             = 1000; //set max size allowed in Kilobyte
        $config['max_width']            = 1000; // set max width image allowed
        $config['max_height']           = 1000; // set max height allowed
        $config['file_name']            = round(microtime(true) * 1000); //just milisecond timestamp fot unique name

        $this->load->library('upload', $config);

        if(!$this->upload->do_upload('photo')) //upload and validate
        {
            $data['inputerror'][] = 'photo';
			$data['error_string'][] = 'Upload error: '.$this->upload->display_errors('',''); //show ajax error
			$data['status'] = FALSE;
			echo json_encode($data);
			exit();
		}
		return $this->upload->data('file_name');
	}

	// public function paciente_edit($id)
	// {
	// 	$data = $this->pacientes_model->getpacientes_id($id);

	// 	echo json_encode($data);
	// }

	public function paciente_update()
	{
		$codi_pac=$this->input->post('codigo');
		$nombre = $this->input->post('nombre');
		$apellidos = $this->input->post('apellidos');
		$edad = $this->input->post('edad');
		$estudios = $this->input->post('estudios');
		$lugarnacimiento = $this->input->post('lugarnacimiento');
		$departamento = $this->input->post('departamento');
		$provincia = $this->input->post('provincia');
		$distrito = $this->input->post('distrito');
		$direccion = $this->input->post('direccion');
		$telefono = $this->input->post('telefono');
		$dni = $this->input->post('dni');
		$fechanacimiento = $this->input->post('fechanacimiento');
		$sexo = $this->input->post('sexo');
		$estadocivil = $this->input->post('estadocivil');
		$afiliado = $this->input->post('afiliado');
		$estado = $this->input->post('estado');
		$alergia = $this->input->post('alergia');
		$email = $this->input->post('email');
		$observacion = $this->input->post('observacion');



		$this->form_validation->set_rules('codigo','codigo','requerid');
		$this->form_validation->set_rules('nombre','','requerid');
		$this->form_validation->set_rules('apellidos','','requerid');
		$this->form_validation->set_rules('edad','','requerid');
		$this->form_validation->set_rules('estudios','','requerid');
		$this->form_validation->set_rules('lugarnacimiento','','requerid');
		$this->form_validation->set_rules('direccion','','requerid');
		$this->form_validation->set_rules('telefono','','requerid');
		$this->form_validation->set_rules('dni','','requerid');
		$this->form_validation->set_rules('fechanacimiento','','requerid');
		$this->form_validation->set_rules('sexo','','requerid');
		$this->form_validation->set_rules('estadocivil','','requerid');
		$this->form_validation->set_rules('email','','requerid');
		$this->form_validation->set_rules('departamento','','requerid');

		$data = array(
			'codi_pac' => $codi_pac,
			'nomb_pac' => $nombre,
			'apel_pac' => $apellidos,
			  'edad_pac' => $edad,
			  'estudios_pac' =>$estudios,
			 'lugar_nacimiento' => $lugarnacimiento,
			  'dire_pac'  => $direccion,
			 'telf_pac' =>$telefono,
			 'dni_pac' =>$dni,
			 'fena_pac' =>$fechanacimiento,
			 'sexo_pac' => $sexo,
			 'civi_pac' =>$estadocivil,
			'afil_pac' => $afiliado,
			 'aler_pac' =>$alergia,
			  'emai_pac' =>$email,
			 'departamento_id' => $departamento,
			 'provincia_id' => $provincia,
			 'distrito_id' => $distrito,
			  'observacion'=> $observacion,
			  'esta_pac' => $estado
		);

		$config['upload_path'] = 'assets/uploads/pacientes/';
		$config['allowed_types'] = 'png|jpg|jpeg';
		$config['max_size'] = '40000';
		$config['max_width'] = '40000';
		$config['max_height'] = '40000';
		$this->upload->initialize($config);
		if ($this->upload->do_upload('foto_paciente')) {
			$fileData = $this->upload->data();
			$data['foto_paciente'] = $fileData['file_name'];
		}

		if($this->pacientes_model->update($codi_pac,$data)){
				$this->session->set_flashdata('success', 'Actualizo correctamente los datos');
			redirect(base_url().'mantenimiento/paciente');
		}
		else
		{
		$this->editarPaciente($codi_pac);

		}
	}

	function anularPaciente()
	 {
		$where['codi_pac'] = $this->input->get('id');
		$data['esta_pac'] = N;//anulado
		$edit = $this->modelgeneral->editRegist('paciente',$where,$data);
		$resp = [];
		if ($edit) {
			$resp['success'] = true;
		}else{
			$resp['success'] = false;
		}

		echo json_encode($resp);
	 }





}
