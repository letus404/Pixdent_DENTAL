<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Historia_model extends CI_Model {

	function getHistoria($data)
	{
		$medico = $this->session->userdata('medico');
		$rol = $this->session->userdata('rol');
		$this->db->from('cita_medica');
		$this->db->join('paciente','cita_medica.codi_pac = paciente.codi_pac');
		$this->db->where_not_in('cita_medica.cod_citado','2');
		$this->db->where('DATE(fech_cit) >=',$data['desde']);
		$this->db->where('DATE(fech_cit) <=',$data['hasta']);
		if ($rol==1) {
			$this->db->where('codi_med',$medico);
		}

		$queryLike = $this->db->get();

		$this->db->from('cita_medica');
		$this->db->select('cita_medica.codi_pac,CONCAT(nomb_pac," ",apel_pac) AS NombresApellidos,edad_pac,dni_pac, DATE(fech_cit) as fecha_cita,TIME(fech_cit) as hora_cita,esta_pac');
		$this->db->join('paciente','cita_medica.codi_pac = paciente.codi_pac');
		$this->db->where_not_in('cita_medica.cod_citado','2');
		$this->db->where('DATE(fech_cit) >=',$data['desde']);
		$this->db->where('DATE(fech_cit) <=',$data['hasta']);
		
		if ($rol==1) {
			$this->db->where('codi_med',$medico);
		}
		if (isset($data['nombresApellidos'])) {
			$this->db->having("NombresApellidos LIKE '%".$data['nombresApellidos']."%'");
		}
		$query = $this->db->get();

		$result = array();
		$result['sEcho'] = $data['sEcho'];
		$result['iTotalRecords'] = $queryLike->num_rows();
		$result['iTotalDisplayRecords'] = $queryLike->num_rows();
		
		$row = [];
		foreach ($query->result() as $q) {
			if ($q->esta_pac=='S') {
				$estado = '<label class="label label-success">Activo</label>';
			}elseif($q->esta_pac=='N'){
				$estado = '<label class="label label-info" style="text-align: center;">Inactivo</label>';
			}	

			$opciones = '<div class="btn-footer text-center">

			<a href="'.base_url('historia/movimiento/historia/'.$q->codi_pac).'" class="btn btn-info btn-xs" style="text-align:center"><i class="fa fa-edit"></i></a>';
	    
			$row[] = [$q->codi_pac,$q->NombresApellidos,$q->edad_pac,$q->dni_pac,$q->fecha_cita,$q->hora_cita,$estado,$opciones];
		}
		$result['aaData'] = $row;
		return $result;
	}

	function getAlergias($data)
	{
		$this->db->from('paciente_alergia');
		$this->db->join('alergia','paciente_alergia.cod_ale = alergia.cod_ale');
		$this->db->where('codi_pac',$data['paciente']);
		$this->db->where('pacale_estado',1);
		$queryLike = $this->db->get();

		$this->db->from('paciente_alergia');
		$this->db->join('alergia','paciente_alergia.cod_ale = alergia.cod_ale');
		$this->db->where('codi_pac',$data['paciente']);
		$this->db->where('pacale_estado',1);
		if ($data['length']!=-1) {
			$this->db->limit($data['length'],$data['start']);
		}
		if (isset($data['orderCampo'])) {
			$this->db->order_by($data['orderCampo'],$data['orderDireccion']);
		}
		$query = $this->db->get();

		$result = array();
		$result['sEcho'] = $data['sEcho'];
		$result['iTotalRecords'] = $queryLike->num_rows();
		$result['iTotalDisplayRecords'] = $queryLike->num_rows();
		
		$row = [];
		foreach ($query->result() as $q) {
			$boton = '<div class="btn-footer text-center">
			<button data-id="'.$q->pacale_id.'" class="editar-alergia btn btn-warning btn-xs" data-toggle="modal" data-target="#ModalEditarAlergia">Editar</button>';


			$boton .= '<a></a> <button data-id="'.$q->pacale_id.'" class="anular-alergia btn btn-danger btn-xs">Anular</button>';
			$row[] = [$q->pacale_id,$q->nombre_ale,$q->pacale_observacion,$boton];
		}
		$result['aaData'] = $row;
		return $result;
	}

	

	function getDiagnostico($data)
	{
		$this->db->from('paciente_diagnostico');
		$this->db->where('codi_pac',$data['paciente']);
		$this->db->where('pacdiag_estado',1);
		$queryLike = $this->db->get();

		$this->db->from('paciente_diagnostico');
		$this->db->select('pacdiag_id,pacdiag_fecha,codi_enf01,a.desc_enf as diagnostico01');
		$this->db->join('enfermedad as a','paciente_diagnostico.codi_enf01 = a.codi_enf','left');
		$this->db->where('codi_pac',$data['paciente']);
		$this->db->where('pacdiag_estado',1);
		if ($data['length']!=-1) {
			$this->db->limit($data['length'],$data['start']);
		}
		if (isset($data['orderCampo'])) {
			$this->db->order_by($data['orderCampo'],$data['orderDireccion']);
		}
		$query = $this->db->get();

		$result = array();
		$result['sEcho'] = $data['sEcho'];
		$result['iTotalRecords'] = $queryLike->num_rows();
		$result['iTotalDisplayRecords'] = $queryLike->num_rows();
		
		$row = [];
		foreach ($query->result() as $q) {
			$boton = '<div class="btn-footer text-center">
			<button data-id="'.$q->pacdiag_id.'" class="editar-diagnostico btn btn-warning btn-xs" data-toggle="modal" data-target="#ModalEditarDiagnostico">Editar</button>';
			$boton .= '<button data-id="'.$q->pacdiag_id.'" class="anular-diagnostico btn btn-danger btn-xs">Anular</button>';
			//$siglas=$q->codi_enf01;
			$diagnostico = $q->diagnostico01;

			$row[] = [
				$q->pacdiag_fecha,
				$q->codi_enf01,
				$diagnostico,
				$boton
			];
		}
		$result['aaData'] = $row;
		return $result;
	}

	function getPlacas($data)
	{
		$this->db->from('paciente_placa');
		$this->db->where('codi_pac',$data['paciente']);
		$this->db->where('pla_estado',1);
		$queryLike = $this->db->get();

		$this->db->from('paciente_placa');
		$this->db->where('codi_pac',$data['paciente']);
		$this->db->where('pla_estado',1);
		if ($data['length']!=-1) {
			$this->db->limit($data['length'],$data['start']);
		}
		if (isset($data['orderCampo'])) {
			$this->db->order_by($data['orderCampo'],$data['orderDireccion']);
		}
		$query = $this->db->get();

		$result = array();
		$result['sEcho'] = $data['sEcho'];
		$result['iTotalRecords'] = $queryLike->num_rows();
		$result['iTotalDisplayRecords'] = $queryLike->num_rows();
		
		$row = [];
		foreach ($query->result() as $q) {
			$boton = '<div class="btn-footer text-center">

			<button data-id="'.$q->pla_id.'" class="anular-placa btn btn-danger btn-xs">Anular</button>
			<button data-id="'.$q->pla_id.'" class="editar-placa btn btn-warning btn-xs">Editar</button>';
			$archivo = '
			<a data-fancybox="gallery" href="'.base_url('assets/uploads/placas/'.$q->pla_archivo).'"><i class="fa fa-image"></i> Ver placa</a>';
			$row[] = [
				$q->pla_fecha,
				$q->pla_nombre,
				$q->pla_notas,
				$archivo,
				$boton
			];
		}
		$result['aaData'] = $row;
		return $result;
	}

	function getHistoriaImprimir($id)
	{
		$paciente = $this->db->from('paciente')
		->select("paciente.*,CONCAT(apel_pac,' ', nomb_pac) as paciente, dni_pac as dni, CASE sexo_pac WHEN 'M' THEN 'Masculino' ELSE 'Femenino' END as sexo,telf_pac as telefono, dire_pac as direccion,civi_pac as estadocivil,edad_pac as edad,emai_pac as email,paises.nombre as pais, lugar_nacimiento as lugarnacimiento, fena_pac as fechanacimiento, CASE estudios_pac WHEN 'S' THEN 'Secundaria Completa' WHEN 'U' THEN 'Universitario Superior' WHEN 'P' THEN 'Primaria Completa' ELSE 'No Especifica' END as estudios,ocupacion as ocupacion, CASE civi_pac WHEN 'C' THEN 'Casado' WHEN 'S' THEN 'Soltero' WHEN 'V' THEN 'Viudo(a)' ELSE 'Divorciado(a)' END as civil,informacion_clinica as entero, departamento.departamento_nombre as departamento,
			provincia.provincia_nombre as provincia,
			distrito.distrito_nombre as distrito,
		    paciente_enfermedadactual.motivo_enfact as motivo,
		    paciente_enfermedadactual.tiempo_enfact as enfermedad,
            CASE paciente_enfermedadactual.medicam_enfact
            WHEN 1 THEN 'Si'
            ELSE 'No' END AS 'medicamento',
		    paciente_enfermedadactual.nommedicam_enfact as nombmedi,
		    paciente_enfermedadactual.antecper_enfact as antecpersonales,
		    paciente_enfermedadactual.antecfam_enfact as antecfamiliares,
		    CASE paciente_consulta.ortod_paccon WHEN 1 THEN 'Si' ELSE 'No' END  as consulortodoncia,
		    paciente_consulta.ortodtexto_paccon  as respuesta1,
		    CASE paciente_consulta.medic_paccon WHEN 1 THEN 'Si' ELSE 'No' END as consutmedicamento,
		    paciente_consulta.medictexto_paccon as respuesta2,
		    CASE paciente_consulta.alergico_paccon WHEN 1 THEN 'Si' ELSE 'No' END as consulalergico,
		    paciente_consulta.alergicotexto_paccon as respuesta3,
		    CASE paciente_consulta.hosp_paccon WHEN 1 THEN 'Si' ELSE 'No' END as consulhospi,
		    paciente_consulta.hosptexto_paccon as respuesta4,
		    CASE paciente_consulta.trans_paccon   WHEN 1 THEN 'Si' ELSE 'No' END as consultranstorno,
		    paciente_consulta.transtexto_paccon as respuesta5,
		    paciente_consulta.padece_paccon  as padece,
		    CASE paciente_consulta.cepilla_paccon WHEN 1 THEN 'Si' ELSE 'No' END as consulcepilla,
		    paciente_consulta.cepillatexto_paccon as respuesta6,
		    CASE paciente_consulta.presion_paccon WHEN 1 THEN 'Si' ELSE 'No' END as consulpresion,
		    paciente_consulta.presiontexto_paccon as respuesta7,
		    paciente_exploracion.pa_exp as exploracion,
		    paciente_exploracion.pulso_exp as pulso,
		    paciente_exploracion.temperat_exp as temperatura,
		    paciente_exploracion.fc_exp as fcardiaca,
		    paciente_exploracion.frec_exp as frespiratoria,
		    paciente_exploracion.peso_exp as peso,
		    paciente_exploracion.talla_exp as talla,
		    paciente_exploracion.masa_exp as imc,
		    paciente_exploracion.clinico_exp as exmclinico,
		    paciente_exploracion.complement_exp as exmcomplet,
		    paciente_exploracion.odontoesto_exp as exmodonto" )
		  
		->join('paises','paciente.pais_id=paises.id')
		->join('departamento','paciente.departamento_id=departamento.departamento_id')
		->join('provincia','paciente.provincia_id=provincia.provincia_id')
		->join('distrito','paciente.distrito_id=distrito.distrito_id')
		->join('paciente_enfermedadactual','paciente_enfermedadactual.codi_pac=paciente.codi_pac')
		->join('paciente_consulta','paciente_consulta.codi_pac=paciente.codi_pac')
		->join('paciente_exploracion','paciente_exploracion.codi_pac=paciente.codi_pac')
		->where('paciente.codi_pac',$id)
		->get()->row();

		$paciente->alergias = $this->db->from('paciente_alergia')
		->join('alergia','paciente_alergia.cod_ale = alergia.cod_ale')
		->where('codi_pac',$id)
		->get()->result();

		$paciente->odinicial = $this->db->from('paciente_odontograma')
		->join('hallazgos','paciente_odontograma.id_hal=hallazgos.id_hal')
		->join('dientes','paciente_odontograma.numero_die=dientes.numero_die')
		->where('paciente_odontograma.pacodo_tipo','Inicial')
		->where('codi_pac',$id)
		->get()->result();

		$paciente->evolucionado = $this->db->from('paciente_odontograma')
		->join('hallazgos','paciente_odontograma.id_hal=hallazgos.id_hal')
		->join('dientes','paciente_odontograma.numero_die=dientes.numero_die')
		->where('paciente_odontograma.pacodo_tipo','Evolucion')
		->where('codi_pac',$id)
		->get()->result();

		$paciente->evolucion = $this->db->from('paciente_evolucion')
		->join('especialidad','paciente_evolucion.cod_especialidad = especialidad.cod_especialidad')
		->join('medico','paciente_evolucion.codi_med = medico.codi_med')
		->where('paciente_evolucion.pacevol_estado','1')
		->where('codi_pac',$id)
		->get()->result();

		$paciente->receta = $this->db->from('paciente_receta')
		->where('paciente_receta.pacrec_estado','1')
		->where('codi_pac',$id)
		->get()->result();

		$paciente->pacdiagnostico = $this->db->from('paciente_diagnostico')
		->join('enfermedad','paciente_diagnostico.codi_enf01 = enfermedad.codi_enf')
		->where('paciente_diagnostico.pacdiag_estado','1')
		->where('codi_pac',$id)
		->get()->result();

		return $paciente;
	}




	function getEvolucion($data)
	{
		$this->db->from('paciente_evolucion');
		$this->db->join('medico','paciente_evolucion.codi_med = medico.codi_med');
		$this->db->join('especialidad','paciente_evolucion.cod_especialidad=especialidad.cod_especialidad');
		$this->db->where('codi_pac',$data['paciente']);
		$this->db->where('pacevol_estado',1);
		$queryLike = $this->db->get();

		$this->db->from('paciente_evolucion');
		$this->db->select('paciente_evolucion.*, fecha_evolucion,pacevol_descripcion,CONCAT(nomb_med," ",apel_med) as medico, nombre_especialidad');
		$this->db->join('medico','paciente_evolucion.codi_med = medico.codi_med');
		$this->db->join('especialidad','paciente_evolucion.cod_especialidad=especialidad.cod_especialidad');
		$this->db->where('codi_pac',$data['paciente']);
		$this->db->where('pacevol_estado',1);
		if ($data['length']!=-1) {
			$this->db->limit($data['length'],$data['start']);
		}
		if (isset($data['orderCampo'])) {
			$this->db->order_by($data['orderCampo'],$data['orderDireccion']);
		}
		$query = $this->db->get();

		$result = array();
		$result['sEcho'] = $data['sEcho'];
		$result['iTotalRecords'] = $queryLike->num_rows();
		$result['iTotalDisplayRecords'] = $queryLike->num_rows();
		
		$row = [];
		foreach ($query->result() as $q) {
			$boton = '<div class="btn-footer text-center">
			<button data-id="'.$q->pacevol_id.'" class="editar-evolucion btn btn-warning btn-xs" data-toggle="modal" data-target="#ModalEditarEvolucion">Editar</button>';


			$boton .= '<a></a> <button data-id="'.$q->pacevol_id.'" class="anular-evolucion btn btn-danger btn-xs">Anular</button>';
			$row[] = [$q->fecha_evolucion,$q->pacevol_descripcion,$q->medico,$q->nombre_especialidad,$boton];
		}
		$result['aaData'] = $row;
		return $result;
	}


	function getListadoCitas($data)
	{
		$this->db->from('cita_medica');
		$this->db->join('especialidad','cita_medica.cod_especialidad=especialidad.cod_especialidad');
		$this->db->join('medico','cita_medica.codi_med=medico.codi_med');
		$this->db->join('tipo_citado','cita_medica.cod_citado=tipo_citado.cod_citado');
		$this->db->where('codi_pac',$data['paciente']);
		$queryLike = $this->db->get();

		$this->db->from('cita_medica');
		$this->db->select('cita_medica.*,codi_cit,fech_cit,nombre_especialidad,concat(nomb_med," ",apel_med) as medico,nomb_citado');
		//$this->db->join('paciente','cita_medica.codi_pac=paciente.codi_pac');
		$this->db->join('especialidad','cita_medica.cod_especialidad=especialidad.cod_especialidad');
		$this->db->join('medico','cita_medica.codi_med=medico.codi_med');
		$this->db->join('tipo_citado','cita_medica.cod_citado=tipo_citado.cod_citado');
		$this->db->where('codi_pac',$data['paciente']);
		if ($data['length']!=-1) {
			$this->db->limit($data['length'],$data['start']);
		}
		if (isset($data['orderCampo'])) {
			$this->db->order_by($data['orderCampo'],$data['orderDireccion']);
		}
		$query = $this->db->get();

		$result = array();
		$result['sEcho'] = $data['sEcho'];
		$result['iTotalRecords'] = $queryLike->num_rows();
		$result['iTotalDisplayRecords'] = $queryLike->num_rows();
		$row = [];
			foreach ($query->result() as $q) {	


			$botones = '<div class="btn-footer text-center">
			<button data-id="'.$q->codi_cit.'" class="editar-citahistoria btn btn-warning btn-xs" data-toggle="modal" data-target="#ModalEditarCitaHistoria">Editar</button>';

			$row[] = [$q->codi_cit,$q->fech_cit,$q->nombre_especialidad,$q->medico,$q->nomb_citado,$botones];
		}
		$result['aaData'] = $row;
		return $result;
	}


	function getTrataHistoria($data)
	{

		$this->db->from('tratamiento');
	//	$this->db->join('medico','tratamiento.codi_med=medico.codi_med');
		$this->db->where('codi_pac',$data['paciente']);
		$this->db->where('estado_tra',1);
		$queryLike = $this->db->get();

		$this->db->from('tratamiento');
		$this->db->select('tratamiento.*,codi_tra,asunto_tra,fecha_tra,total_tra,estadopago_tra');
		$this->db->where('codi_pac',$data['paciente']);
		$this->db->where('estado_tra',1);
		if ($data['length']!=-1) {
			$this->db->limit($data['length'],$data['start']);
		}
		if (isset($data['orderCampo'])) {
			$this->db->order_by($data['orderCampo'],$data['orderDireccion']);
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
	    
	    $opciones= '<a href="'.base_url('tratamientos/panel/imprimirTratamiento/'.$q->codi_tra).'" target="_blank"><i class="fa fa-print" aria-hidden="true"></i></a>';
	    
			$row[] = [$q->codi_tra,$q->asunto_tra,$q->fecha_tra,$q->total_tra,$estado,$opciones];
		}
		$result['aaData'] = $row;
		return $result;
	}

}

/* End of file Historia_model.php */
/* Location: ./application/models/Historia_model.php */