<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
* 
*/
/**
* 
*/

class Reports_model extends CI_Model
{
	public function years()
	{
		$this->db->select("YEAR(fecha_tra) as year");
		$this->db->from('tratamiento');
		$this->db->group_by("year");
		$this->db->order_by("year","desc");
		$resultados = $this->db->get();
		return $resultados->result(); 
	}

      public function GeTrataCobrado($year){
		$this->db->select("MONTH(fecha_tra) as mes, sum(total_tra) as montos");
		$this->db->from('tratamiento');
		$this->db->where("fecha_tra >=",$year."-01-01");
		$this->db->where("fecha_tra <=",$year."-12-31");
		$this->db->where('estadopago_tra','3');
		$this->db->where('estado_tra','1');
		$this->db->group_by("mes");
		$this->db->order_by("mes");
		$resultados = $this->db->get();
		return $resultados->result();
	}


	   public function GeTrataPorCobrar($year){
		$this->db->select("MONTH(fecha_tra) as mes, sum(total_tra) as cobrar");
		$this->db->from('tratamiento');
		$this->db->where("fecha_tra >=",$year."-01-01");
		$this->db->where("fecha_tra <=",$year."-12-31");
		$this->db->where('estadopago_tra','1');
		$this->db->where('estado_tra','1');
		$this->db->group_by("mes");
		$this->db->order_by("mes");
		$resultados = $this->db->get();
		return $resultados->result();
	}


	public function rowCountPacientes(){
		$this->db->where('esta_pac','S');
	    $this->db->from('paciente');
	    $resultados = $this->db->get();
		return $resultados->num_rows();

	}

	public function rowCountTratamientos(){
		$this->db->where('estadopago_tra','3');
	    $this->db->from('tratamiento');
	    $resultados = $this->db->get();
		return $resultados->num_rows();

	}

	public function rowCountTratamientosCobrar(){
		$this->db->where('estadopago_tra','1');
	    $this->db->from('tratamiento');
	    $resultados = $this->db->get();
		return $resultados->num_rows();

	}

	public function rowCountMedicos(){
		$this->db->where('esta_med','S');
	    $this->db->from('medico');
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