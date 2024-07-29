<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
* 
*/
class Caritas_model extends CI_Model
{
	public function getCaritas()
	{
		$query = $this->db->query("SELECT * FROM carita_admision");
		return $query->result_array();
	}

	public function getCaritasEmergencia()
	{
		$query = $this->db->query("SELECT * FROM carita_emergencia");
		return $query->result_array();
	}

	public function getCaritasMedico()
	{
		$query = $this->db->query("SELECT * FROM carita_atencion_medico");
		return $query->result_array();
	}

	public function getCaritasFarmacia()
	{
		$query = $this->db->query("SELECT * FROM carita_farmacia");
		return $query->result_array();
	}

	public function getCaritasHospitalizacion()
	{
		$query = $this->db->query("SELECT * FROM carita_hospitalizacion");
		return $query->result_array();
	}



	public function GuardarAdmision($data){
		$this->db->insert("carita_admision",$data);
		return $this->db->insert_id();
	}

	public function GuardarEmergencia($data){
		$this->db->insert("carita_emergencia",$data);
		return $this->db->insert_id();
	}

	public function GuardarMedico($data){
		$this->db->insert("carita_atencion_medico",$data);
		return $this->db->insert_id();
	}

	public function GuardarFarmacia($data){
		$this->db->insert("carita_farmacia",$data);
		return $this->db->insert_id();
	}

	public function GuardarHospitalizacion($data){
		$this->db->insert("carita_hospitalizacion",$data);
		return $this->db->insert_id();
	}


	
	
} 

