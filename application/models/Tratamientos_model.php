<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tratamientos_model extends CI_Model {

	function getTratamientos($data)
	{
		$this->db->from('tratamiento');
		$this->db->join('paciente','tratamiento.codi_pac = paciente.codi_pac');
		$this->db->select('tratamiento.*,CONCAT(nomb_pac," ",apel_pac) AS NombresApellidos');
		if (isset($data['paciente'])) {
			$this->db->having("NombresApellidos LIKE '%".$data['paciente']."%'");
		}
		if (isset($data['desde']) AND isset($data['hasta'])) {
			$this->db->where('fecha_tra >=',$data['desde']);
			$this->db->where('fecha_tra <=',$data['hasta']);
		}
		if ($data['estado']=='Activo') {
			$this->db->where('estado_tra',TRATAMIENTO_ACTIVO);
		}elseif($data['estado']=='Anulado'){
			$this->db->where('estado_tra',TRATAMIENTO_ANULADO);
		}
		$queryLike = $this->db->get();

		$this->db->from('tratamiento');
		$this->db->join('paciente','tratamiento.codi_pac = paciente.codi_pac');
		$this->db->select('tratamiento.*,CONCAT(nomb_pac," ",apel_pac) AS NombresApellidos,estadopago_tra,condpago_tra');

		if ($data['length']!=-1) {
			$this->db->limit($data['length'],$data['start']);
		}
		if (isset($data['orderCampo'])) {
			$this->db->order_by($data['orderCampo'],$data['orderDireccion']);
		}
		if (isset($data['paciente'])) {
			$this->db->having("NombresApellidos LIKE '%".$data['paciente']."%'");
		}
		if (isset($data['desde']) AND isset($data['hasta'])) {
			$this->db->where('fecha_tra >=',$data['desde']);
			$this->db->where('fecha_tra <=',$data['hasta']);
		}
		if ($data['estado']=='Activo') {
			$this->db->where('estado_tra',TRATAMIENTO_ACTIVO);
		}elseif($data['estado']=='Anulado'){
			$this->db->where('estado_tra',TRATAMIENTO_ANULADO);
		}
		$query = $this->db->get();

		$result = array();
		$result['sEcho'] = $data['sEcho'];
		$result['iTotalRecords'] = $queryLike->num_rows();
		$result['iTotalDisplayRecords'] = $queryLike->num_rows();
		
		$row = [];
		foreach ($query->result() as $q) {
			if ($q->estadopago_tra==POR_COBRAR) {
				$estado = '<label class="label label-warning">Por Cobrar</label>';
			}elseif($q->estadopago_tra==PROCESO){
				$estado = '<label class="label label-info">Proceso</label>';
			}elseif($q->estadopago_tra==COBRADO){
				$estado = '<label class="label label-success">Cobrado</label>';
			}elseif($q->estadopago_tra==ANULADO){
				$estado = '<label class="label label-danger">Anulado</label>';
			}

			$opciones = '<div class="btn-group">
	                  <button type="button" class="btn btn-default btn-xs">Opciones</button>
	                  <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown">
	                    <span class="caret"></span>
	                    <span class="sr-only">Toggle Dropdown</span>
	                  </button>
	                  <ul class="dropdown-menu" role="menu">';
	    if ($q->estadopago_tra==POR_COBRAR) {
	    	$opciones .= '<li><a href="'.base_url('tratamientos/panel/nuevoPago/'.$q->codi_tra).'"><i class="fa fa-credit-card" aria-hidden="true"></i>Pago</a></li>';
	    }
	    if ($q->estadopago_tra==PROCESO) {
	    	$opciones .= '<li><a href="'.base_url('tratamientos/panel/pagarCuota/'.$q->codi_tra).'"><i class="fa fa-credit-card" aria-hidden="true"></i>Pagar Cuota</a></li>';
	    }
	    if ($q->estadopago_tra==PROCESO OR $q->estadopago_tra==POR_COBRAR) {
	    	$opciones .= '<li data-id="'.$q->codi_tra.'" class="tratamiento-anular"><a href="#"><i class="fa fa-trash-o" aria-hidden="true"></i>Anular</a></li>';
	    }
	    if (is_null($q->condpago_tra)) {
	    	$opciones .= '<li><a href="'.base_url('tratamientos/panel/editar/'.$q->codi_tra).'"><i class="fa fa-pencil" aria-hidden="true"></i>Editar</a></li>';
	    }
	    if ($q->condpago_tra==CUOTAS) {
	    	$pago = '<label class="label label-default">Cuotas</label>';
	    }else{
	    	$pago = '<label class="label label-default">Contado</label>';
	    }
	    $opciones .= '<li><a href="'.base_url('tratamientos/panel/imprimirTratamiento/'.$q->codi_tra).'" target="_blank"><i class="fa fa-print" aria-hidden="true"></i>Imprimir</a></li>
	                  </ul>
	                </div>';
	    $boton_detalle = '<button class="btn btn-md" ><span class="fa fa-caret-right"></span></button>';
	    $procedimientos = $this->detalleTratamiento($q->codi_tra);
	    $pagos = $this->detallePago($q->codi_tra);
			$row[] = [$boton_detalle,$q->codi_tra,$q->NombresApellidos,$q->asunto_tra,$q->fecha_tra,$q->total_tra,$pago,$estado,$opciones,$procedimientos,$pagos,$q->condpago_tra];
		}
		$result['aaData'] = $row;
		return $result;
	}

	function detalleTratamiento($tratamiento)
	{
		$detalle = $this->db->from('tratamiento_detalle')
		->select('tratamiento_detalle.*,procedimiento.nombre ')
		->join('procedimiento','tratamiento_detalle.id_procedimiento = procedimiento.id_procedimiento')
		->where('tratamiento_detalle.codi_tra',$tratamiento)
		->get()->result();
		return json_encode($detalle);
	}

	function detallePago($tratamiento)
	{
		$pago = $this->db->from('pago')
		->select('pago.*,comprobante.*,tipo_documento.descripcion,tipo_documento.abreviatura')
		->join('pago_comprobante','pago.id_pago = pago_comprobante.id_pago','left')
		->join('comprobante','pago_comprobante.id_com = comprobante.id_com AND estado_com = '.COMPROBANTE_VALIDO,'left')
		->join('tipo_documento','comprobante.cod_tipodocumento = tipo_documento.cod_tipodocumento','left')
		->where('codi_tra',$tratamiento)
		->order_by('num_pago','asc')
		->get()->result();
		return json_encode($pago);
	}

	function getTratamiento($id)
	{
		$tratamiento = $this->db->from('tratamiento')
		->select('tratamiento.*,especialidad.cod_especialidad,nombre_especialidad,nomb_pac,apel_pac,dire_pac,nomb_med,apel_med')
		->join('medico','tratamiento.codi_med = medico.codi_med')
		->join('especialidad','medico.cod_especialidad = especialidad.cod_especialidad')
		->join('paciente','tratamiento.codi_pac = paciente.codi_pac')
		->where('codi_tra',$id)
		->get()->row();

		$tratamiento->detalle =  $this->db->from('tratamiento_detalle')
		->select('tratamiento_detalle.*,procedimiento.nombre')
		->join('procedimiento','tratamiento_detalle.id_procedimiento = procedimiento.id_procedimiento')
		->where('tratamiento_detalle.codi_tra',$id)
		->get()->result();

		return $tratamiento;
	}

	function getPagosCuotas($tratamiento)
	{
		return $this->db->from('pago')
		->where('codi_tra',$tratamiento)
		->order_by('num_pago','asc')
		->get()->result();
	}

	function getComprobante($id)
	{
		$comprobante = $this->db->from('comprobante')
		->select('comprobante.*,tipo_documento.cod_tipodocumento,tipo_documento.descripcion,abreviatura,asunto_tra,tratamiento.codi_tra,paciente.codi_pac,paciente.nomb_pac,paciente.apel_pac,dni_pac,nomb_med,apel_med')
		->join('tipo_documento','comprobante.cod_tipodocumento = tipo_documento.cod_tipodocumento')
		->join('pago_comprobante','comprobante.id_com = pago_comprobante.id_com')
		->join('pago','pago_comprobante.id_pago = pago.id_pago')
		->join('tratamiento','pago.codi_tra = tratamiento.codi_tra')
		->join('paciente','tratamiento.codi_pac = paciente.codi_pac')
		->join('medico','tratamiento.codi_med = medico.codi_med')
		->where('comprobante.id_com',$id)
		->group_by('id_com')
		->get()->row();

		$comprobante->procedimientos = $this->db->from('tratamiento_detalle')
		->select('tratamiento_detalle.*,(preciounit_tradet  - ((preciounit_tradet * descuento_tradet)/100)) as precio_unitario,procedimiento.nombre')
		->join('procedimiento','tratamiento_detalle.id_procedimiento = procedimiento.id_procedimiento')
		->where('tratamiento_detalle.codi_tra',$comprobante->codi_tra)
		->get()->result();

		$comprobante->num = $this->db->from('pago')
		->where('codi_tra',$comprobante->codi_tra)
		->get()->num_rows();
		return $comprobante;
	}

	function getTratamientosImprimir($data)
	{
		$this->db->from('tratamiento');
		$this->db->select('tratamiento.*,CONCAT(nomb_pac," ",apel_pac) AS NombresApellidos,nomb_med,apel_med,nombre_especialidad');
		$this->db->join('paciente','tratamiento.codi_pac = paciente.codi_pac');
		$this->db->join('medico','tratamiento.codi_med = medico.codi_med');
		$this->db->join('especialidad','medico.cod_especialidad = especialidad.cod_especialidad');
		if (isset($data['paciente'])) {
			$this->db->having("NombresApellidos LIKE '%".$data['paciente']."%'");
		}
		if (isset($data['desde']) AND isset($data['hasta'])) {
			$this->db->where('fecha_tra >=',$data['desde']);
			$this->db->where('fecha_tra <=',$data['hasta']);
		}

		if ($data['estado']=='Activo') {
			$this->db->where('estado_tra',TRATAMIENTO_ACTIVO);
		}elseif($data['estado']=='Anulado'){
			$this->db->where('estado_tra',TRATAMIENTO_ANULADO);
		}

		$tratamientos = $this->db->get()->result();

		foreach ($tratamientos as $t) {
			$t->procedimientos = $this->db->from('tratamiento_detalle')
			->select('tratamiento_detalle.*,procedimiento.nombre')
			->join('procedimiento','tratamiento_detalle.id_procedimiento = procedimiento.id_procedimiento')
			->where('tratamiento_detalle.codi_tra',$t->codi_tra)
			->get()->result();
		}

		return $tratamientos;
	}

	function getComprobantes($data)
	{
		$this->db->from('pago');
		if ($data['estado']=='Emitido') {
			$this->db->select('pago.id_pago,fecharegistro_pago,fechavencimiento_pago,serie_com,secuencia_com,comprobante.id_com,CONCAT(nomb_pac," ",apel_pac) AS NombresApellidos,tipo_documento.*,SUM(monto_pago) as monto_pago_acumulado,SUM(monto_pago) as total');
		}else{
			$this->db->select('pago.id_pago,fecharegistro_pago,fechavencimiento_pago,CONCAT(nomb_pac," ",apel_pac) AS NombresApellidos,monto_pago as monto_pago_acumulado,SUM(monto_pago) as total');
		}
		$this->db->join('tratamiento','pago.codi_tra = tratamiento.codi_tra');
		$this->db->join('paciente','tratamiento.codi_pac = paciente.codi_pac');
		$this->db->where('fecha_tra >=',$data['desde']);
		$this->db->where('fecha_tra <=',$data['hasta']);
		if ($data['estado']=='Emitido' OR $data['estado']=='Anulado') {
			$this->db->join('pago_comprobante','pago.id_pago = pago_comprobante.id_pago','left');
			$this->db->join('comprobante','pago_comprobante.id_com = comprobante.id_com','left');
			$this->db->join('tipo_documento','comprobante.cod_tipodocumento = tipo_documento.cod_tipodocumento','left');
			$this->db->where('comprobante.id_com IS NOT NULL');
			if ($data['estado']=='Emitido') {
				$this->db->where('pago_comprobante.estado',1);
			}else{
				$this->db->where('pago_comprobante.estado',2);
			}
			$this->db->group_by('comprobante.id_com');
		}elseif($data['estado']=='Por Cobrar'){
			$this->db->where('estado_pago',1);
		}
		$queryTotal = $this->db->get()->result();

		$total = 0;
		foreach ($queryTotal as $t) {
			$total += $t->total;
		}


		$this->db->from('pago');
		if ($data['estado']=='Emitido') {
			$this->db->select('pago.id_pago,fecharegistro_pago,fechavencimiento_pago,serie_com,secuencia_com,comprobante.id_com,CONCAT(nomb_pac," ",apel_pac) AS NombresApellidos,tipo_documento.*,SUM(monto_pago) as monto_pago_acumulado');
		}else{
			$this->db->select('pago.id_pago,fecharegistro_pago,fechavencimiento_pago,CONCAT(nomb_pac," ",apel_pac) AS NombresApellidos,monto_pago as monto_pago_acumulado');
		}
		$this->db->join('tratamiento','pago.codi_tra = tratamiento.codi_tra');
		$this->db->join('paciente','tratamiento.codi_pac = paciente.codi_pac');
		$this->db->where('fecha_tra >=',$data['desde']);
		$this->db->where('fecha_tra <=',$data['hasta']);
		if ($data['estado']=='Emitido' OR $data['estado']=='Anulado') {
			$this->db->join('pago_comprobante','pago.id_pago = pago_comprobante.id_pago','left');
			$this->db->join('comprobante','pago_comprobante.id_com = comprobante.id_com','left');
			$this->db->join('tipo_documento','comprobante.cod_tipodocumento = tipo_documento.cod_tipodocumento','left');
			$this->db->where('comprobante.id_com IS NOT NULL');
			if ($data['estado']=='Emitido') {
				$this->db->where('pago_comprobante.estado',1);
			}else{
				$this->db->where('pago_comprobante.estado',2);
			}
			$this->db->group_by('comprobante.id_com');
		}elseif($data['estado']=='Por Cobrar'){
			$this->db->where('estado_pago',1);
		}
		$queryLike = $this->db->get();

		$this->db->from('pago');
		if ($data['estado']=='Emitido' OR $data['estado']=='Anulado') {
			$this->db->select('tratamiento.codi_tra,pago.id_pago,fecharegistro_pago,fechavencimiento_pago,serie_com,secuencia_com,comprobante.id_com,CONCAT(nomb_pac," ",apel_pac) AS NombresApellidos,tipo_documento.*,SUM(monto_pago) as monto_pago_acumulado');
		}else{
			$this->db->select('tratamiento.codi_tra,pago.id_pago,fecharegistro_pago,fechavencimiento_pago,CONCAT(nomb_pac," ",apel_pac) AS NombresApellidos,monto_pago as monto_pago_acumulado');
		}
		$this->db->join('tratamiento','pago.codi_tra = tratamiento.codi_tra');
		$this->db->join('paciente','tratamiento.codi_pac = paciente.codi_pac');
		$this->db->where('fecha_tra >=',$data['desde']);
		$this->db->where('fecha_tra <=',$data['hasta']);
		if ($data['estado']=='Emitido' OR $data['estado']=='Anulado') {
			$this->db->join('pago_comprobante','pago.id_pago = pago_comprobante.id_pago','left');
			$this->db->join('comprobante','pago_comprobante.id_com = comprobante.id_com','left');
			$this->db->join('tipo_documento','comprobante.cod_tipodocumento = tipo_documento.cod_tipodocumento','left');
			$this->db->where('comprobante.id_com IS NOT NULL');
			if ($data['estado']=='Emitido') {
				$this->db->where('pago_comprobante.estado',1);
			}else{
				$this->db->where('pago_comprobante.estado',2);
			}
			$this->db->group_by('comprobante.id_com');
		}elseif($data['estado']=='Por Cobrar'){
			$this->db->where('estado_pago',1);
		}

		if ($data['length']!=-1) {
			$this->db->limit($data['length'],$data['start']);
		}
		if (isset($data['orderCampo'])) {
			if ($data['estado']=='Emitido' OR $data['estado']=='Anulado') {
				$this->db->order_by($data['orderCampo'],$data['orderDireccion']);
			}
		}
		if (isset($data['paciente'])) {
			$this->db->having("NombresApellidos LIKE '%".$data['paciente']."%'");
		}
		$query = $this->db->get();

		$result = array();
		$result['sEcho'] = $data['sEcho'];
		$result['iTotalRecords'] = $queryLike->num_rows();
		$result['iTotalDisplayRecords'] = $queryLike->num_rows();
		$result['total'] = $total;
		
		$row = [];
		foreach ($query->result() as $q) {

			$opciones = '<div class="btn-group">
	                  <button type="button" class="btn btn-default btn-xs">Opciones</button>
	                  <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown">
	                    <span class="caret"></span>
	                    <span class="sr-only">Toggle Dropdown</span>
	                  </button>
	                  <ul class="dropdown-menu" role="menu">
	                  	<li><a href="'.base_url('tratamientos/panel/imprimirComprobante/'.$q->id_com).'" target="_blank" ><i class="fa fa-print" aria-hidden="true"></i>Imprimir</a></li>
	                  	<li role="separator" class="divider"></li>
	                  	<li><a href="#"data-id="'.$q->id_com.'" class="anular-comprobante"><i class="fa fa-trash-o" aria-hidden="true"></i> Anular</a></li>
										</ul>
	                </div>';
	    if (!is_null($q->id_com)) {
	    	$comprobante = json_encode($this->getComprobante($q->id_com));
	    }else{
	    	$comprobante = null;
	    }
	    $boton_detalle = '<button class="btn btn-md" ><span class="fa fa-caret-right"></span></button>';
			$row[] = [$boton_detalle,$q->serie_com.'-'.$q->secuencia_com,$q->fecharegistro_pago,$q->fechavencimiento_pago,$q->descripcion,$q->NombresApellidos,$q->monto_pago_acumulado,$data['estado'],$q->codi_tra,$opciones,$comprobante];
		}
		$result['aaData'] = $row;
		return $result;
	}

	function getImprimirComprobantes($data)
	{
		$this->db->from('pago');
		if ($data['estado']=='Emitido' OR $data['estado']=='Anulado') {
			$this->db->select('pago.id_pago,fecharegistro_pago,fechavencimiento_pago,serie_com,secuencia_com,comprobante.id_com,CONCAT(nomb_pac," ",apel_pac) AS NombresApellidos,tipo_documento.*,SUM(monto_pago) as monto_pago_acumulado');
		}else{
			$this->db->select('pago.id_pago,fecharegistro_pago,fechavencimiento_pago,CONCAT(nomb_pac," ",apel_pac) AS NombresApellidos,monto_pago as monto_pago_acumulado');
		}
		$this->db->join('tratamiento','pago.codi_tra = tratamiento.codi_tra');
		$this->db->join('paciente','tratamiento.codi_pac = paciente.codi_pac');
		$this->db->where('fecha_tra >=',$data['desde']);
		$this->db->where('fecha_tra <=',$data['hasta']);
		if ($data['estado']=='Emitido' OR $data['estado']=='Anulado') {
			$this->db->join('pago_comprobante','pago.id_pago = pago_comprobante.id_pago','left');
			$this->db->join('comprobante','pago_comprobante.id_com = comprobante.id_com','left');
			$this->db->join('tipo_documento','comprobante.cod_tipodocumento = tipo_documento.cod_tipodocumento','left');
			$this->db->where('comprobante.id_com IS NOT NULL');
			if ($data['estado']=='Emitido') {
				$this->db->where('pago_comprobante.estado',1);
			}else{
				$this->db->where('pago_comprobante.estado',2);
			}
			$this->db->group_by('comprobante.id_com');
		}elseif($data['estado']=='Por Cobrar'){
			$this->db->where('estado_pago',1);
		}
		$this->db->having("NombresApellidos LIKE '%".$data['paciente']."%'");
		$query = $this->db->get()->result();
		if ($data['estado']=='Emitido' or $data['estado']=='Anulado') {
		
			foreach ($query as $q) {
				$q->comprobante = $this->getComprobante($q->id_com);
			}
		}
		return $query;
	}

}

/* End of file Tratamientos_model.php */
/* Location: ./application/models/Tratamientos_model.php */