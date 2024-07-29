<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Especialidad_model extends CI_Model 
{
    function getespecialidad($data)
    {
        $this->db->from('especialidad');
		$queryTotal = $this->db->get();

		$this->db->from('especialidad');

		if (isset($data['especialidad'])) {
			$this->db->having("nombre_especialidad LIKE '%".$data['especialidad']."%'");
		}

		$queryLike = $this->db->get();

		$this->db->from('especialidad');

		if ($data['length']!=-1) {
			$this->db->limit($data['length'],$data['start']);
		}

		if (isset($data['orderCampo'])) {
			$this->db->order_by($data['orderCampo'],$data['orderDireccion']);
		}

		if (isset($data['especialidad'])) {
			$this->db->having("nombre_especialidad LIKE '%".$data['especialidad']."%'");
		}

		$query = $this->db->get();

		$result = array();
		$result['sEcho'] = $data['sEcho'];
		$result['iTotalRecords'] = $queryTotal->num_rows();
		$result['iTotalDisplayRecords'] = $queryLike->num_rows();


		$row = [];
		foreach ($query->result() as $q) {
			if ($q->estado_especialidad=='S') {
				$estado = '<label class="label label-success">Activo</label>';
			}elseif($q->estado_especialidad=='N'){
				$estado = '<label class="label label-info">Inactivo</label>';
			}	


			$botones = '<div class="btn-footer text-center">
                                          
                                                   <a href="'.base_url('mantenimiento/especialidad/editar/'.$q->cod_especialidad).'"class="btn btn-primary" style="padding:2px 5px;margin:0px 2px"> <i class="fa fa-edit"></i> </a>
                                                   
                                                           
                                                     <button data-id="'.$q->cod_especialidad.'" class="anular btn btn-danger" style="padding:2px 5px;margin:0px 2px" >
                                                         <i class="glyphicon glyphicon-trash"></i> </button>';
            
			$row[] = [$q->cod_especialidad,$q->nombre_especialidad,$q->descripcion_especialidad,$estado,$botones];
		}
		$result['aaData'] = $row;
		return $result;
	}
	
	public function agregarespecialidad($data)
	{

		$this->db->insert('especialidad',$data);
		return $this->db->insert_id();
	}

	public function getespecialidadid($id)
	{
			$this->db->where('cod_especialidad',$id);
			$resultado = $this->db->get('especialidad');
			return $resultado->row();
	}

	public function update($id,$data)
	{
		$this->db->where('cod_especialidad',$id);
		return $this->db->update('especialidad',$data);
	}
}
