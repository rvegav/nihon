<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
date_default_timezone_set('America/Asuncion');

class Usuarios extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model(array('Usuarios_model', 'Rol_model'));
		$this->data = array('correcto'=>'','alerta'=>'','error'=>'', 'datos'=>'');
		$this->load->model("Empleados_model");
		
		// $this->load->model("Usuarios_model", "Rol_model");

	}
	public function comprobacionRoles()
	{
		// $this->comprobacionRoles();
		$usuario = $this->session->userdata("DESUSUARIO");
		$idmodulo = 4;
		if (!$this->Usuarios_model->comprobarPermiso($usuario, $idmodulo)) {
			redirect(base_url());
		}
	}
	public function index()
	{
		$this->comprobacionRoles();
		$data = array('usuarios'=> $this->Usuarios_model->getUsuarios());
		$this->load->view('template/head');
		$this->load->view('template/menu');
		$this->load->view('usuarios/list', $data);
		$this->load->view('template/footer');
	}
	public function add()
	{
		$this->comprobacionRoles();
		$data = array('empleados'=> $this->Empleados_model->getEmpleados(),
			'roles'=> $this->Rol_model->getRoles());
		$this->load->view('template/head');
		$this->load->view('template/menu');
		$this->load->view('usuarios/add', $data);
		$this->load->view('template/footer');
	}
	public function store()
	{
		$this->comprobacionRoles();
		$mensajes = $this->data;
		$this->form_validation->set_rules("username", "Usuario", "required");
		$this->form_validation->set_rules("pass_inicial", "Contraseña Generada", "required");
		$this->form_validation->set_rules("idempleado", "Empleado", "required");
		$roles = $this->input->post('roles');
		if ($this->form_validation->run() == FALSE or count($roles)==0){
			if (count($roles)==0) {
				$mensajes['alerta'] = '<p>Debe Seleccionar al menos un Rol</p>';
			}else{
				$mensajes['alerta'] = validation_errors('<b style="color:red"><ul><li>', '</ul></li></b>');
			}

		}else{
			$username = $this->input->post('username');
			$passinicial = $this->input->post('pass_inicial');
			$empleado = $this->input->post('idempleado');
			$opcion      = array('cost'=>12);
			// $password = password_hash($passinicial, PASSWORD_BCRYPT, array($opcion));
			$data = array(
				'usua_name'=> $username,
				'usa_empl_id'=> $empleado,
				'usua_clave'=> $passinicial,
				'usua_fecha_creacion' => date("Y-m-d H:i:s"),
				'usua_fecha_modificacion'=>date("Y-m-d H:i:s")
			);
			$idusuario = $this->Usuarios_model->save($data);
			if ($idusuario) {

				foreach ($roles as $rol) {
					$data = array(
						'idrol' => $rol,
						'idusuario' => $idusuario,
						'fecgra' => date("Y-m-d H:i:s"),
					);
					$this->Usuarios_model->save_permiRoles($data);
				}
				$mensajes['correcto'] = '<p>Correcto</p>';
			}else{
				$mensajes['error'] = '<p>Usuario Existente</p>';
			}
		}
		echo json_encode($mensajes);
	}
	public function generarContrasena($length = 8) 
	{
		$this->comprobacionRoles();
		$str = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890";
		$password = "";
   		//Reconstruimos la contraseña segun la longitud que se quiera
		for($i=0;$i<$length;$i++) {
      		//obtenemos un caracter aleatorio escogido de la cadena de caracteres
			$password .= substr($str,rand(0,62),1);
		}

		echo json_encode($password);
	}
}

/* End of file Usuario.php */
/* Location: ./application/controllers/Usuario.php */