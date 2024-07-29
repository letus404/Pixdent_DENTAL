<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Registrar extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		if(!$this->session->userdata("login")){
			redirect(base_url());
		}
		$this->load->model('modelgeneral');
		$this->load->model('citas_model');
		$this->load->library('email');
		$this->load->helper('general');
	}

	public function index()
	{
		$data['especialidad'] = $this->db->from('especialidad')
														->order_by('nombre_especialidad','asc')
														->get()->result();
		$data['sedes'] = $this->modelgeneral->getTable('sede');
		$data['tipo_citado'] = $this->modelgeneral->getTable('tipo_citado');
		$this->load->view('layouts/header');
		$this->load->view('layouts/aside');
		$this->load->view('admin/citas/registrar',$data);
		$this->load->view('layouts/footer');
	}

	public function getMedicos()
	{
		$especialidad = $this->input->post('especialidad');

		$medicos = $this->db->from('medico')
		->where('cod_especialidad',$especialidad)
		->get()->result();

		echo json_encode($medicos);
	}

	public function getCitaDia()
	{
		$hora = '07:00';
		$arrayHoras = [];
		for ($i=0; $hora!='20:15'; $i++) { 
			$arrayHoras[$i]['hora'] = $hora;
			$nuevaHora = strtotime ('+15 minute',strtotime($hora));
			$nuevaHora = date ('H:i',$nuevaHora);
			$hora = $nuevaHora;
			$i++;
		}

		$fecha = $this->input->get('fecha');
		$medico = $this->input->get('medico');
		$especialidad = $this->input->get('especialidad');
		$dia = $this->citas_model->citasDia($fecha,$medico,$especialidad);

		foreach ($dia->result() as $d) {
			$hora = date('H:i',strtotime($d->fech_cit));
			foreach ($arrayHoras as $key => $value) {
				if ($hora==$value['hora']) {
					$arrayHoras[$key]['id_cita'] = $d->codi_cit;
					$arrayHoras[$key]['id_paciente'] = $d->codi_pac;
					$arrayHoras[$key]['paciente'] = $d->nomb_pac.' '.$d->apel_pac;
					$arrayHoras[$key]['observacion'] = $d->obsv_cit;
					$arrayHoras[$key]['estado'] = $d->nomb_citado;
					$arrayHoras[$key]['fila'] = filaEstadoCita($d->cod_citado);
					$arrayHoras[$key]['btn-editar'] = '';

					/*$estadosAnulables = [3,5,6,7,8,9];
					if (in_array($d->cod_citado,$estadosAnulables)) {
					}*/
					$arrayHoras[$key]['btn-editar'] = '<button class="editar btn btn-xs btn-warning" data-id="'.$d->codi_cit.'"><i class="fa fa-edit"></i></button>';
				}
			}
		}

		$resp = [];
		$resp['horas'] = $arrayHoras;
		$resp['especialidad'] = $especialidad;
		$resp['medico'] = $medico;
		$queryMedico = $this->modelgeneral->getTableWhereRow('medico',['codi_med'=>$medico]);
		$resp['medico_nombre'] = $queryMedico->nomb_med.' '.$queryMedico->apel_med;
		$resp['fecha'] = $fecha;
		$resp['ocupados'] = $dia->num_rows();
		$resp['disponibles'] = 52 - $dia->num_rows();

		echo json_encode($resp);
	}

	public function getPacientes()
	{
		$q = $this->input->get('q');
		if ($q!='') {
			$pacientes = $this->citas_model->buscarPacientes($q);
			echo json_encode($pacientes);
		}
	}

	public function guardarCita()
	{
		$this->form_validation->set_rules('hora', '', 'required');
		$this->form_validation->set_rules('fecha', '', 'required');
		$this->form_validation->set_rules('medico', '', 'required');
		$this->form_validation->set_rules('especialidad', '', 'required');
		$this->form_validation->set_rules('paciente', '', 'required');
		$this->form_validation->set_rules('motivo', '', 'required');
		$this->form_validation->set_rules('observacion', '', '');
		if ($this->form_validation->run() == TRUE){
			$data['codi_pac'] = $this->input->post('paciente');
			$data['codi_med'] = $this->input->post('medico');
			$data['cod_especialidad'] = $this->input->post('especialidad');
			$data['motivo_consult'] = $this->input->post('motivo');
			$data['cod_sede'] = $this->input->post('sede');
			$data['cod_citado'] = $this->input->post('codigo');
			$data['fech_cit'] = $this->input->post('fecha').' '.$this->input->post('hora').':00';
			$data['obsv_cit'] = $this->input->post('observacion');
			$data['esta_cit'] = 1;
			$insert = $this->modelgeneral->insertRegist('cita_medica',$data);

			$resp = [];
			if (!is_null($insert)) {
				if ($this->input->post('notificar')=='on') {
					$this->enviarNotificacion($insert);
				}
				$resp['success'] = true;
			} else {
				$resp['success'] = false;
			}
			echo json_encode($resp);
		}
	}

	function validaPacienteUnico()
	{
		$paciente = $this->input->post('paciente');
		$medico = $this->input->post('medico');
		$fecha = $this->input->post('fecha');

		$query = $this->db->from('cita_medica')
		->where('codi_pac',$paciente)
		->where('codi_med',$medico)
		->where('esta_cit',1)
		->where('DATE(fech_cit)',$fecha)
		->where_not_in('cita_medica.cod_citado',[2])
		->get();

		if ($query->num_rows() == 0) {
			echo 'true';
		}else{
			echo 'false';
		}
	}



	function editarCita()
	{
		$this->form_validation->set_rules('id', '', 'required');
		$this->form_validation->set_rules('hora', '', 'required');
		$this->form_validation->set_rules('fecha', '', 'required');
		$this->form_validation->set_rules('medicoEditar', '', 'required');
		$this->form_validation->set_rules('especialidadEditar', '', 'required');
		$this->form_validation->set_rules('motivo', '', 'required');
		$this->form_validation->set_rules('observacion', '', '');
		if ($this->form_validation->run() == TRUE){
			$data['codi_med'] = $this->input->post('medicoEditar');
			$data['cod_especialidad'] = $this->input->post('especialidadEditar');
			$data['motivo_consult'] = $this->input->post('motivo');
			$data['cod_sede'] = $this->input->post('sede');
			$data['cod_citado'] = $this->input->post('codigo');
			$data['fech_cit'] = $this->input->post('fecha').' '.$this->input->post('hora').':00';
			$data['obsv_cit'] = $this->input->post('observacion');
			$where['codi_cit'] = $this->input->post('id');
			$edit = $this->modelgeneral->editRegist('cita_medica',$where,$data);

			$resp = [];
			if ($edit) {
				if ($this->input->post('notificar')=='on') {
					$this->enviarNotificacion($edit);
				}
				$resp['success'] = true;
			} else {
				$resp['success'] = false;
			}
			echo json_encode($resp);
		}
	}

}

/* End of file Registrar.php */
/* Location: ./application/controllers/citas/Registrar.php */