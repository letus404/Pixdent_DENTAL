<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
* 
*/
class Usuarios_model extends CI_Model
{
	public function login($username,$paswoord)
	{
		log_message('debug', 'Attempting login with Username: ' . $username . ' and Password: ' . $password);

		$this->db->where("logi_usu",$username);
		$this->db->where("paswoord",$paswoord);
		$this->db->where("esta_usu","1");
		$resultados=$this->db->get("usuario");

		log_message('debug', 'Database Query Result: ' . print_r($resultados->result(), true));
        

		if ($resultados->num_rows()>0) {
			return $resultados->row();
		}else{
			return false;
		}
	}	
	
}


?>