<?php 
class Unauthenticated
{
	private $ci;

	public function __construct()
	{
		$this->ci                  = & get_instance();
		$this->ci->config->load('permisos',TRUE);
	}

	public function checkAccess()
	{
		$session = $this->ci->session->userdata('Login');
		$uri = $this->ci->uri->segment(1);
		if (!$session AND $uri =='dashboard') {
			$class = $this->ci->router->class;
			$method = $this->ci->router->method;

			$methodsAllowed = ['index','validate','verificaEmailPassword','registrar','getProvincias','getDistritos','validaEmail','guardarusuario','enviarNotificacion','verificarCuenta','olvideContrasena','olvideVerificaEmail','enviarEmailReestablecerContrasena','reestablecerContrasena','guardarReestablecerContrasena'];
			if ($class=='login') {
				if (!in_array($method, $methodsAllowed)) {
					redirect('Auth/login','refresh');
				}
			}elseif($class!='login'){
				redirect('Auth/login','refresh');
			}
		}
	}

}


 ?>