<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Citado_model extends CI_Model
{
    function getcitado($data)
    {
        $this->db->from('tipo_citado');
		$queryTotal = $this->db->get();

		$this->db->from('tipo_citado');

		if (isset($data['tipo_citado'])) {
			$this->db->having("nomb_citado LIKE '%".$data['tipo_citado']."%'");
		}

		$queryLike = $this->db->get();

		$this->db->from('tipo_citado');

		if ($data['length']!=-1) {
			$this->db->limit($data['length'],$data['start']);
		}

		if (isset($data['orderCampo'])) {
			$this->db->order_by($data['orderCampo'],$data['orderDireccion']);
		}

		if (isset($data['tipo_citado'])) {
			$this->db->having("nomb_citado LIKE '%".$data['tipo_citado']."%'");
		}

		$query = $this->db->get();

		$result = array();
		$result['sEcho'] = $data['sEcho'];
		$result['iTotalRecords'] = $queryTotal->num_rows();
		$result['iTotalDisplayRecords'] = $queryLike->num_rows();


		$row = [];
		foreach ($query->result() as $q) {
			if ($q->esta_citado=='S') {
				$estado = '<label class="label label-success">Activo</label>';
			}elseif($q->esta_citado=='N'){
				$estado = '<label class="label label-info">Inactivo</label>';
			}	


			$botones = '<div class="btn-footer text-center">
                                          
                                                   <a href="'.base_url('mantenimiento/citado/editar/'.$q->cod_citado).'"class="btn btn-primary" style="padding:2px 5px;margin:0px 2px"> <i class="fa fa-edit"></i> </a>
                                                   
                                                           
                                                     <button data-id="'.$q->cod_citado.'" class="anular btn btn-danger" style="padding:2px 5px;margin:0px 2px" >
                                                         <i class="glyphicon glyphicon-trash"></i> </button>';
            
			$row[] = [$q->cod_citado,$q->nomb_citado,$estado,$botones];
		}
		$result['aaData'] = $row;
		return $result;
	}
	
	public function agregarcitado($data)
	{

		$this->db->insert('tipo_citado',$data);
		return $this->db->insert_id();
	}

	public function getcitadoid($id)
	{
			$this->db->where('cod_citado',$id);
			$resultado = $this->db->get('tipo_citado');
			return $resultado->row();
	}

	public function update($id,$data)
	{
		$this->db->where('cod_citado',$id);
		return $this->db->update('tipo_citado',$data);
	}
}