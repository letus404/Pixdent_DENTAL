<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
* 
*/
class Areas_model extends CI_Model
{
	public function getAreas(){
		$this->db->where("estado","1");
		$resultados = $this->db->get("area");
		return $resultados->result();

	}

	public function getArea_Id($id){
		$this->db->from("area");
		$this->db->where('id_area',$id);
		$query = $this->db->get();

		return $query->row();

	}

	public function area_update($where,$data)
	{
		$this->db->update("area",$data,$where);
		return $this->db->affected_rows();
	}
	
	public function update_area($id,$data)
	{
		$this->db->where("id_area",$id);
		return $this->db->update("area",$data);
	}

	public function add($data)
	{
		$this->db->insert("area",$data);
		return $this->db->insert_id();
	}
	
} 

