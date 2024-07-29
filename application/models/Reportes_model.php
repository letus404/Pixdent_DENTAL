<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
* 
*/
/**
* 
*/

class Reportes_model extends CI_Model
{
	public function years()
	{
		$this->db->select("YEAR(fecha_registro) as year");
		$this->db->from("carita_admision");
		$this->db->group_by("year");
		$this->db->order_by("year","desc");
		$resultados = $this->db->get();
		return $resultados->result(); 
	}

      public function total($year){
		$this->db->select("MONTH(fecha_registro) as mes, count(tipo_carita) as totalcarita");
		$this->db->from("carita_admision");
		$this->db->where("fecha_registro >=",$year."-01-01");
		$this->db->where("fecha_registro <=",$year."-12-31");
		$this->db->group_by("mes");
		$this->db->order_by("mes");
		$resultados = $this->db->get();
		return $resultados->result();
	}

	public function rowCount(){
		$this->db->where("tipo_carita","E");

	    $this->db->from("carita_admision");
	    $resultados = $this->db->get();
		return $resultados->num_rows();

	}

	// public function rowCount($tabla){
	// 	if ($tabla =="carita_admision") {
	// 		$this->db->where("tipo_carita","E");
	// 	//	$this->db->where("tipo_carita","B");
	// 		// $this->db->where("tipo_carita","B");
	// 		// $this->db->where("tipo_carita","R");
	// 		// $this->db->where("tipo_carita","P");
	// 		// $this->db->where("tipo_carita","M");
	// 	}
	// else {
	// 		$this->db->where("tipo_carita","B");
	// }

		
	// 	 $resultados = $this->db->get($tabla);
	//  	return $resultados->num_rows();

	// }

	public function RowCountbueno(){
		$this->db->where("tipo_carita","B");
	    $this->db->from("carita_admision");
	    $resultados = $this->db->get();
		return $resultados->num_rows();

	}

	public function RowCountRegular(){
		$this->db->where("tipo_carita","R");
	    $this->db->from("carita_admision");
	    $resultados = $this->db->get();
		return $resultados->num_rows();

	}

	public function RowCountPesimo(){
		$this->db->where("tipo_carita","P");
	    $this->db->from("carita_admision");
	    $resultados = $this->db->get();
		return $resultados->num_rows();

	}

	public function RowCountMalo(){
		$this->db->where("tipo_carita","M");
	    $this->db->from("carita_admision");
	    $resultados = $this->db->get();
		return $resultados->num_rows();

	}




}