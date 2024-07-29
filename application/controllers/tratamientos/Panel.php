<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Panel extends CI_Controller {
	private $permisos;
	public function __construct()
	{
		parent::__construct();
		if(!$this->session->userdata("login")){
			redirect(base_url());
		}
		$this->permisos = $this->backend_lib->control();
		$this->load->model('tratamientos_model');
		$this->load->model('clinica_model');
		$this->load->library('email');
	}

	public function index()
	{
		$data['permisos'] =$this->permisos;
		$this->load->view('layouts/header');
		$this->load->view('layouts/aside');
		$this->load->view('admin/tratamientos/tratamientos/panel',$data);
		$this->load->view('layouts/footer');
	}

	public function jsonTratamientos()
	{
		$data['start'] = $this->input->get_post('start', true);
		$data['length'] = $this->input->get_post('length', true);
		$data['sEcho']  = $this->input->get_post('_', true);

		$columns = array('','codi_tra','codi_pac','NombresApellidos','asunto_tra','fecha_tra');
		$orderCampo = $this->input->get_post('order', true);
		$orderCampo = $orderCampo[0]['column'];
		$orderCampo = $columns[$orderCampo];
		$orderDireccion = $this->input->get_post('order', true);
		$orderDireccion = $orderDireccion[0]['dir'];
		$data['orderCampo'] = $orderCampo;
		$data['orderDireccion'] = $orderDireccion;
		
		$desde = $this->input->get_post('desde');
		$hasta = $this->input->get_post('hasta');
		$estado = $this->input->get_post('estado');
		$paciente = $this->input->get_post('paciente');
		
		$data['desde'] = $desde;
		$data['hasta'] = $hasta;
		$data['estado'] = $estado;
		if ($paciente!='') {
			$data['paciente'] = $paciente;
		}
		$datos = $this->tratamientos_model->getTratamientos($data);
		header('content-type: application/json; charset=utf-8');
		echo json_encode($datos);
	}



	public function imprimirListaTratamientos()
	{
		$data['desde'] = $this->input->get('desde');
		$data['hasta'] = $this->input->get('hasta');
		$data['paciente'] = $this->input->get('paciente');
		$data['estado'] = $this->input->get('estado');
		$this->mpdf = new mPDF('utf-8','A4-L','','',
			10, //LEFT
			10, //RIGHT
			40, //TOP
			20, //BOTTOM
			10, //HEADER
			10);
		$data['clinicas'] = $this->clinica_model->getClinica($data);
		$data['tratamientos'] = $this->tratamientos_model->getTratamientosImprimir($data);
		$html = $this->load->view('admin/tratamientos/tratamientos/imprimir_listado',$data,TRUE);
		$htmlHeader = $this->load->view('admin/tratamientos/tratamientos/imprimir_header',$data,true);
		$htmlFooter = $this->load->view('admin/tratamientos/tratamientos/imprimir_footer',NULL,true);
		$css = $css = file_get_contents('assets/styles_pdf.css');
		$this->mpdf->SetTitle('Tratamientos');
		$this->mpdf->setHTMLHeader($htmlHeader);
		$this->mpdf->setHTMLFooter($htmlFooter);
		$this->mpdf->writeHTML($css,1);
		$this->mpdf->writeHTML($html,2);
		$this->mpdf->Output('assets/tratamiento.pdf','I');
	}



	function anularTratamiento()
	{
		$id = $this->input->get('id');

		$comprobantes = $this->db->from('pago_comprobante')
		->join('pago','pago_comprobante.id_pago = pago.id_pago')
		->where('codi_tra',$id)
		->where('pago_comprobante.estado',1)
		->get();

		$resp = [];

		if ($comprobantes->num_rows() > 0) {
			$resp['success'] = false;
			$resp['numero_comprobantes'] = $comprobantes->num_rows();	
		}else{
			$resp['success'] = true;
			$this->db->where('codi_tra',$id)
			->set('estado_tra',TRATAMIENTO_ANULADO)
			->set('estadopago_tra',ANULADO)
			->update('tratamiento');
		}

		echo json_encode($resp);

	}

	public function crearTratamientoEmail($id)
	{
		$archivo = 'assets/pdfs/tratamientos/'.$id.'-tratamiento.pdf';
		$this->mpdf = new mPDF('utf-8',"A4");
		$data['tratamiento'] = $this->tratamientos_model->getTratamiento($id);
		$html = $this->load->view('admin/tratamientos/tratamientos/imprimir',$data,TRUE);
		$css = $css = file_get_contents('assets/styles_pdf.css');
		$this->mpdf->SetTitle('Tratamiento');
		$this->mpdf->writeHTML($css,1);
		$this->mpdf->writeHTML($html,2);
		$this->mpdf->Output($archivo,'F');
		return $archivo;
	}

	public function nuevo()
	{
		$data['especialidades'] = $this->modelgeneral->getTable('especialidad');
		$data['pacientes'] = $this->modelgeneral->getTable('paciente');
		$data['procedimientos'] = $this->modelgeneral->getTableWhere('procedimiento',['estado'=>'S']);
		$this->load->view('layouts/header');
		$this->load->view('layouts/aside');
		$this->load->view('admin/tratamientos/tratamientos/nuevo',$data);
		$this->load->view('layouts/footer');
	}

	public function getProcedimiento()
	{
		$procedimiento = $this->modelgeneral->getTableWhereRow('procedimiento',['id_procedimiento'=>$this->input->get('id')]);
		$procedimiento->cant = $this->input->get('cant');
		$total = $this->input->get('cant') * $procedimiento->prec_procedimiento;
		$procedimiento->total = number_format($total,2);
		echo json_encode($procedimiento);
	}

	public function guardarTratamiento()
	{
		$this->form_validation->set_rules('especialidad', '', 'required');
		$this->form_validation->set_rules('medico', '', 'required');
		$this->form_validation->set_rules('paciente', '', 'required');
		$this->form_validation->set_rules('asunto', '', 'required');
		if ($this->form_validation->run() == TRUE){
			$data['codi_pac'] = $this->input->post('paciente');
			$data['fecha_tra'] = date('Y-m-d');
			$data['codi_med'] = $this->input->post('medico');
			$data['asunto_tra'] = $this->input->post('asunto');
			$data['observacion_tra'] = $this->input->post('observacion');
			$insert = $this->modelgeneral->insertRegist('tratamiento',$data);
			$resp = [];
			if (!is_null($insert)){
				$total = 0;
				foreach ($_POST['id'] as $key => $value) {
					$procedimiento = $this->modelgeneral->getTableWhereRow('procedimiento',['id_procedimiento'=>$value]);
					$dataDetalle['codi_tra'] = $insert;
					$dataDetalle['id_procedimiento'] = $procedimiento->id_procedimiento;
					$dataDetalle['preciounit_tradet'] = $procedimiento->prec_procedimiento;
					$dataDetalle['cant_tradet'] = $_POST['cant'][$key];
					$descuento = str_replace('%','',$_POST['desc'][$key]);
					$dataDetalle['descuento_tradet'] = $descuento;
					$dataDetalle['subtotal_tradet'] = ($_POST['cant'][$key] * $procedimiento->prec_procedimiento) - ((($_POST['cant'][$key] * $procedimiento->prec_procedimiento) * $descuento) / 100);
					$this->modelgeneral->insertRegist('tratamiento_detalle',$dataDetalle);
					$total += intVal($dataDetalle['subtotal_tradet']);
				}

				$dataTra['total_tra'] = $total;
				$where['codi_tra'] = $insert;
				$this->modelgeneral->editRegist('tratamiento',$where,$dataTra);
				$resp['success'] = true;
				$resp['redirect'] = 'tratamientos/panel';
			}else{
				$resp['success'] = false;
			}

			echo json_encode($resp);
		}
	}

	public function editar($id)
	{
		$data['especialidades'] = $this->modelgeneral->getTable('especialidad');
		$data['pacientes'] = $this->modelgeneral->getTable('paciente');
		$data['procedimientos'] = $this->modelgeneral->getTable('procedimiento');
		$tratamiento = $this->tratamientos_model->getTratamiento($id);
		$data['tratamiento'] = $tratamiento;
		$data['medicos'] = $this->modelgeneral->getTableWhere('medico',['cod_especialidad'=>$tratamiento->cod_especialidad]);
		$this->load->view('layouts/header');
		$this->load->view('layouts/aside');
		$this->load->view('admin/tratamientos/tratamientos/editar',$data);
		$this->load->view('layouts/footer');
	}

	public function editarGuardarTratamiento()
	{
		$this->form_validation->set_rules('especialidad', '', 'required');
		$this->form_validation->set_rules('medico', '', 'required');
		$this->form_validation->set_rules('paciente', '', 'required');
		$this->form_validation->set_rules('asunto', '', 'required');
		if ($this->form_validation->run() == TRUE){
			$data['codi_pac'] = $this->input->post('paciente');
			$data['codi_med'] = $this->input->post('medico');
			$data['asunto_tra'] = $this->input->post('asunto');
			$data['observacion_tra'] = $this->input->post('observacion');
			$where['codi_tra'] = $this->input->post('id_tratamiento');
			$edit = $this->modelgeneral->editRegist('tratamiento',$where,$data);

			$resp = [];
			if ($edit){
				$this->modelgeneral->deleteRegist('tratamiento_detalle',['codi_tra'=>$this->input->post('id_tratamiento')]);
				$total = 0;
				foreach ($_POST['id'] as $key => $value) {
					$procedimiento = $this->modelgeneral->getTableWhereRow('procedimiento',['id_procedimiento'=>$value]);
					$dataDetalle['codi_tra'] = $this->input->post('id_tratamiento');
					$dataDetalle['id_procedimiento'] = $procedimiento->id_procedimiento;
					$dataDetalle['preciounit_tradet'] = $procedimiento->prec_procedimiento;
					$dataDetalle['cant_tradet'] = $_POST['cant'][$key];
					$descuento = str_replace('%','',$_POST['desc'][$key]);
					$dataDetalle['descuento_tradet'] = $descuento;
					$dataDetalle['subtotal_tradet'] = ($_POST['cant'][$key] * $procedimiento->prec_procedimiento) - ((($_POST['cant'][$key] * $procedimiento->prec_procedimiento) * $descuento) / 100);
					$this->modelgeneral->insertRegist('tratamiento_detalle',$dataDetalle);
					$total += intVal($dataDetalle['subtotal_tradet']);
				}

				$dataTra['total_tra'] = $total;
				$this->modelgeneral->editRegist('tratamiento',$where,$dataTra);
				$resp['success'] = true;
				$resp['redirect'] = 'tratamientos/panel';
			}else{
				$resp['success'] = false;
			}

			echo json_encode($resp);
		}
	}

	function imprimirTratamiento($id)
	{
		$this->mpdf = new mPDF('utf-8',"A4");
		$data['tratamiento'] = $this->tratamientos_model->getTratamiento($id);
		$html = $this->load->view('admin/tratamientos/tratamientos/imprimir',$data,TRUE);
		$css = $css = file_get_contents('assets/styles_pdf.css');
		$this->mpdf->SetTitle('Tratamiento');
		$this->mpdf->writeHTML($css,1);
		$this->mpdf->writeHTML($html,2);
		$this->mpdf->Output('assets/tratamiento.pdf','I');
	}

	function imprimirComprobante($id)
	{
		$this->mpdf = new mPDF('utf-8',"A4");
		$data['comprobante'] = $this->tratamientos_model->getComprobante($id);
		$data['clinicas'] = $this->clinica_model->getClinica($data);
		$html = $this->load->view('admin/tratamientos/pagos/imprimir_comprobante',$data,TRUE);
		$css = $css = file_get_contents('assets/styles_pdf.css');
		$this->mpdf->SetTitle('Comprobante');
		
		$this->mpdf->writeHTML($css,1);
		$this->mpdf->writeHTML($html,2);
		$this->mpdf->Output('assets/comprobante.pdf','I');
	}

	function nuevoPago($id)
	{
		$tratamiento = $this->tratamientos_model->getTratamiento($id);
		$data['tratamiento'] = $tratamiento;
		$data['sin_descuento'] = $this->calcularSinDescuento($tratamiento);
		$data['tipo_documento'] = $this->modelgeneral->getTableWhere('tipo_documento',['estado'=>1]);
		$data['tipo_pago'] = $this->modelgeneral->getTableWhere('tipo_pago',['estado'=>1]);
		$data['tipo_tarjeta'] = $this->modelgeneral->getTableWhere('tipo_tarjeta',['estado'=>1]);
		$data['parametro'] = $this->modelgeneral->getTableWhereRow('parametro',['cod_parametro'=>1]);
		$this->load->view('layouts/header');
		$this->load->view('layouts/aside');
		$this->load->view('admin/tratamientos/pagos/nuevo_pago',$data);
		$this->load->view('layouts/footer');
	}

	function calcularSinDescuento($tratamiento)
	{
		$precio_real = 0;
		foreach ($tratamiento->detalle as $t) {
			$precio_real += $t->preciounit_tradet * $t->cant_tradet;
		}
		
		return  $precio_real;
	}

	function getPagoCuotas()
	{
		$data['tratamiento'] = $this->input->get('tratamiento');
		$data['peridiocidad'] = $this->input->get('peridiocidad');
		$data['numCuotas'] = $this->input->get('numCuotas');
		$data['fechaCuota'] = $this->input->get('fechaCuota');

		$res = $this->calcularPagoCuotas($data);
		echo json_encode($res);
	}

	function calcularPagoCuotas($data)
	{
		$codi_tra = $data['tratamiento'];
		$peridiocidad = $data['peridiocidad'];
		$numCuotas = $data['numCuotas'];
		$fechaCuota = $data['fechaCuota'];

		if ($peridiocidad=='Semanal') {
			$periodo = '+7 day';
		}elseif($peridiocidad=='Quincenal'){
			$periodo = '+14 day';
		}elseif($peridiocidad=='Mensual'){
			$periodo = '+28 day';
		}
		$tratamiento = $this->tratamientos_model->getTratamiento($codi_tra);
		$monto = $tratamiento->total_tra / $numCuotas;
		$cuotas = [];
		for ($i=1; $i <= $numCuotas ; $i++) { 
			if ($i>1) {
				$fechaCuota = strtotime($periodo,strtotime($fechaCuota));
				$fechaCuota = date('Y-m-d',$fechaCuota);
			}
			$cuotas[$i]['marcar'] = '<input type="checkbox" name="pago[]" value="'.$i.'">';
			$cuotas[$i]['num'] = $i;
			$cuotas[$i]['fecha_registro'] = date('Y-m-d');
			$cuotas[$i]['fecha_vencimiento'] = $fechaCuota;
			$cuotas[$i]['monto'] = round($monto,2);
		}
		return $cuotas;
	}

	function getParametro()
	{
		$parametro = $this->modelgeneral->getTableWhereRow('parametro',['cod_parametro'=>1]);
		echo json_encode($parametro);
	}

	function guardarPago()
	{
		$parametro = $this->modelgeneral->getTableWhereRow('parametro',['cod_parametro'=>1]);
		$igvparam = $parametro->igv;
		if ($this->input->post('condicionPago')=='Contado') {
			$this->modelgeneral->editRegist('tratamiento',['codi_tra'=>$this->input->post('tratamiento')],['condpago_tra'=>CONTADO,'estadopago_tra'=>COBRADO]);
			$dataPago['codi_tra'] = $this->input->post('tratamiento');
			$dataPago['num_pago'] = 1;
			$dataPago['estado_pago'] = FINALIZADO;
			$dataPago['fecharegistro_pago'] = date('Y-m-d');
			$dataPago['fechavencimiento_pago'] = date('Y-m-d');
			$dataPago['monto_pago'] = $this->input->post('total');
			$id_pago = $this->modelgeneral->insertRegist('pago',$dataPago);

			$dataComp['fecha_com'] = date('Y-m-d');
			$documento = $this->getDocumento($this->input->post('documento'));
			$dataComp['serie_com'] = $documento['serie'];
			$dataComp['secuencia_com'] = $documento['secuencia'];
			$dataComp['cod_tipodocumento'] = $this->input->post('documento');
			$dataComp['cod_tipopago'] = $this->input->post('tipoPago');
			if (isset($_POST['tipoTarjeta'])) {
				$dataComp['cod_tarjeta'] = $this->input->post('tipoTarjeta');
			}
			$dataComp['recibido_com'] = $this->input->post('montoRecibido');
			$dataComp['vuelto_com'] = $this->input->post('vuelto');
			$dataComp['subtotal_comp'] = $this->input->post('subtotal');
			$dataComp['igv_com'] = $this->input->post('IGV');
			if ($dataComp['igv_com']>0) {
				$dataComp['igvparam_com'] = $igvparam;
			}else{
				$dataComp['igvparam_com'] = 0;
			}
			$dataComp['total_comp'] = $this->input->post('total');
			$id_com = $this->modelgeneral->insertRegist('comprobante',$dataComp);
			$this->incrementarDocumento($this->input->post('documento'));

			$dataPagoCom['id_pago'] = $id_pago;
			$dataPagoCom['id_com'] = $id_com;
			$this->modelgeneral->insertRegist('pago_comprobante',$dataPagoCom);
		}

		if ($this->input->post('condicionPago')=='Cuotas') {
			$this->modelgeneral->editRegist('tratamiento',['codi_tra'=>$this->input->post('tratamiento')],['condpago_tra'=>CUOTAS,'estadopago_tra'=>PROCESO]);

			$datos['tratamiento'] = $this->input->post('tratamiento');
			$datos['peridiocidad'] = $this->input->post('peridiocidad');
			$datos['numCuotas'] = $this->input->post('numCuotas');
			$datos['fechaCuota'] = $this->input->post('fechaCuota');
			$cuotas = $this->calcularPagoCuotas($datos);

			$dataComp['fecha_com'] = date('Y-m-d');
			$documento = $this->getDocumento($this->input->post('documento'));
			$dataComp['serie_com'] = $documento['serie'];
			$dataComp['secuencia_com'] = $documento['secuencia'];
			$dataComp['cod_tipodocumento'] = $this->input->post('documento');
			$dataComp['cod_tipopago'] = $this->input->post('tipoPago');
			if (isset($_POST['tipoTarjeta'])) {
				$dataComp['cod_tarjeta'] = $this->input->post('tipoTarjeta');
			}
			$dataComp['recibido_com'] = $this->input->post('montoRecibido');
			$dataComp['vuelto_com'] = $this->input->post('vuelto');
			$dataComp['subtotal_comp'] = $this->input->post('subtotal');
			$dataComp['igv_com'] = $this->input->post('IGV');
			if ($dataComp['igv_com']>0) {
				$dataComp['igvparam_com'] = $igvparam;
			}else{
				$dataComp['igvparam_com'] = 0;
			}
			$dataComp['total_comp'] = $this->input->post('total');
			$id_com = $this->modelgeneral->insertRegist('comprobante',$dataComp);
			$this->incrementarDocumento($this->input->post('documento'));
			
			foreach ($cuotas as $key => $value) {
				$dataPago['codi_tra'] = $this->input->post('tratamiento');
				$dataPago['num_pago'] = $key;
				$dataPago['estado_pago'] = PENDIENTE; //PAGO PENDIENTE
				$dataPago['fecharegistro_pago'] = $value['fecha_registro'];
				$dataPago['fechavencimiento_pago'] = $value['fecha_vencimiento'];
				$dataPago['monto_pago'] = $value['monto'];
				$id_pago = $this->modelgeneral->insertRegist('pago',$dataPago);

			}

			foreach ($_POST['pago'] as $key => $value) {
				$wherePago['codi_tra'] = $this->input->post('tratamiento');
				$wherePago['num_pago'] = $value;
				$editPago['estado_pago'] = FINALIZADO;
				$this->modelgeneral->editRegist('pago',$wherePago,$editPago);

				$registro_pago = $this->modelgeneral->getTableWhereRow('pago',$wherePago);
				$dataPagoCom['id_pago'] = $registro_pago->id_pago;
				$dataPagoCom['id_com'] = $id_com;
				$this->modelgeneral->insertRegist('pago_comprobante',$dataPagoCom);
			}
		}

		$resp = [];
		$resp['success'] = true;
		$resp['redirect'] = 'tratamientos/panel';

		echo json_encode($resp);
	}

	function pagarCuota($id)
	{
		$tratamiento = $this->tratamientos_model->getTratamiento($id);
		$data['tratamiento'] = $tratamiento;
		$data['sin_descuento'] = $this->calcularSinDescuento($tratamiento);
		$data['tipo_documento'] = $this->modelgeneral->getTableWhere('tipo_documento',['estado'=>1]);
		$data['tipo_pago'] = $this->modelgeneral->getTableWhere('tipo_pago',['estado'=>1]);
		$data['tipo_tarjeta'] = $this->modelgeneral->getTableWhere('tipo_tarjeta',['estado'=>1]);
		$data['parametro'] = $this->modelgeneral->getTableWhereRow('parametro',['cod_parametro'=>1]);
		$data['cuotas'] = $this->tratamientos_model->getPagosCuotas($id);
		$data['monto_pago'] = $this->modelgeneral->getTableWhereRow('pago',['codi_tra'=>$id])->monto_pago;
		$this->load->view('layouts/header');
		$this->load->view('layouts/aside');
		$this->load->view('admin/tratamientos/pagos/pagar_cuota',$data);
		$this->load->view('layouts/footer');
	}

	function pagarCuotaGuardar()
	{
		$parametro = $this->modelgeneral->getTableWhereRow('parametro',['cod_parametro'=>1]);
		$igvparam = $parametro->igv;
		$dataComp['fecha_com'] = date('Y-m-d');
		$documento = $this->getDocumento($this->input->post('documento'));
		$dataComp['serie_com'] = $documento['serie'];
		$dataComp['secuencia_com'] = $documento['secuencia'];
		$dataComp['cod_tipodocumento'] = $this->input->post('documento');
		$dataComp['cod_tipopago'] = $this->input->post('tipoPago');
		if (isset($_POST['tipoTarjeta'])) {
			$dataComp['cod_tarjeta'] = $this->input->post('tipoTarjeta');
		}
		$dataComp['recibido_com'] = $this->input->post('montoRecibido');
		$dataComp['vuelto_com'] = $this->input->post('vuelto');
		$dataComp['subtotal_comp'] = $this->input->post('subtotal');
		$dataComp['igv_com'] = $this->input->post('IGV');
		if ($dataComp['igv_com']>0) {
			$dataComp['igvparam_com'] = $igvparam;
		}else{
			$dataComp['igvparam_com'] = 0;
		}
		$dataComp['total_comp'] = $this->input->post('total');
		$id_com = $this->modelgeneral->insertRegist('comprobante',$dataComp);
		$this->incrementarDocumento($this->input->post('documento'));

		foreach ($_POST['pago'] as $key => $value) {
			$wherePago['codi_tra'] = $this->input->post('tratamiento');
			$wherePago['num_pago'] = $value;
			$editPago['estado_pago'] = FINALIZADO;
			$this->modelgeneral->editRegist('pago',$wherePago,$editPago);

			$registro_pago = $this->modelgeneral->getTableWhereRow('pago',$wherePago);
			$dataPagoCom['id_pago'] = $registro_pago->id_pago;
			$dataPagoCom['id_com'] = $id_com;
			$this->modelgeneral->insertRegist('pago_comprobante',$dataPagoCom);
		}

		$pagos = $this->db->from('pago')
		->where('codi_tra',$this->input->post('tratamiento'))
		->where('estado_pago',PENDIENTE)
		->get();

		if ($pagos->num_rows()==0) {
			$whereTra['codi_tra'] = $this->input->post('tratamiento');
			$dataTra['estadopago_tra'] = COBRADO;
			$this->modelgeneral->editRegist('tratamiento',$whereTra,$dataTra);
		}

		$resp = [];
		$resp['success'] = true;
		$resp['redirect'] = 'tratamientos/panel';
		echo json_encode($resp);
	}

	public function getDocumento($doc=NULL)
	{
		if (is_null($doc)) {
			$doc = $this->input->get('documento');
			$json = true;
		}
		$documento = $this->modelgeneral->getTableWhereRow('tipo_documento',['cod_tipodocumento'=>$doc]);
		$resp['serie'] = $documento->serie;
		$resp['secuencia'] = str_pad($documento->correlativo_actual, 7, "0", STR_PAD_LEFT);

		if (isset($json)) {
			echo json_encode($resp);
		}else{
			return $resp;
		}
	}

	public function incrementarDocumento($doc)
	{
		$documento = $this->modelgeneral->getTableWhereRow('tipo_documento',['cod_tipodocumento'=>$doc]);
		$this->db->set('correlativo_actual',$documento->correlativo_actual+1)
		->where('cod_tipodocumento',$doc)
		->update('tipo_documento');
	}

}

/* End of file Panel.php */
/* Location: ./application/controllers/tratamientos/Panel.php */