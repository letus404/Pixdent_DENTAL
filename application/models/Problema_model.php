<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Problema_model extends CI_Model
{
	
	public function GetProblema()
	{
		$this->db->where("estado","1");
		$resultados=$this->db->get("tipo_problema");
		return $resultados->result();
	}

	public function add($data)
	{
		$this->db->insert("tipo_problema",$data);
		return $this->db->insert_id();
	}

	public function getProblema_Id($id){
		$this->db->from("tipo_problema");
		$this->db->where('id_tipo_problema',$id);
		$query = $this->db->get();

		return $query->row();
	}

	public function problema_update($where,$data)
	{
		$this->db->update("tipo_problema",$data,$where);
		return $this->db->affected_rows();
	}
	
	public function update_problema($id,$data)
	{
		$this->db->where("id_tipo_problema",$id);
		return $this->db->update("tipo_problema",$data);
	}
}