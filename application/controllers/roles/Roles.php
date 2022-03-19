<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set('America/Asuncion');
class Roles extends CI_Controller
{
	//solo el constructor, para llamar a las clases
	public function __construct()
	{
		parent::__construct();
		$this->load->model(array("Permiso_model", "Rol_model"));
		$this->templates = new League\Plates\Engine(APPPATH.'views');
		$this->templates->addFolder('roles', APPPATH.'views/roles');
		$this->data = array('correcto'=>'','alerta'=>'','error'=>'', 'datos'=>'');

		// if (!$this->session->userdata("login")){
		// 	redirect(base_url());
		$this->load->model("Usuarios_model");
		// }s

	}
	public function comprobacionRoles(){
		$usuario = $this->session->userdata("DESUSUARIO");
		$idmodulo = 4;
		if (!$this->Usuarios_model->comprobarPermiso($usuario, $idmodulo)) {
			redirect(base_url());
		}
	}
	//esta funcion es la primera que se cargar
	public function index()
	{
	$this->comprobacionRoles();	
		//cargamos un array usando el modelo
		$roles = $this->Rol_model->getRoles();
		$data = array(
			'roles'=> $roles
		);
		echo $this->templates->render('roles::list', $data);
	}
	
	//funcion add para mostrar vistas
	public function add()
	{
		$this->comprobacionRoles();

		$data = array(			
			'maximos' => $this->Rol_model->ObtenerCodigo(),
			'modulos'=> $this->Rol_model->getModulos(),
			'pantallas'=> $this->Rol_model->getPantallas()
		);
		echo $this->templates->render('roles::add', $data);

	}
	//funcion vista
	public function view($id)
	{
		$this->comprobacionRoles();
		$data = array (
			'rol'=> $this->Rol_model->getRol($id)
		);
		//abrimos la vista view
		$this->load->view("roles/view", $data);
	}


	public function GetPantalla($id)
	{
		$this->comprobacionRoles();
		$data = array (
			'pantalla'=> $this->Rol_model->getPantalla($id)
		);

		//var_dump($data);
		$html = "";
		foreach ($data["pantalla"] as $pantalla) 
		{
			$html .= "<option value = ".$pantalla->IDPANTALLA."> ".$pantalla->DESPANTALLA." </option>";
		}
		echo $html;
	}

	//funcion para almacenar en la bd
	public function store()
	{
		$this->comprobacionRoles();
		// recibimos las variables
		$modulos = $this->input->post('modulo');
		$NumRol   = $this->input->post("NumRol");
		$desRol   = $this->input->post("Descripcion");
		$idRol = $this->Rol_model->ultimoNumero();


		$time = time();
		$fechaActual = date("Y-m-d H:i:s",$time);

		$empresa = $_SESSION["Empresa"];
		$sucursal = $_SESSION["Sucursal"];
		$usuario = $_SESSION["usuario"];

		$data = array(
			'idRol'  => $idRol->MAXIMO,
			'numrol'  => $NumRol,
			'descripcion'  => $desRol,
			'fecgra' => $fechaActual
		);

		$desRol = trim($desRol);
		if(trim($desRol) !="")
		{
			if($this->Rol_model->save($data))
			{
				//si todo esta bien, emitimos mensaje
				$this->session->set_flashdata('success', 'Rol registrado correctamente!');
				$rol_id = $this->Rol_model->ultimoInsert();
				foreach ($modulos as $modulo) {
					$data = array(
						'IDROL'=>$rol_id->IDROL,
						'IDPANTALLA' => $modulo['pantalla'], 
						'PERINSERT' => isset($modulo['insert']),
						'PERUPDATE'=>isset($modulo['update']),
						'PERDELETE'=>isset($modulo['delete']),
						'PERSELECT'=>isset($modulo['select'])
					);
					$this->Permiso_model->save($data);
					$permiso_id = $this->Permiso_model->ultimoInsert();
					// $data = array(
					// 	'IDROL'=> $rol_id->IDROL,
					// 	'IDPERMISO' => $permiso_id->IDPERMISO,
					// 	'FECGRA'=> $fechaActual
					// );
					// $this->Permiso_model->save_permiRoles($data);
				}
				redirect(base_url()."roles/roles", "refresh");

			}
			else
			{
				$this->session->set_flashdata('error', 'Rol no registrado!');
				redirect(base_url()."roles/roles/add", "refresh");
			}
		}
		else
		{	

			$this->session->set_flashdata('error', 'Ingrese Rol!');
			redirect(base_url()."roles/roles/add", "refresh");
		}	

	}

	//metodo para editar
	public function edit($id)
	{
		$this->comprobacionRoles();
		//recargamos datos en array, usando el modelo. ver en modelo, Servicios_model

		$data = array(
			'rol'=> $this->Rol_model->getRol($id),
			'permisos'=> $this->Permiso_model->getPermisosRol($id), 
			'modulos'=> $this->Rol_model->getModulos(),

		);


		$this->load->view('template/head');
		$this->load->view('template/menu');
		$this->load->view('roles/edit', $data);
		$this->load->view('template/footer');
	}

	//actualizamos 

	public function update()
	{
		$this->comprobacionRoles();
		$idRol= $this->input->post("idrol");
		$NumRol= $this->input->post("NumRol");
		$desRol= $this->input->post("Descripcion");
		$modulos = $this->input->post('modulo');
		$desRol = trim($desRol);
		if($desRol !="" && trim($desRol) !=""){
			//indicar campos de la tabla a modificar
			$data = array(
				'descripcion' => $desRol
			);

			if($this->Rol_model->update($idRol,$data)){
				foreach ($modulos as $modulo) {
					// echo '<pre>';
					// var_dump($_POST);
					// echo '</pre>';
					$idPermiso ='';
					$data = array(
						'IDPANTALLA' => $modulo['pantalla'], 
						'PERINSERT' => isset($modulo['insert']),
						'PERUPDATE'=>isset($modulo['update']),
						'PERDELETE'=>isset($modulo['delete']),
						'PERSELECT'=>isset($modulo['select'])
					);
					if ($idPermiso!='') {
						$idPermiso = $modulo['IDPERMISO'];
					}
					$this->Permiso_model->update($idRol, $idPermiso, $data);
				}
				$this->session->set_flashdata('success', 'Actualizado correctamente!');
				redirect(base_url()."roles/roles", "refresh");
				
			}
			else
			{
				$this->session->set_flashdata('error', 'Errores al Intentar Actualizar!');
				redirect(base_url()."roles/roles/edit/".$idRol,"refresh");
			}
		}
		else
		{	
			$this->session->set_flashdata('error', 'Ingrese Rol!');			
			redirect(base_url()."roles/roles/edit/".$idRol,"refresh");			
		}
	}

	public function delete($id)
	{
		$this->comprobacionRoles();

		if($this->Rol_model->delete($id)){
			$this->session->set_flashdata('success', 'Registro eliminado correctamente!');					
			redirect(base_url()."roles/roles", "refresh");
		}
		else
		{
			$this->session->set_flashdata('error', 'Errores al Intentar Eliminar!');
			redirect(base_url()."roles/roles", "refresh");		
		}
	}

}