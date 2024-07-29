<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Backend_model extends CI_Model
{
	public function getID($link){
		$this->db->like("link",$link);
		$resultado = $this->db->get("menus");
		return $resultado->row();

	}

	public function getPermisos($menu,$rol){
		$this->db->where("id_menu",$menu);
		$this->db->where("codi_rol",$rol);
		$resultado = $this->db->get("permisos");
		return $resultado->row();
	}
}