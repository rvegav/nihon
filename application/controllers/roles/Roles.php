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
			'maximo' => $this->Rol_model->ObtenerCodigo(),
			'modulos'=> $this->Rol_model->getModulos(),
			'pantallas'=> $this->Rol_model->getPantallas()
		);
		echo $this->templates->render('roles::add', $data);
	}
	public function view()
	{
		$this->comprobacionRoles();
		$id_rol = $this->input->post('id', TRUE);
		$detalles = $this->Rol_model->getDetalleRol($id_rol);
		if ($detalles) {
			foreach ($detalles as $detalle ) {
				$array = array();
				$array['PANTALLA']=$detalle->pant_descripcion;
				$array['INSERCION']=$detalle->insercion;
				$array['ACTUALIZACION']=$detalle->actualizacion;
				$array['BORRADO']=$detalle->borrado;
				$array['VISUALIZACION']=$detalle->visualizacion;
				$datos[] = $array;
				$data['data'] = $datos;

			}
		}else{
			$data = [];
		}
		echo json_encode($data);
	}
	public function GetPantalla($id)
	{
		$this->comprobacionRoles();
		$data = array (
			'pantalla'=> $this->Rol_model->getPantallaModulo($id)
		);
		
		$html = "";
		foreach ($data["pantalla"] as $pantalla) 
		{
			$html .= "<option value = ".$pantalla->pant_id."> ".$pantalla->pant_descripcion." </option>";
		}
		echo $html;
	}

	//funcion para almacenar en la bd
	public function store()
	{
		$mensajes= $this->data;

		// $this->comprobacionRoles();
		// recibimos las variables
		$this->form_validation->set_rules("desRol", "Descripcion", "required");
		if ($this->form_validation->run() == FALSE){
			$mensajes['alerta'] = validation_errors('<b style="color:red"><ul><li>', '</ul></li></b>');
		}else{
			$modulos = $this->input->post('modulo');
			$NumRol   = $this->input->post("NumRol");
			$descripcion   = $this->input->post("desRol");
			$idRol = $this->Rol_model->ultimoNumero();
			$time = time();
			$fechaActual = date("Y-m-d H:i:s",$time);
			$data = array(
				'rol_id'  => $idRol->MAXIMO,
				'rol_descripcion'  => $descripcion,
				'rol_fecha_creacion'  => $fechaActual,
				'rol_fecha_modificacion' => $fechaActual
			);
			if($this->Rol_model->save($data))
			{
				//si todo esta bien, emitimos mensaje
				$this->session->set_flashdata('success', 'Rol registrado correctamente!');
				$rol_id = $this->Rol_model->ultimoInsert();
				foreach ($modulos as $modulo) {
					$data = array(
						'rol_det_rol_id'=>$rol_id->rol_id,
						'rol_det_pant_id' => $modulo['pantalla'], 
						'rol_det_insertar' => isset($modulo['insert']),
						'rol_det_actualizar'=>isset($modulo['update']),
						'rol_det_borrar'=>isset($modulo['delete']),
						'rol_det_visualizar'=>isset($modulo['select']),
						'rol_det_fecha_creacion'=> $fechaActual,
						'rol_det_fecha_modificacion' => $fechaActual
					);
					$this->Rol_model->save_detalle($data);
				}
				redirect(base_url()."roles/roles", "refresh");
			}else{
				$this->session->set_flashdata('error', 'Rol no registrado!');
				redirect(base_url()."roles/roles/add", "refresh");
			}
		}
	}

	//metodo para editar
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

	//actualizamos 

	public function update()
	{
		$this->comprobacionRoles();
		$this->form_validation->set_rules("desRol", "Descripcion", "required");
		if ($this->form_validation->run() == FALSE){
			$mensajes['alerta'] = validation_errors('<b style="color:red"><ul><li>', '</ul></li></b>');
		}else{
			$modulos = $this->input->post('modulo');
			$id = $this->input->post("NumRol");
			$descripcion = $this->input->post("desRol");
			$time = time();
			$fechaActual = date("Y-m-d H:i:s",$time);
			$data = array(
				'rol_descripcion'  => $descripcion,
				'rol_fecha_modificacion' => $fechaActual
			);
			if($this->Rol_model->update($id,$data))
			{
				//si todo esta bien, emitimos mensaje
				$this->session->set_flashdata('success', 'Rol registrado correctamente!');
				$rol_id = $this->Rol_model->ultimoInsert();
				foreach ($modulos as $modulo) {
					$data = array(
						'rol_det_rol_id'=>$rol_id->rol_id,
						'rol_det_pant_id' => $modulo['pantalla'], 
						'rol_det_insertar' => isset($modulo['insert']),
						'rol_det_actualizar'=>isset($modulo['update']),
						'rol_det_borrar'=>isset($modulo['delete']),
						'rol_det_visualizar'=>isset($modulo['select']),
						'rol_det_fecha_modificacion' => $fechaActual
					);
					$this->Rol_model->save_detalle($data);
				}
				redirect(base_url()."roles/roles", "refresh");
			}else{
				$this->session->set_flashdata('error', 'Rol no registrado!');
				redirect(base_url()."roles/roles/add", "refresh");
			}
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