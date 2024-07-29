<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
* 
*/
class Tipodocumento_model extends CI_Model
{
	function getdocumento($data)
    {
        $this->db->from('tipo_documento');
		$queryTotal = $this->db->get();

		$this->db->from('tipo_documento');

		if (isset($data['tipo_documento'])) {
			$this->db->having("descripcion LIKE '%".$data['tipo_documento']."%'");
		}

		$queryLike = $this->db->get();

		$this->db->from('tipo_documento');

		if ($data['length']!=-1) {
			$this->db->limit($data['length'],$data['start']);
		}

		if (isset($data['orderCampo'])) {
			$this->db->order_by($data['orderCampo'],$data['orderDireccion']);
		}

		if (isset($data['tipo_documento'])) {
			$this->db->having("descripcion LIKE '%".$data['tipo_documento']."%'");
		}

		$query = $this->db->get();

		$result = array();
		$result['sEcho'] = $data['sEcho'];
		$result['iTotalRecords'] = $queryTotal->num_rows();
		$result['iTotalDisplayRecords'] = $queryLike->num_rows();


		$row = [];
		foreach ($query->result() as $q) {
			if ($q->estado== 1) {
				$estado = '<label class="label label-success">Activo</label>';
			}elseif($q->estado== 2){
				$estado = '<label class="label label-info">Inactivo</label>';
			}	



                                          
                                                $botones = '<div class="btn-footer text-center">
		<button data-id="'.$q->cod_tipodocumento.'" class="editar-tipodocumento btn btn-primary waves-effect waves-light" 
		data-toggle="modal" data-target="#ModalEditarTipoDocumento" style="padding:2px 5px;margin:0px 2px"><i class="fa fa-edit"></i></button>';
                                                   
                                                           
                                                  $botones .=   '<button data-id="'.$q->cod_tipodocumento.'" class="anular btn btn-danger" style="padding:2px 5px;margin:0px 2px" >
                                                         <i class="glyphicon glyphicon-trash"></i> </button>';
            
			$row[] = [$q->descripcion,$q->abreviatura,$q->serie,$q->inicio,$q->fin,$q->correlativo_actual,$estado,$botones];
		}
		$result['aaData'] = $row;
		return $result;
	}
	
	public function agregardocumento($data)
	{
		$this->db->insert('tipo_documento',$data);
		return $this->db->insert_id();
	}
	

	public function getdocumentoid($id)
	{
			$this->db->where('cod_tipodocumento',$id);
			$resultado = $this->db->get('tipo_documento');
			return $resultado->row();
	}

	public function update($id,$data)
	{
		$this->db->where('cod_tipodocumento',$id);
		return $this->db->update('tipo_documento',$data);
	}

	
} 

