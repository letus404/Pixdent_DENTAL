<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 
 */
/**
 * 
 */
/**
 * 
 */
class Unidadmedida_model extends CI_Model
{
	
	function getmedida ($data)
	{
		$this->db->from('unidad_medida');
		$queryTotal= $this->db->get();

		$this->db->from('unidad_medida');
		
		if (isset($data['unidad_medida'])) {
			$this->db->having("nom_medida LIKE '%".$data['unidad_medida']."%'");
		}

		$queryLike = $this->db->get();

		$this->db->from('unidad_medida');

		if ($data['length']!=-1) {
			$this->db->limit($data['length'],$data['start']);
		}

		if (isset($data['orderCampo'])) {
			$this->db->order_by($data['orderCampo'],$data['orderDireccion']);
		}

		if (isset($data['unidad_medida'])) {
			$this->db->having("nom_medida LIKE '%".$data['unidad_medida']."%'");
		}

		$query = $this->db->get();

		$result = array();
		$result['sEcho'] = $data['sEcho'];
		$result['iTotalRecords'] = $queryTotal->num_rows();
		$result['iTotalDisplayRecords'] = $queryLike->num_rows();


		$row = [];
		foreach ($query->result() as $q) {
			if ($q->estado=='S') {
				$estado = '<label class="label label-success">Activo</label>';
			}elseif($q->estado=='N'){
				$estado = '<label class="label label-info">Inactivo</label>';
			}	


			$botones = '<div class="btn-footer text-center">
                                          
                                                   <a href="'.base_url('mantenimiento/medida/editar/'.$q->id_medida).'"class="btn btn-primary" style="padding:2px 5px;margin:0px 2px"> <i class="fa fa-edit"></i> </a>
                                                   
                                                           
                                                     <button data-id="'.$q->id_medida.'" class="anularmedida btn btn-danger" style="padding:2px 5px;margin:0px 2px" >
                                                         <i class="glyphicon glyphicon-trash"></i> </button>';
            
			$row[] = [$q->id_medida,$q->nom_medida,$estado,$botones];
		}
		$result['aaData'] = $row;
		return $result;
	

	}

	public function agregarmedida($data)
		{

			$this->db->insert('unidad_medida',$data);
			return $this->db->insert_id();
		}

	public function getmedidaid($id)
	{
			$this->db->where('id_medida',$id);
		$resultado = $this->db->get('unidad_medida');
		return $resultado->row();
	}

	public function update($id,$data){
		$this->db->where('id_medida',$id);
		return $this->db->update('unidad_medida',$data);
	}
}