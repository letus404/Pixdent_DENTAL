<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class User_model extends CI_Model
{

	function getUsuario($data)
    {
        $this->db->from('usuario');
        $queryTotal = $this->db->get();
        $this->db->from('usuario');
        $this->db->join('rol','usuario.codi_rol = rol.codi_rol');
        $this->db->select('usuario.* , codi_usu, CONCAT(apellido, " ",nombre) as NombreUsuario, 
        logi_usu, nomb_rol as rol, email, fecha_registro');

        if(isset($data['usuario'])){
            $this->db->having("NombreUsuario LIKE '%".$data['usuario']."%'");
        }

        if (isset($data['desde']) AND isset($data['hasta'])) {
			$this->db->where('fecha_registro >=',$data['desde']);
			$this->db->where('fecha_registro <=',$data['hasta']);
        }
        if (isset($data['rol'])) {
			$this->db->where('rol.codi_rol',$data['rol']);
		}
        $queryLike = $this->db->get();
         $this->db->from('usuario');
        $this->db->join('rol','usuario.codi_rol = rol.codi_rol');
        $this->db->select('usuario.* , codi_usu, CONCAT(apellido, " ",nombre) as NombreUsuario, 
        logi_usu, nomb_rol as rol, email,fecha_registro');

        if ($data['length']!=-1) {
			$this->db->limit($data['length'],$data['start']);
        }
        if (isset($data['orderCampo'])) {
			$this->db->order_by($data['orderCampo'],$data['orderDireccion']);
        }
        if(isset($data['usuario'])){
            $this->db->having("NombreUsuario LIKE '%".$data['usuario']."%'");
        }

        if (isset($data['desde']) AND isset($data['hasta'])) {
			$this->db->where('fecha_registro >=',$data['desde']);
			$this->db->where('fecha_registro <=',$data['hasta']);
        }
        if (isset($data['rol'])) {
			$this->db->where('rol.codi_rol',$data['rol']);
        }
        
        $query = $this->db->get();

		$result = array();
		$result['sEcho'] = $data['sEcho'];
		$result['iTotalRecords'] = $queryTotal->num_rows();
        $result['iTotalDisplayRecords'] = $queryLike->num_rows();
        
        $row = [];
		foreach ($query->result() as $q) {

				if ($q->esta_usu=='1') {
				$estado = '<label class="label label-success">Activo</label>';
			}elseif($q->esta_usu=='2'){
				$estado = '<label class="label label-info">Inactivo</label>';
			}	


			$botones = '<div class="btn-footer text-center">
		<button data-id="'.$q->codi_usu.'" class="editar-usuario btn btn-primary waves-effect waves-light" 
		data-toggle="modal" data-target="#ModalEditarUsuario" style="padding:2px 5px;margin:0px 2px"><i class="fa fa-edit"></i></button>';                                      
		$botones .= '<a></a> <button data-id="'.$q->codi_usu.'" class="anular-usuario btn btn-danger waves-effect waves-light" style="padding:2px 4px;margin:0px 2px"><i class="fa fa-trash"></i></button>';


                                                  

			$row[] = [$q->codi_usu,$q->NombreUsuario,$q->logi_usu,$q->rol,$q->email,$q->fecha_registro,$estado,$botones];
		}
		$result['aaData'] = $row;
		return $result;
    }
	
	public function getUser(){
		$this->db->select("u.*, r.nomb_rol as rol");
		$this->db->from("usuario u");
	 $this->db->join("rol r","u.codi_rol=r.codi_rol");
		
		$resultados = $this->db->get();
		return $resultados->result();
	}



	public function agregarusuario($data)
	{	
		
		$this->db->insert("usuario",$data);
		return $this->db->insert_id();
	}

	function deleteuser(){
		$id = $this->input->get('codi_usu');
		$this->db->where('codi_usu',$id);
		$this->db->update('usuario');
		if($this->db->affected_rows()>0){
			return true;
		}else
		{
			return false;
		}
	}
	public function user_update($where,$data)
	{
		$this->db->update("usuario",$data,$where);
		return $this->db->affected_rows();
	}
	
	public function update_user($id,$data)
	{
		$this->db->where("codi_usu",$id);
		 $this->db->update("usuario",$data);
	}

	function verificaLogin($email,$password)
	{
		$query = $this->db->from('usuario')
		->where('email',$email)
		->where('pass_usu',$password)
		->get();

		if ($query->num_rows() > 0) {
			return $query->row();
		}else{
			return false;
		}
	}
}