<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Pago_model extends CI_Model
{
	
	function getpago ($data)
	{
		$this->db->from('tipo_pago');
		$queryTotal= $this->db->get();

		$this->db->from('tipo_pago');
		
		if (isset($data['tipo_pago'])) {
			$this->db->having("descripcion LIKE '%".$data['tipo_pago']."%'");
		}

		$queryLike = $this->db->get();

		$this->db->from('tipo_pago');

		if ($data['length']!=-1) {
			$this->db->limit($data['length'],$data['start']);
		}

		if (isset($data['orderCampo'])) {
			$this->db->order_by($data['orderCampo'],$data['orderDireccion']);
		}

		if (isset($data['tipo_pago'])) {
			$this->db->having("descripcion LIKE '%".$data['tipo_pago']."%'");
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
                                          
                                                   <a href="'.base_url('mantenimiento/pago/editar/'.$q->cod_tipopago).'"class="btn btn-primary" style="padding:2px 5px;margin:0px 2px"> <i class="fa fa-edit"></i> </a>
                                                   
                                                           
                                                     <button data-id="'.$q->cod_tipopago.'" class="anular btn btn-danger" style="padding:2px 5px;margin:0px 2px" >
                                                         <i class="glyphicon glyphicon-trash"></i> </button>';
            
			$row[] = [$q->cod_tipopago,$q->descripcion,$estado,$botones];
		}
		$result['aaData'] = $row;
		return $result;
	

	}

	public function agregarpago($data)
		{

			$this->db->insert('tipo_pago',$data);
			return $this->db->insert_id();
		}

	public function getpagoid($id)
	{
			$this->db->where('cod_tipopago',$id);
		$resultado = $this->db->get('tipo_pago');
		return $resultado->row();
	}

	public function update($id,$data){
		$this->db->where('cod_tipopago',$id);
		return $this->db->update('tipo_pago',$data);
	}
}