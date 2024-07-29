<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 
 */
class Tarifario_model extends  CI_Model{

	
	function getprocedimiento($data)
	{
		$this->db->from('procedimiento');
		$queryTotal = $this->db->get();

		$this->db->from('procedimiento');
		$this->db->join('tipo_concepto','procedimiento.id_tipoconcepto = tipo_concepto.id_tipoconcepto');
		$this->db->join('unidad_medida','procedimiento.id_medida = unidad_medida.id_medida');
		$this->db->join('categoria','procedimiento.codi_cat = categoria.codi_cat');
		$this->db->select('procedimiento.*, nombre_concepto as NombreConcepto, nom_medida as NombreMedida, nomb_cat as NombreCategoria');

		if (isset($data['procedimiento'])) {
			$this->db->having("nombre LIKE '%".$data['procedimiento']."%'");
		}

		
		if (isset($data['desde']) AND isset($data['hasta'])) {
			$this->db->where('fecha_registro >=',$data['desde']);
			$this->db->where('fecha_registro <=',$data['hasta']);

		}

		if (isset($data['tipo_concepto'])) {
			$this->db->where('tipo_concepto.id_tipoconcepto >=',$data['tipo_concepto']);
		}
		if (isset($data['unidad_medida'])) {
			$this->db->where('unidad_medida.id_medida >=',$data['unidad_medida']);
		}
		if (isset($data['categoria'])) {
			$this->db->where('categoria.codi_cat >=',$data['categoria']);
		}
		$queryLike = $this->db->get();

		$this->db->from('procedimiento');
		$this->db->join('tipo_concepto','procedimiento.id_tipoconcepto = tipo_concepto.id_tipoconcepto');
		$this->db->join('unidad_medida','procedimiento.id_medida = unidad_medida.id_medida');
		$this->db->join('categoria','procedimiento.codi_cat = categoria.codi_cat');
		$this->db->select('procedimiento.*, nombre_concepto as NombreConcepto, nom_medida as NombreMedida, nomb_cat as NombreCategoria');

		if ($data['length']!=-1) {
			$this->db->limit($data['length'],$data['start']);
		}

		if (isset($data['orderCampo'])) {
			$this->db->order_by($data['orderCampo'],$data['orderDireccion']);
		}

		if (isset($data['procedimiento'])) {
			$this->db->having("nombre LIKE '%".$data['procedimiento']."%'");
		}
		if (isset($data['desde']) AND isset($data['hasta'])) {
			$this->db->where('fecha_registro >=',$data['desde']);
			$this->db->where('fecha_registro <=',$data['hasta']);
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
                                          			
                                                   <a href="'.base_url('mantenimiento/tarifario/editar/'.$q->id_procedimiento).'"class="btn btn-primary" style="padding:2px 5px;margin:0px 2px"> <i class="fa fa-edit"></i> </a>
                                        
                                                      
                                                    
                                                     <button data-id="'.$q->id_procedimiento.'" class="anularTarifario btn btn-danger" style="padding:2px 5px;margin:0px 2px" >
                                                         <i class="glyphicon glyphicon-trash"></i> </button>
                                                        ' ;
                                                         
            
			$row[] = [$q->id_procedimiento,$q->NombreConcepto,$q->NombreMedida,$q->NombreCategoria,$q->nombre,$q->prec_procedimiento,$q->fecha_registro,$estado,$botones];
		}
		$result['aaData'] = $row;
		return $result;


	}

	public function guardarprocedimiento($data)
	{	
		
		$this->db->insert("procedimiento",$data);
		return $this->db->insert_id();
	}

	public function getprocedimiento_id($id)
	{
			$this->db->where("id_procedimiento",$id);
		$resultado = $this->db->get("procedimiento");
		return $resultado->row();
	}

	public function update($id,$data){
		$this->db->where("id_procedimiento",$id);
		return $this->db->update("procedimiento",$data);
	}




}