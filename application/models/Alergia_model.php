<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Alergia_model extends CI_Model
{
	
	function getAlergia ($data)
	{
		$this->db->from('alergia');
		$queryTotal= $this->db->get();

		$this->db->from('alergia');
		
		if (isset($data['alergia'])) {
			$this->db->having("nombre_ale LIKE '%".$data['alergia']."%'");
		}

		$queryLike = $this->db->get();

		$this->db->from('alergia');

		if ($data['length']!=-1) {
			$this->db->limit($data['length'],$data['start']);
		}

		if (isset($data['orderCampo'])) {
			$this->db->order_by($data['orderCampo'],$data['orderDireccion']);
		}

		if (isset($data['alergia'])) {
			$this->db->having("nombre_ale LIKE '%".$data['alergia']."%'");
		}

		$query = $this->db->get();

		$result = array();
		$result['sEcho'] = $data['sEcho'];
		$result['iTotalRecords'] = $queryTotal->num_rows();
		$result['iTotalDisplayRecords'] = $queryLike->num_rows();


		$row = [];
		foreach ($query->result() as $q) {	


			$botones = '<div class="btn-footer text-center">
                                          
                                                   <a href="'.base_url('mantenimiento/alergia/editar/'.$q->cod_ale).'"class="btn btn-primary" style="padding:2px 5px;margin:0px 2px"> <i class="fa fa-edit"></i> </a>
                                                   
                                                           
                                                     <button data-id="'.$q->cod_ale.'" class="anular btn btn-danger" style="padding:2px 5px;margin:0px 2px" >
                                                         <i class="glyphicon glyphicon-trash"></i> </button>';
            
			$row[] = [$q->cod_ale,$q->nombre_ale,$botones];
		}
		$result['aaData'] = $row;
		return $result;
	

	}

	public function agregarAlergia($data)
		{

			$this->db->insert('alergia',$data);
			return $this->db->insert_id();
		}

	public function getAlergiaid($id)
	{
			$this->db->where('cod_ale',$id);
		$resultado = $this->db->get('alergia');
		return $resultado->row();
	}

	public function update($id,$data){
		$this->db->where('cod_ale',$id);
		return $this->db->update('alergia',$data);
	}
}