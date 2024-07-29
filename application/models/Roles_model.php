<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
* 
*/
/**
* 
*/
class Roles_model extends CI_Model
{
	
	function getRoles ($data)
	{
		$this->db->from('rol');
		$queryTotal= $this->db->get();

		$this->db->from('rol');
		
		if (isset($data['rol'])) {
			$this->db->having("nomb_rol LIKE '%".$data['rol']."%'");
		}

		$queryLike = $this->db->get();

		$this->db->from('rol');

		if ($data['length']!=-1) {
			$this->db->limit($data['length'],$data['start']);
		}

		if (isset($data['orderCampo'])) {
			$this->db->order_by($data['orderCampo'],$data['orderDireccion']);
		}

		if (isset($data['rol'])) {
			$this->db->having("nomb_rol LIKE '%".$data['rol']."%'");
		}

		$query = $this->db->get();

		$result = array();
		$result['sEcho'] = $data['sEcho'];
		$result['iTotalRecords'] = $queryTotal->num_rows();
		$result['iTotalDisplayRecords'] = $queryLike->num_rows();


		$row = [];
		foreach ($query->result() as $q) {
			if ($q->esta_rol=='1') {
				$estado = '<label class="label label-success">Activo</label>';
			}elseif($q->esta_rol=='2'){
				$estado = '<label class="label label-info">Inactivo</label>';
			}	


			$botones = '<div class="btn-footer text-center">
		<button data-id="'.$q->codi_rol.'" class="editar-rol btn btn-primary waves-effect waves-light" 
		data-toggle="modal" data-target="#ModalEditarRol" style="padding:2px 5px;margin:0px 2px"><i class="fa fa-edit"></i></button>';                                      
		$botones .= '<a></a> <button data-id="'.$q->codi_rol.'" class="anular-rol btn btn-danger waves-effect waves-light" style="padding:2px 4px;margin:0px 2px"><i class="fa fa-trash"></i></button>';
            
			$row[] = [$q->codi_rol,$q->nomb_rol,$estado,$botones];
		}
		$result['aaData'] = $row;
		return $result;
	

	}

	public function add($data)
	{
		$this->db->insert("rol",$data);
		return $this->db->insert_id();
	}
}