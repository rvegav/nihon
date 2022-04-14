<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
date_default_timezone_set('America/Asuncion');

class Usuarios extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		// if (!$this->session->userdata("login")){
		// 	redirect(base_url());
		// }
		$this->templates = new League\Plates\Engine(APPPATH.'views');
		$this->templates->addFolder('usuarios', APPPATH.'views/usuarios');
		$this->data = array('correcto'=>'','alerta'=>'','error'=>'', 'datos'=>'');
		$this->load->model(array('Usuarios_model', 'Rol_model', 'Empleados_model'));
		$this->load->library('Bcrypt');
		$this->comprobacionRoles();

	}
	public function comprobacionRoles()
	{
		$usuario = $this->session->userdata("sist_usuname");
		$idmodulo = 3;
		$pantalla = 10;
		if ($this->session->userdata('sist_conex')=='A') {
			if (!$this->Usuarios_model->getPermisosRol($usuario, $pantalla,$idmodulo)) {
				redirect(base_url());
			}
		}else{
			redirect(base_url());

		}
	}
	public function index()
	{
		$username = $this->session->userdata('sist_usuname');
		$this->comprobacionRoles();
		$data = array(
			'usuarios'=> $this->Usuarios_model->getUsuarios()
		);
		echo $this->templates->render('usuarios::list', $data);
	}
	public function view()
	{
		$this->comprobacionRoles();
		$id_usuario = $this->input->post('id', TRUE);
		$detalles = $this->Usuarios_model->getRolUsuario($id_usuario);
		if ($detalles) {
			foreach ($detalles as $detalle ) {
				$array = array();
				$array['ID']=$detalle->rol_id;
				$array['DESCRIPCION']=$detalle->rol_descripcion;
				$datos[] = $array;
				$data['data'] = $datos;
			}
		}else{
			$data = [];
		}
		echo json_encode($data);
	}
	public function add()
	{
		$this->comprobacionRoles();
		$data = array('empleados'=> $this->Empleados_model->getEmpleados(),
			'roles'=> $this->Rol_model->getRoles());
		echo $this->templates->render('usuarios::add', $data);
	}
	public function store()
	{
		$this->comprobacionRoles();
		$mensajes = $this->data;
		$this->form_validation->set_rules("username", "Usuario", "required");
		$this->form_validation->set_rules("pass_inicial", "Contraseña Generada", "required");
		$this->form_validation->set_rules("empl_id", "Empleado", "required");
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
			$empleado = $this->input->post('empl_id');
			// $opcion      = array('cost'=>12);
			// $password = password_hash($passinicial, PASSWORD_BCRYPT, array($opcion));
			$password = $this->bcrypt->hash_password($passinicial);
			$data = array(
				'usua_name'=> $username,
				'usua_empl_id'=> $empleado,
				'usua_clave'=> $password,
				'usua_fecha_creacion' => date("Y-m-d H:i:s"),
				'usua_fecha_modificacion'=>date("Y-m-d H:i:s")
			);
			$idusuario = $this->Usuarios_model->save($data);
			if ($idusuario) {
				foreach ($roles as $rol) {
					$data = array(
						'rol_usu_rol_id' => $rol,
						'rol_usu_usu_id' => $idusuario,
					);
					$this->Usuarios_model->save_rol_usuario($data);
				}
				$mensajes['correcto'] = '<p>Correcto</p>';
			}else{
				$mensajes['error'] = '<p>Usuario Existente</p>';
			}
		}
		echo json_encode($mensajes);
	}

	public function edit($id)
	{
		$this->comprobacionRoles();


		$data = array(			
			'rol' => $this->Rol_model->getRoles($id),
			'modulos'=> $this->Rol_model->getModulos(),
			'pantallas'=> $this->Rol_model->getPantallas(),
			'detalles' => $this->Rol_model->getDetalleRol($id)
		);
		echo $this->templates->render('roles::edit', $data);
	}
	public function generarContrasena($length = 12) 
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