<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Pacientes_model extends CI_Model
{

	function getpaciente($data)
	{
		$this->db->from('paciente');
		$queryTotal = $this->db->get();
		
		$this->db->from('paciente');
		$this->db->select('paciente.*,CONCAT(nomb_pac," ",apel_pac) as NombrePaciente');

		if (isset($data['paciente'])) {
			$this->db->having("NombrePaciente LIKE '%".$data['paciente']."%'");
		}

		if (isset($data['desde']) AND isset($data['hasta'])) {
			$this->db->where('fecha_registro >=',$data['desde']);
			$this->db->where('fecha_registro <=',$data['hasta']);

		}
	

		$queryLike = $this->db->get();

		$this->db->from('paciente');
		$this->db->select('paciente.*,CONCAT(nomb_pac," ",apel_pac) as NombrePaciente');
		if ($data['length']!=-1) {
			$this->db->limit($data['length'],$data['start']);
		}

		if (isset($data['orderCampo'])) {
			$this->db->order_by($data['orderCampo'],$data['orderDireccion']);
		}

		if (isset($data['paciente'])) {
			$this->db->having("NombrePaciente LIKE '%".$data['paciente']."%'");
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
			if ($q->esta_pac=='S') {
				$estado = '<label class="label label-success">Activo</label>';
			}elseif($q->esta_pac=='N'){
				$estado = '<label class="label label-info">Inactivo</label>';
			}	


			$botones = '<div class="btn-footer text-center">
                                          
                                                   <a href="'.base_url('mantenimiento/paciente/editarPaciente/'.$q->codi_pac).'"class="btn btn-primary" style="padding:2px 5px;margin:0px 2px"> <i class="fa fa-edit"></i> </a>
                                                   
                                                           
                                                     <button data-id="'.$q->codi_pac.'" class="anular-paciente btn btn-danger" style="padding:2px 5px;margin:0px 2px" >
                                                         <i class="glyphicon glyphicon-trash"></i> </button>';
            
			$row[] = [$q->codi_pac,$q->NombrePaciente,$q->edad_pac,$q->dni_pac,$q->dire_pac,$q->fecha_registro,$estado,$botones];
		}
		$result['aaData'] = $row;
		return $result;
	
	}

	public function getpacientes_id($id){
		$this->db->from('paciente');
		$this->db->where('codi_pac',$id);
		$query = $this->db->get();

		return $query->row();
	}



	public function agregarpaciente($data)
	{

		$this->db->insert('paciente',$data);
		return $this->db->insert_id();
	}

 

	public function update($id,$data){
		$this->db->where('codi_pac',$id);
		return $this->db->update('paciente',$data);
	}

}
