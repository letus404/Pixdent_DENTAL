<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Tarjeta_model extends CI_Model
{
	
	function getTarjeta ($data)
	{
		$this->db->from('tipo_tarjeta');
		$queryTotal= $this->db->get();

		$this->db->from('tipo_tarjeta');
		
		if (isset($data['tipo_tarjeta'])) {
			$this->db->having("descripcion LIKE '%".$data['tipo_tarjeta']."%'");
		}

		$queryLike = $this->db->get();

		$this->db->from('tipo_tarjeta');

		if ($data['length']!=-1) {
			$this->db->limit($data['length'],$data['start']);
		}

		if (isset($data['orderCampo'])) {
			$this->db->order_by($data['orderCampo'],$data['orderDireccion']);
		}

		if (isset($data['tipo_tarjeta'])) {
			$this->db->having("descripcion LIKE '%".$data['tipo_tarjeta']."%'");
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
                                          
                                                   <a href="'.base_url('mantenimiento/tarjeta/editar/'.$q->cod_tarjeta).'"class="btn btn-primary" style="padding:2px 5px;margin:0px 2px"> <i class="fa fa-edit"></i> </a>
                                                   
                                                           
                                                     <button data-id="'.$q->cod_tarjeta.'" class="anular btn btn-danger" style="padding:2px 5px;margin:0px 2px" >
                                                         <i class="glyphicon glyphicon-trash"></i> </button>';
            
			$row[] = [$q->cod_tarjeta,$q->descripcion,$estado,$botones];
		}
		$result['aaData'] = $row;
		return $result;
	

	}

	public function agregarTarjeta($data)
		{

			$this->db->insert('tipo_tarjeta',$data);
			return $this->db->insert_id();
		}

	public function geTarjetaid($id)
	{
			$this->db->where('cod_tarjeta',$id);
		$resultado = $this->db->get('tipo_tarjeta');
		return $resultado->row();
	}

	public function update($id,$data){
		$this->db->where('cod_tarjeta',$id);
		return $this->db->update('tipo_tarjeta',$data);
	}
}