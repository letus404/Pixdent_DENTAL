<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 
 */
/**
 * 
 */
class Diagnostico_model extends CI_Model{

	
	function getdiagnostico($data)
	{
		$this->db->from('enfermedad');
		$this->db->where('esta_enf',S);
		$queryTotal = $this->db->get();

		$this->db->from('enfermedad');
		$this->db->where('esta_enf',S);
		if (isset($data['enfermedad'])) {
			$this->db->having("desc_enf LIKE '%".$data['enfermedad']."%'");
		}

		$queryLike = $this->db->get();

		$this->db->from('enfermedad');
		$this->db->where('esta_enf',S);
		if ($data['length']!=-1) {
			$this->db->limit($data['length'],$data['start']);
		}

		if (isset($data['orderCampo'])) {
			$this->db->order_by($data['orderCampo'],$data['orderDireccion']);
		}

		if (isset($data['enfermedad'])) {
			$this->db->having("desc_enf LIKE '%".$data['enfermedad']."%'");
		}

		$query = $this->db->get();

		$result = array();
		$result['sEcho'] = $data['sEcho'];
		$result['iTotalRecords'] = $queryTotal->num_rows();
		$result['iTotalDisplayRecords'] = $queryLike->num_rows();


		$row = [];
		foreach ($query->result() as $q) {
			if ($q->esta_enf=='S') {
				$estado = '<label class="label label-success">Activo</label>';
			}elseif($q->esta_enf=='N'){
				$estado = '<label class="label label-info">Inactivo</label>';
			}	


			$botones = '<div class="btn-footer text-center">
                                          
                                                   <a href="'.base_url('mantenimiento/diagnostico/editar/'.$q->codi_enf).'"class="btn btn-primary" style="padding:2px 5px;margin:0px 2px"> <i class="fa fa-edit"></i> </a>
                                                   
                                                           
                                                     <button data-id="'.$q->codi_enf.'" class="anularcie10 btn btn-danger" style="padding:2px 5px;margin:0px 2px" >
                                                         <i class="glyphicon glyphicon-trash"></i> </button>';
            
			$row[] = [$q->codi_enf,$q->desc_enf,$estado,$botones];
		}
		$result['aaData'] = $row;
		return $result;
	



	}

	public function agregardiagnostico($data)
		{

			$this->db->insert('enfermedad',$data);
			return $this->db->insert_id();
		}


	public function getdiagnosticoid($id)
	{
			$this->db->where('codi_enf',$id);
		$resultado = $this->db->get('enfermedad');
		return $resultado->row();
	}

	public function update($id,$data){
		$this->db->where('codi_enf',$id);
		return $this->db->update('enfermedad',$data);
	}
}