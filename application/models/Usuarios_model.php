<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
* 
*/
class Usuarios_model extends CI_Model
{
	public function login($username,$paswoord)
	{
		$this->db->where("logi_usu",$username);
		$this->db->where("pass_usu",$paswoord);
		$this->db->where("esta_usu","1");
		$resultados=$this->db->get("usuario");
		if ($resultados->num_rows()>0) {
			return $resultados->row();
		}else{
			return false;
		}
	}

	
	
}


?>