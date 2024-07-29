<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Listartramas_model extends CI_Model
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

	public function Getlistar()
	{
		$sql="SELECT p.secuencia,p.lote,p.cantidad_factura, CONCAT( u.apellidos,'  ', u.nombres) as usuario, a.nombre_area, p.fecha_llegada,p.fecha_solucionado,p.estado
			FROM `proceso_tramas` p
			INNER JOIN usuario u on p.id_usuario=u.id_usuario
			INNER join area a on p.id_area=a.id_area and  NOT p.estado ='S'
			ORDER BY p.secuencia desc";

		$query=$this->db->query($sql);
		return $query->result();
	}

	public function Getlistar_id($id){
		$this->db->from("proceso_tramas");
		$this->db->where('secuencia',$id);
		$query = $this->db->get();

		return $query->row();

	}


	public function tramas_update($where,$data)
	{
		$this->db->update("proceso_tramas",$data,$where);
		return $this->db->affected_rows();
	}
	
	public function update_tramas($id,$data)
	{
		$this->db->where("secuencia",$id);
		return $this->db->update("proceso_tramas",$data);
	}
}