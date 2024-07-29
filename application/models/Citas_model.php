<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Citas_model extends CI_Model {
	
	function citasDia($fecha,$medico,$especialidad)
	{
		return $this->db->from('cita_medica')
		->select('codi_cit,fech_cit,nomb_pac,apel_pac,paciente.codi_pac,obsv_cit,cita_medica.cod_citado,nomb_citado')
		->join('paciente','cita_medica.codi_pac = paciente.codi_pac')
		->join('tipo_citado','cita_medica.cod_citado = tipo_citado.cod_citado')
		->where('DATE(fech_cit)',$fecha)
		->where('cita_medica.codi_med',$medico)
		->where('cita_medica.cod_especialidad',$especialidad)
		->where_not_in('cita_medica.cod_citado',[2])
		->get();
	}

	function buscarPacientes($paciente)
	{
		return $this->db->from('paciente')
		->select('codi_pac as id,CONCAT(COALESCE(nomb_pac,"")," ",COALESCE(apel_pac,"")) AS text')
		->having("text LIKE '%".$paciente."%'")
		->get()->result();
	}

	function getCita($cita)
	{
		return $this->db->from('cita_medica')
		->select('cita_medica.*,nomb_pac,apel_pac,medico.codi_med,nomb_med,apel_med,especialidad.cod_especialidad,sexo_pac,emai_pac,nomb_citado,nombre_sede')
		->join('paciente','cita_medica.codi_pac = paciente.codi_pac')
		->join('medico','cita_medica.codi_med = medico.codi_med')
		->join('especialidad','cita_medica.cod_especialidad = especialidad.cod_especialidad')
		->join('tipo_citado','cita_medica.cod_citado = tipo_citado.cod_citado')
		->join('sede','cita_medica.cod_sede = sede.cod_sede')
		->where('cita_medica.codi_cit',$cita)
		->get()->row();
	}

	function getCitas($desde,$hasta,$medico,$especialidad,$estado)
	{
		$this->db->from('cita_medica');
		$this->db->select("cita_medica.codi_cit,paciente.codi_pac,nomb_pac,apel_pac,nomb_med,apel_med,fech_cit,cita_medica.cod_citado,nomb_citado,telf_pac,esta_cit
		");
		$this->db->join('paciente','cita_medica.codi_pac = paciente.codi_pac');
		$this->db->join('medico','cita_medica.codi_med = medico.codi_med');
		$this->db->join('tipo_citado','cita_medica.cod_citado = tipo_citado.cod_citado');
		$this->db->where('DATE(fech_cit) >= ',$desde);
		$this->db->where('DATE(fech_cit) <= ',$hasta);
		if ($medico!='') {
			$this->db->where('medico.codi_med',$medico);
		}
		if ($especialidad!='') {
			$this->db->where('medico.cod_especialidad',$especialidad);
		}
		if ($estado!='') {
			$this->db->where('cita_medica.cod_citado',$estado);
		}
		$this->db->order_by('fech_cit','asc');
		return $this->db->get()->result();
	}

}

/* End of file Citas_model.php */
/* Location: ./application/models/Citas_model.php */