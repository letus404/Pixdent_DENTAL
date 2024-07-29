<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Agenda extends CI_Controller {
	private $permisos;
	public function __construct()
	{
		parent::__construct();
		if(!$this->session->userdata("login")){
			redirect(base_url());
		}
		$this->load->model('modelgeneral');
		$this->load->model('citas_model');
		$this->load->helper('general');
		$this->permisos = $this->backend_lib->control();
	}

	public function index()
	{
		$data['especialidad'] = $this->db->from('especialidad')
														->order_by('nombre_especialidad','asc')
														->get()->result();
		$data['estados'] = $this->modelgeneral->getTable('tipo_citado');
		$data['permisos'] =$this->permisos;
		$this->load->view('layouts/header');
		$this->load->view('layouts/aside');
		$this->load->view('admin/citas/agenda',$data);
		$this->load->view('layouts/footer');
	}

	public function calendario()
	{
		//Capturar las fechas que envian desde el front
		$desde = date("Y-m-d", $this->input->get('from') / 1000);
		$hasta = strtotime('-1 day',$this->input->get('to') / 1000);
		$hasta = date("Y-m-d", $hasta);
		$anio = explode('-',$desde)[0];
		$mes = explode('-',$desde)[1];

		$medico = $this->input->get('medico');
		$especialidad = $this->input->get('especialidad');
		$estado = $this->input->get('estado');


		$data = [];
		$data['success'] = 1;

		$citas = $this->citas_model->getCitas($desde,$hasta,$medico,$especialidad,$estado);

		$semana = $this->citasDeSemana($citas);

		foreach ($citas as $c) {

			$inicio = strtotime($c->fech_cit);
			$fin = strtotime('+15 minute',strtotime(date($c->fech_cit)));
			$result[] = [
				'id' => $c->codi_cit,
				"start" => strtotime(date($c->fech_cit)) * 1000, // Milliseconds
				"end" => strtotime('+15 minute',strtotime(date($c->fech_cit))) * 1000, //Milliseconds
				'class' => 'event-'.classAgendaCita($c->cod_citado),
				'title' => $c->nomb_pac.' '.$c->apel_pac,
				'url' => base_url('citas/agenda/getCita/'.$c->codi_cit),
				'inicio' => date('H:i:s',$inicio),
				'fin' => date('H:i:s',$fin),
				'telefono' => $c->telf_pac,
				'medico' => $c->nomb_med.' '.$c->apel_med,
				'estado' => estadoCita($c->cod_citado)				
			];

			$semana[date('H:i',$inicio)][date('N',$inicio)] = $c->nomb_pac.' '.$c->apel_pac;
		}
		$data['success'] = 1;
		$data['semana'] = $semana;
		$data['result'] = $result;
		$data['medico'] = $medico;
		$data['espe'] = $especialidad;
		echo json_encode($data);
	}

	private function citasDeSemana($citas)
	{
		$horas = [];
		foreach ($citas as $c) {
			$hora = date('H:i',strtotime($c->fech_cit));
			if (!in_array($hora,$horas)) {
				$horas[] = $hora;
			}
		}

		$semana = [];
		foreach ($horas as $key => $value) {
			$array = [
				'Hora' => $value,
				1 => '',2 => '',3 => '',4 => '',
				5 => '',6 => '',7 => ''
			];
			$semana[$value] = $array;
		}

		return $semana;
	}

	function getCita($id)
	{
		$data['cita'] = $this->citas_model->getCita($id);
		$this->load->view('admin/citas/modal_calendario',$data);
	}

}

/* End of file Agenda.php */
/* Location: ./application/controllers/citas/Agenda.php */