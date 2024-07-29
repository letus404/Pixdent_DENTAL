<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Recibidos_model extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();
	}

	// function insertar($tabla,$data)
	// {
	// 	$this->db->insert($tabla,$data);
	// 	return $this->db->insert_id();
	// }

	public function GetRecibidos()
	{
		$sql="SELECT o.id_ocurrencia, CONCAT( u.apellidos,'  ', u.nombres) as usuario, a.nombre_area, o.fecha_problema, o.fecha_registro,o.fecha_finalizado,o.estado
			FROM `ocurrencia` o
			INNER JOIN usuario u on o.id_usuario=u.id_usuario
			INNER join area a on o.id_area=a.id_area
			ORDER BY o.id_ocurrencia desc";

		$query=$this->db->query($sql);
		return $query->result();
	}

	public function GetRecibidos_Id($id){
		$this->db->from("ocurrencia");
		$this->db->where('id_ocurrencia',$id);
		$query = $this->db->get();

		return $query->row();

	}


	public function recibidos_update($where,$data)
	{
		$this->db->update("ocurrencia",$data,$where);
		return $this->db->affected_rows();
	}
	
	public function update_recibidos($id,$data)
	{
		$this->db->where("id_ocurrencia",$id);
		return $this->db->update("ocurrencia",$data);
	}
}