<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Comprobantes extends CI_Controller {
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
	}

	public function index()
	{
		$data['permisos'] =$this->permisos;
		$this->load->view('layouts/header');
		$this->load->view('layouts/aside');
		$this->load->view('admin/tratamientos/comprobantes/panel',$data);
		$this->load->view('layouts/footer');
	}

	public function jsonComprobantes()
	{
		$data['start'] = $this->input->get_post('start', true);
		$data['length'] = $this->input->get_post('length', true);
		$data['sEcho']  = $this->input->get_post('_', true);

		$columns = array('','secuencia_com','fecharegistro_pago','fechavencimiento_pago');
		$orderCampo = $this->input->get_post('order', true);
		$orderCampo = $orderCampo[0]['column'];
		$orderCampo = $columns[$orderCampo];
		$orderDireccion = $this->input->get_post('order', true);
		$orderDireccion = $orderDireccion[0]['dir'];
		$data['orderCampo'] = $orderCampo;
		$data['orderDireccion'] = $orderDireccion;

		if ($this->input->get_post('paciente')!='') {
			$data['paciente'] = $this->input->get_post('paciente');
		}
		$data['desde'] = $this->input->get_post('desde');
		$data['hasta'] = $this->input->get_post('hasta');
		$data['estado'] = $this->input->get_post('estado');
		$datos = $this->tratamientos_model->getComprobantes($data);
		header('content-type: application/json; charset=utf-8');
		echo json_encode($datos);
	}

	function imprimirLista()
	{
		$data['parametro'] = $this->modelgeneral->getTableWhereRow('parametro',['cod_parametro'=>1]);
		$data['desde'] = $this->input->get('desde');
		$data['hasta'] = $this->input->get('hasta');
		$data['estado'] = $this->input->get('estado');
		$data['paciente'] = $this->input->get('paciente');
		$this->mpdf = new mPDF('utf-8','A4','','',
			10, //LEFT
			10, //RIGHT
			40, //TOP
			10, //BOTTOM
			10, //HEADER
			10); //FOOTER
		$data['clinicas'] = $this->clinica_model->getClinica($data);
		$data['comprobantes'] = $this->tratamientos_model->getImprimirComprobantes($data);
		$html = $this->load->view('admin/tratamientos/comprobantes/imprimir_listado',$data,TRUE);
		$htmlHeader = $this->load->view('admin/tratamientos/comprobantes/imprimir_header',NULL,true);
		$htmlFooter = $this->load->view('admin/tratamientos/tratamientos/imprimir_footer',NULL,true);
		$css = $css = file_get_contents('assets/styles_pdf.css');
		$this->mpdf->SetTitle('Comprobantes');
		$this->mpdf->setHTMLHeader($htmlHeader);
		$this->mpdf->setHTMLFooter($htmlFooter);
		$this->mpdf->writeHTML($css,1);
		$this->mpdf->writeHTML($html,2);
		$this->mpdf->Output('assets/tratamiento.pdf','I');
	}

	function anularcomprobante()
	{
		$id = $this->input->get('id');
		$data['estado_com'] = 2;
		$where['id_com'] = $id;
		$this->modelgeneral->editRegist('comprobante',$where,$data);

		$pagos = $this->modelgeneral->getTableWhere('pago_comprobante',['id_com'=>$id]);

		foreach ($pagos as $p) {
			$this->db->where('id_pago',$p->id_pago)
			->set('estado_pago',1)
			->update('pago');

			$this->db->where('id_pago',$p->id_pago)
			->where('id_com',$id)
			->set('estado',2)
			->update('pago_comprobante');
		}


		$resp = [];
		$resp['success'] = true;
		echo json_encode($resp);
	}

}

/* End of file Comprobantes.php */
/* Location: ./application/controllers/tratamientos/Comprobantes.php */