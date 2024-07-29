<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Permisos_model extends CI_Model
{

	function getPerm($data)
	{
		$this->db->from('permisos');
		$queryTotal = $this->db->get();

		$this->db->from('permisos');
		$this->db->join('menus','permisos.id_menu = menus.id_menu');
		$this->db->join('rol','permisos.codi_rol = rol.codi_rol');
		$this->db->select('permisos.*, nombre as NombreMenu, nomb_rol as NombreRol');

		if (isset($data['menus'])) {
			$this->db->where('menus.id_menu',$data['menus']);
		}

		
		if (isset($data['rol'])) {
			$this->db->where('rol.codi_rol',$data['rol']);
		}
		$queryLike = $this->db->get();

		$this->db->from('permisos');
		$this->db->join('menus','permisos.id_menu = menus.id_menu');
		$this->db->join('rol','permisos.codi_rol = rol.codi_rol');
		$this->db->select('permisos.*, nombre as NombreMenu, nomb_rol as NombreRol');


		if ($data['length']!=-1) {
			$this->db->limit($data['length'],$data['start']);
		}

		if (isset($data['orderCampo'])) {
			$this->db->order_by($data['orderCampo'],$data['orderDireccion']);
		}
		if (isset($data['menus'])) {
			$this->db->where('menus.id_menu',$data['menus']);
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

				if ($q->read==0) {
				$estadoread = '<span style="color:#F80C0C;" class="fa fa-times"></span>';
			      }
			    elseif($q->read==1){
				$estadoread = '<span  style="color:#47A728;" class="fa fa-check"></span>';
			      }

			     if ($q->insert==0) {
				$estadoinsert = '<span style="color:#F80C0C;" class="fa fa-times"></span>';
			      }
			    elseif($q->insert==1){
				 $estadoinsert = '<span  style="color:#47A728;" class="fa fa-check"></span>';
			      }

			     if ($q->update==0) {
				$estadoupdate = '<span style="color:#F80C0C; text-align: center;" class="fa fa-times"></span>';
			      }
			    elseif($q->update==1){
				      $estadoupdate = '<span  style="color:#47A728;" class="fa fa-check"></span>';
			      }

			     if ($q->delete==0) {
				$estadodelete = '<span style="color:#F80C0C;" class="fa fa-times"></span>';
			      }
			    elseif($q->delete==1){
				      $estadodelete = '<span  style="color:#47A728;" class="fa fa-check"></span>';
			      }


			$botones = '<div class="btn-footer text-center">
                                          
                                                   <a href="'.base_url('administrador/permisos/edit/'.$q->id_permiso).'" class="btn btn-primary" style="padding:2px 5px;margin:0px 2px"> <i class="fa fa-edit"></i> </a>
                                                   
                                                           
                                                     <button data-id="'.$q->codi_med.'" class="anular-medico btn btn-danger" style="padding:2px 5px;margin:0px 2px" >
                                                         <i class="glyphicon glyphicon-trash"></i> </button>';

			$row[] = [$q->id_permiso,$q->NombreMenu,$q->NombreRol,$estadoread,$estadoinsert,$estadoupdate,$estadodelete,$botones];
		}
		$result['aaData'] = $row;
		return $result;
	}

	
	public function getPermisos(){
		$this->db->select("p.*,m.nombre as menu, r.nomb_rol as roles");
		$this->db->from("permisos p");
		$this->db->join("rol r","p.codi_rol = r.codi_rol");
	 $this->db->join("menus m","p.id_menu = m.id_menu");
		$resultados = $this->db->get();
		return $resultados->result();
	}

	public function getMenus(){
		$resultados = $this->db->get("menus");
		return $resultados->result();
	}

	public function save($data)
	{	
		return $this->db->insert('permisos',$data);
	}

	public function getPermiso($id)
	{
		$this->db->where("id_permiso",$id);
		$resultado = $this->db->get("permisos");
		return $resultado->row();

	}
	
	public function update($id,$data)
	{
		$this->db->where("id_permiso",$id);
		return $this->db->update("permisos",$data);
	}

	public function delete($id){
		$this->db->where("id_permiso",$id);
		$this->db->delete("permisos");
	}
}