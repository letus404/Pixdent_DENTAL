<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 
 */
class Categoria_model extends CI_Model
{
	
	function getcategoria($data)
	{
		$this->db->from('categoria');
		$queryTotal = $this->db->get();

		$this->db->from('categoria');

		if (isset($data['categoria'])) {
			$this->db->having("nomb_cat LIKE '%".$data['categoria']."%'");
		}

		$queryLike = $this->db->get();

		$this->db->from('categoria');

		if ($data['length']!=-1) {
			$this->db->limit($data['length'],$data['start']);
		}

		if (isset($data['orderCampo'])) {
			$this->db->order_by($data['orderCampo'],$data['orderDireccion']);
		}

		if (isset($data['categoria'])) {
			$this->db->having("nomb_cat LIKE '%".$data['categoria']."%'");
		}

		$query = $this->db->get();

		$result = array();
		$result['sEcho'] = $data['sEcho'];
		$result['iTotalRecords'] = $queryTotal->num_rows();
		$result['iTotalDisplayRecords'] = $queryLike->num_rows();


		$row = [];
		foreach ($query->result() as $q) {
			if ($q->esta_cat=='S') {
				$estado = '<label class="label label-success">Activo</label>';
			}elseif($q->esta_cat=='N'){
				$estado = '<label class="label label-info">Inactivo</label>';
			}	


			$botones = '<div class="btn-footer text-center">
                                          
                                                   <a href="'.base_url('mantenimiento/categoria/editar/'.$q->codi_cat).'"class="btn btn-primary" style="padding:2px 5px;margin:0px 2px"> <i class="fa fa-edit"></i> </a>
                                                   
                                                           
                                                     <button data-id="'.$q->codi_cat.'" class="anular btn btn-danger" style="padding:2px 5px;margin:0px 2px" >
                                                         <i class="glyphicon glyphicon-trash"></i> </button>';
            
			$row[] = [$q->codi_cat,$q->nomb_cat,$estado,$botones];
		}
		$result['aaData'] = $row;
		return $result;
	}

	public function agregarcategoria($data)
		{

			$this->db->insert('categoria',$data);
			return $this->db->insert_id();
		}

		public function getcategoriaid($id)
		{
				$this->db->where('codi_cat',$id);
				$resultado = $this->db->get('categoria');
				return $resultado->row();
		}
	
		public function update($id,$data)
		{
			$this->db->where('codi_cat',$id);
			return $this->db->update('categoria',$data);
		}
}