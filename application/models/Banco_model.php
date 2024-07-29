<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Banco_model extends CI_Model
{
	
	function getBanco ($data)
	{
		$this->db->from('banco');
		$queryTotal= $this->db->get();

		$this->db->from('banco');
		
		if (isset($data['banco'])) {
			$this->db->having("descripcion LIKE '%".$data['banco']."%'");
		}

		$queryLike = $this->db->get();

		$this->db->from('banco');

		if ($data['length']!=-1) {
			$this->db->limit($data['length'],$data['start']);
		}

		if (isset($data['orderCampo'])) {
			$this->db->order_by($data['orderCampo'],$data['orderDireccion']);
		}

		if (isset($data['banco'])) {
			$this->db->having("descripcion LIKE '%".$data['banco']."%'");
		}

		$query = $this->db->get();

		$result = array();
		$result['sEcho'] = $data['sEcho'];
		$result['iTotalRecords'] = $queryTotal->num_rows();
		$result['iTotalDisplayRecords'] = $queryLike->num_rows();


		$row = [];
		foreach ($query->result() as $q) {
			if ($q->estado=='1') {
				$estado = '<label class="label label-success">Activo</label>';
			}elseif($q->estado=='2'){
				$estado = '<label class="label label-info">Inactivo</label>';
			}	


			$botones = '<div class="btn-footer text-center">
                                          
                                                   <a href="'.base_url('mantenimiento/banco/editar/'.$q->cod_banco).'"class="btn btn-primary" style="padding:2px 5px;margin:0px 2px"> <i class="fa fa-edit"></i> </a>
                                                   
                                                           
                                                     <button data-id="'.$q->cod_banco.'" class="anular btn btn-danger" style="padding:2px 5px;margin:0px 2px" >
                                                         <i class="glyphicon glyphicon-trash"></i> </button>';
            
			$row[] = [$q->cod_banco,$q->descripcion,$estado,$botones];
		}
		$result['aaData'] = $row;
		return $result;
	

	}

	public function agregarBanco($data)
		{

			$this->db->insert('banco',$data);
			return $this->db->insert_id();
		}

	public function getBancoid($id)
	{
			$this->db->where('cod_banco',$id);
		$resultado = $this->db->get('banco');
		return $resultado->row();
	}

	public function update($id,$data){
		$this->db->where('cod_banco',$id);
		return $this->db->update('banco',$data);
	}
}