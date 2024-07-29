<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 
 */
class Concepto_model extends CI_Model
{
	
	function getconcepto($data)
	{
		$this->db->from('tipo_concepto');
		$queryTotal = $this->db->get();

		$this->db->from('tipo_concepto');

		if (isset($data['tipo_concepto'])) {
			$this->db->having("nombre_concepto LIKE '%".$data['tipo_concepto']."%'");
		}

		$queryLike = $this->db->get();

		$this->db->from('tipo_concepto');

		if ($data['length']!=-1) {
			$this->db->limit($data['length'],$data['start']);
		}

		if (isset($data['orderCampo'])) {
			$this->db->order_by($data['orderCampo'],$data['orderDireccion']);
		}

		if (isset($data['tipo_concepto'])) {
			$this->db->having("nombre_concepto LIKE '%".$data['tipo_concepto']."%'");
		}

		$query = $this->db->get();

		$result = array();
		$result['sEcho'] = $data['sEcho'];
		$result['iTotalRecords'] = $queryTotal->num_rows();
		$result['iTotalDisplayRecords'] = $queryLike->num_rows();


		$row = [];
		foreach ($query->result() as $q) {
			if ($q->estado_tipo=='S') {
				$estado = '<label class="label label-success">Activo</label>';
			}elseif($q->estado_tipo=='N'){
				$estado = '<label class="label label-info">Inactivo</label>';
			}	


			$botones = '<div class="btn-footer text-center">
                                          
                                                   <a href="'.base_url('mantenimiento/concepto/editar/'.$q->id_tipoconcepto).'"class="btn btn-primary" style="padding:2px 5px;margin:0px 2px"> <i class="fa fa-edit"></i> </a>
                                                   
                                                           
                                                     <button data-id="'.$q->id_tipoconcepto.'" class="anular btn btn-danger" style="padding:2px 5px;margin:0px 2px" >
                                                         <i class="glyphicon glyphicon-trash"></i> </button>';
            
			$row[] = [$q->id_tipoconcepto,$q->nombre_concepto,$estado,$botones];
		}
		$result['aaData'] = $row;
		return $result;
	
	}


	public function agregarconcepto($data)
		{

			$this->db->insert("tipo_concepto",$data);
			return $this->db->insert_id();
		}

	public function getconceptoid($id)
	{
			$this->db->where('id_tipoconcepto',$id);
			$resultado = $this->db->get('tipo_concepto');
			return $resultado->row();
	}

	public function update($id,$data)
	{
		$this->db->where('id_tipoconcepto',$id);
		return $this->db->update('tipo_concepto',$data);
	}



}