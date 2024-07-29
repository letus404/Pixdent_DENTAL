<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Medico_model extends CI_Model {

	function getmedico($data)
	{
		$this->db->from('medico');
		$queryTotal = $this->db->get();

		$this->db->from('medico');
		$this->db->join('especialidad','medico.cod_especialidad = especialidad.cod_especialidad');
		$this->db->select('medico.*,CONCAT(nomb_med," ",apel_med) as NombresApellidos, nombre_especialidad as NombreEspecialidad');

		if (isset($data['medico'])) {
			$this->db->having("NombresApellidos LIKE '%".$data['medico']."%'");
		}

		if (isset($data['desde']) AND isset($data['hasta'])) {
			$this->db->where('fecha_registro >=',$data['desde']);
			$this->db->where('fecha_registro <=',$data['hasta']);
		}
		if (isset($data['especialidad'])) {
			$this->db->where('especialidad.cod_especialidad',$data['especialidad']);
		}
		$queryLike = $this->db->get();

		$this->db->from('medico');
		$this->db->join('especialidad','medico.cod_especialidad = especialidad.cod_especialidad');
		$this->db->select('medico.*,CONCAT(nomb_med," ",apel_med) as NombresApellidos, , nombre_especialidad as NombreEspecialidad');

		if ($data['length']!=-1) {
			$this->db->limit($data['length'],$data['start']);
		}

		if (isset($data['orderCampo'])) {
			$this->db->order_by($data['orderCampo'],$data['orderDireccion']);
		}
		if (isset($data['medico'])) {
			$this->db->having("NombresApellidos LIKE '%".$data['medico']."%'");
		}
		if (isset($data['desde']) AND isset($data['hasta'])) {
			$this->db->where('fecha_registro >=',$data['desde']);
			$this->db->where('fecha_registro <=',$data['hasta']);
		}
		if (isset($data['especialidad'])) {
			$this->db->where('especialidad.cod_especialidad',$data['especialidad']);
		}

	
		$query = $this->db->get();

		$result = array();
		$result['sEcho'] = $data['sEcho'];
		$result['iTotalRecords'] = $queryTotal->num_rows();
		$result['iTotalDisplayRecords'] = $queryLike->num_rows();

		$row = [];
		foreach ($query->result() as $q) {

				if ($q->esta_med=='S') {
				$estado = '<label class="label label-success">Activo</label>';
			}elseif($q->esta_med=='N'){
				$estado = '<label class="label label-info">Inactivo</label>';
			}	


			$botones = '<div class="btn-footer text-center">
                                          
                                                   <a href="'.base_url('mantenimiento/medico/editar/'.$q->codi_med).'" class="btn btn-primary" style="padding:2px 5px;margin:0px 2px"> <i class="fa fa-edit"></i> </a>
                                                   
                                                           
                                                     <button data-id="'.$q->codi_med.'" class="anular-medico btn btn-danger" style="padding:2px 5px;margin:0px 2px" >
                                                         <i class="glyphicon glyphicon-trash"></i> </button>';

			$row[] = [$q->codi_med,$q->NombresApellidos,$q->NombreEspecialidad,$q->dni_med,$q->coleg_med,$q->fecha_registro,$estado,$botones];
		}
		$result['aaData'] = $row;
		return $result;
	}

		

	public function guardarmedico($data)
		{	
		 $this->db->insert('medico',$data);
		 return $this->db->insert_id();
		}

	public function getmedico_id($id)
	{
			$this->db->where('codi_med',$id);
		$resultado = $this->db->get('medico');
		return $resultado->row();
	}

	public function update($id,$data){
		$this->db->where('codi_med',$id);
		return $this->db->update('medico',$data);
	}


}
