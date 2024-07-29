<?php
defined('BASEPATH') OR exit('No direct script access allowed');


/**
* 
*/
class Ocurrencias_model extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();
	}

	function insertar($tabla,$data)
	{
		$this->db->insert($tabla,$data);
		return $this->db->insert_id();
	}

	public function getArchivos()
	{
		$query = $this->db->query("SELECT * FROM ocurrencia");
		return $query->result_array();
	}
}