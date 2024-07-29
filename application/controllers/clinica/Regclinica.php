<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 
 */

/**
 * 
 */
class Regclinica extends CI_Controller {

  private $permisos;
  public function __construct()
	{
		parent::__construct();
		
		if(!$this->session->userdata("login")){
			redirect(base_url());
		}
		$this->permisos = $this->backend_lib->control();
		$this->load->model('modelgeneral');
		$this->load->model('clinica_model');

	}

  public function index()
  {
  		$data['permisos'] =$this->permisos;
		$this->load->helper('url');
		$this->load->view('layouts/header');
		$this->load->view('layouts/aside');
		$this->load->view('clinica/viewclinica',$data);
		$this->load->view('layouts/footer');
  }

  public function jsonClinica()
  {
  	$this->load->helper('url');
  	$list = $this->clinica_model->get_datatables();
  	$data = array();
	$no = $_POST['start'];
	foreach ($list as $clinica) {
			$no++;
			$row = array();
			$row[] = $clinica->nomb_clin;
			$row[] = $clinica->direc_clin;
			$row[] = $clinica->telf_clin;
			$row[] = $clinica->email_clin;
			$row[] = $clinica->ruc_clin;
			if($clinica->photo)
				$row[] = '<a href="'.base_url('assets/uploads/logo/'.$clinica->photo).'" target="_blank"><img src="'.base_url('assets/uploads/logo/'.$clinica->photo).'" class="img-responsive" /></a>';
			else
				$row[] = '(No photo)';
			//$row[] = $clinica->esta_clin;

			//add html for action
			$row[] = '<div class="btn-footer text-center"> <a class="btn btn-sm btn-success" style="padding:2px 5px;margin:0px 2px" href="javascript:void(0)" title="Edit" onclick="edit_clinica('."'".$clinica->id_clin."'".')"><i class="fa fa-edit"></i></a>';
				  
		
			$data[] = $row;
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->clinica_model->count_all(),
						"recordsFiltered" => $this->clinica_model->count_filtered(),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
  }

  public function ajax_edit($id)
	{
		$data = $this->clinica_model->get_by_id($id);
		$data->fecha_clin = ($data->fecha_clin == '0000-00-00') ? '' : $data->dob; // if 0000-00-00 set tu empty for datepicker compatibility
		echo json_encode($data);
	}

  public function ajax_update()
	{
		//$this->_validate();
		$data = array(
				'nomb_clin' => $this->input->post('nomb_clin'),
				'direc_clin' => $this->input->post('direc_clin'),
				'telf_clin' => $this->input->post('telf_clin'),
				'email_clin' => $this->input->post('email_clin'),
				'ruc_clin' => $this->input->post('ruc_clin'),
				'fecha_clin' => $this->input->post('fecha_clin'),
			);

		if($this->input->post('remove_photo')) // if remove photo checked
		{
			if(file_exists('assets/uploads/logo/'.$this->input->post('remove_photo')) && $this->input->post('remove_photo'))
				unlink('assets/uploads/logo/'.$this->input->post('remove_photo'));
			$data['photo'] = '';
		}

		if(!empty($_FILES['photo']['name']))
		{
			$upload = $this->_do_upload();
			
			//delete file
			$clinica = $this->clinica_model->get_by_id($this->input->post('id_clin'));
			if(file_exists('assets/uploads/logo/'.$clinica->photo) && $clinica->photo)
				unlink('assets/uploads/logo/'.$clinica->photo);

			$data['photo'] = $upload;
		}

		$this->clinica_model->update(array('id_clin' => $this->input->post('id_clin')), $data);
		echo json_encode(array("status" => TRUE));
	}

	private function _do_upload()
	{
		$config['upload_path']          = 'assets/uploads/logo/';
        $config['allowed_types']        = 'png|jpg|jpeg';
        $config['max_size']             = 100; //set max size allowed in Kilobyte
        $config['max_width']            = 1000; // set max width image allowed
        $config['max_height']           = 1000; // set max height allowed
        $config['file_name']            = 'logogeneral-'.time().'.png'; //just milisecond timestamp fot unique name
        $this->upload->initialize($config);
       $this->load->library('upload', $config);

        if(!$this->upload->do_upload('photo')) //upload and validate
        {
            $data['inputerror'][] = 'photo';
			$data['error_string'][] = 'Upload error: '.$this->upload->display_errors('',''); //show ajax error
			$data['status'] = FALSE;
			echo json_encode($data);
			exit();
		}
		return $this->upload->data('file_name');
	}



}