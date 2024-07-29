<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Moneda_model extends CI_Model
{
	
	function getmoneda ($data)
	{
		$this->db->from('tipo_moneda');
		$queryTotal= $this->db->get();

		$this->db->from('tipo_moneda');
		
		if (isset($data['tipo_moneda'])) {
			$this->db->having("descripcion LIKE '%".$data['tipo_moneda']."%'");
		}

		$queryLike = $this->db->get();

		$this->db->from('tipo_moneda');

		if ($data['length']!=-1) {
			$this->db->limit($data['length'],$data['start']);
		}

		if (isset($data['orderCampo'])) {
			$this->db->order_by($data['orderCampo'],$data['orderDireccion']);
		}

		if (isset($data['tipo_moneda'])) {
			$this->db->having("descripcion LIKE '%".$data['tipo_moneda']."%'");
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
                                          
                                                   <a href="'.base_url('mantenimiento/moneda/editar/'.$q->cod_tipomoneda).'"class="btn btn-primary" style="padding:2px 5px;margin:0px 2px"> <i class="fa fa-edit"></i> </a>
                                                   
                                                           
                                                     <button data-id="'.$q->cod_tipomoneda.'" class="anular btn btn-danger" style="padding:2px 5px;margin:0px 2px" >
                                                         <i class="glyphicon glyphicon-trash"></i> </button>';
            
			$row[] = [$q->cod_tipomoneda,$q->descripcion,$estado,$botones];
		}
		$result['aaData'] = $row;
		return $result;
	

	}

	public function agregarmoneda($data)
		{

			$this->db->insert('tipo_moneda',$data);
			return $this->db->insert_id();
		}

	public function getmonedaid($id)
	{
			$this->db->where('cod_tipomoneda',$id);
		$resultado = $this->db->get('tipo_moneda');
		return $resultado->row();
	}

	public function update($id,$data){
		$this->db->where('cod_tipomoneda',$id);
		return $this->db->update('tipo_moneda',$data);
	}
}