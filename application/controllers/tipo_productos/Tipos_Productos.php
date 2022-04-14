<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Tipos_Productos extends CI_Controller
{
	//solo el constructor, para llamar a las clases
	public function __construct()
	{
		parent::__construct();
		// if (!$this->session->userdata("login")){
		// 	redirect(base_url());
		// }
		$this->templates = new League\Plates\Engine(APPPATH.'views');
		$this->templates->addFolder('tipo_productos', APPPATH.'views/tipo_productos');
		$this->data = array('correcto'=>'','alerta'=>'','error'=>'', 'datos'=>'');
		$this->load->model(array('Usuarios_model','Tipo_Productos_model'));

		$this->comprobacionRoles();
	}
	public function comprobacionRoles()
	{
		$usuario = $this->session->userdata("sist_usuname");
		$idmodulo = 2;
		$pantalla = 4;
		if ($this->session->userdata('sist_conex')=='A') {
			if (!$this->Usuarios_model->getPermisosRol($usuario, $pantalla,$idmodulo)) {
				redirect(base_url());
			}
		}else{
			redirect(base_url());

		}
	}
	
	//esta funcion es la primera que se cargar
	public function index()
	{
		$username = $this->session->userdata('sist_usuname');		
		$data = array(
			'tipo_productos'=> $this->Tipo_Productos_model->getTipoProductos()
		);
		echo $this->templates->render('tipo_productos::list', $data);
	}
	//funcion add para mostrar vistas
	public function add()
	{
		$data = array(			
			'maximo' => $this->Tipo_Productos_model->ObtenerCodigo()
		);
		echo $this->templates->render('tipo_productos::add', $data);

	}
	//funcion vista
	public function store()
	{

		$mensajes= $this->data;
		$this->form_validation->set_rules("desTipo", "Descripcion", "required");
		$this->form_validation->set_rules("estado", "Estado", "required");
		$this->form_validation->set_rules("inventariable", "Inventariable", "required");
		if ($this->form_validation->run() == FALSE){
			$mensajes['alerta'] = validation_errors('<b style="color:red"><ul><li>', '</ul></li></b>'); 

		}else{
			$desTipo   = $this->input->post("desTipo");
			$estado = $this->input->post('estado');
			$inventriable = $this->input->post('inventariable');
			$idciudad = $this->Tipo_Productos_model->ObtenerCodigo();
			$time = time();
			$fechaActual = date("Y-m-d H:i:s",$time);
			$data = array(
				'tipr_id'  => $idciudad->MAXIMO,
				'tipr_descripcion'  => trim($desTipo),
				'tipr_inventariable' => trim($inventriable),
				'tipr_fecha_creacion' => $fechaActual,
				'tipr_fecha_modificacion'  => $fechaActual,
				'tipr_estado' => $estado
			);
			$desTipo = trim($desTipo);
			if($this->Tipo_Productos_model->validarExiste($desTipo)){
				$mensajes['error']= 'Ya existe una tipo de producto con la misma descripcion';
			}else{
				if($this->Tipo_Productos_model->save($data)){
					$mensajes['correcto'] = 'correcto';
					$this->session->set_flashdata('success', 'Tipo de producto registrado correctamente!');
					// redirect(base_url()."ciudades", "refresh");
				}else{
					$mensajes['error'] = 'Tipo de producto no registrado!';
					$this->session->set_flashdata('error', 'Tipo de producto no registrado!');
						// redirect(base_url()."add_ciudad", "refresh");
				}
			}
		}
		echo json_encode($mensajes);
		

	}
	public function edit($id)
	{
		$data = array(
			'tipo_producto'=> $this->Tipo_Productos_model->getTipoProductos($id),
		);
		echo $this->templates->render('tipo_productos::edit', $data);

		
	}
	public function update()
	{
		$mensajes = $this->data;
		$this->form_validation->set_rules("inventariable", "Inventariable", "required");
		$this->form_validation->set_rules("desTipo", "Descripcion", "required");
		if ($this->form_validation->run() == FALSE){
			$mensajes['alerta'] = validation_errors('<b style="color:red"><ul><li>', '</ul></li></b>'); 

		}else{
			$desTipo= $this->input->post("desTipo");
			$estado = $this->input->post('estado');
			$tipr_id = $this->input->post('tipr_id');
			$desTipo = trim($desTipo);
			$inventriable = $this->input->post('inventariable');
			$time = time();
			$fechaActual = date("Y-m-d H:i:s",$time);
			$data = array(
				'tipr_descripcion' => $desTipo,
				'tipr_inventariable' => trim($inventriable),
				'tipr_estado' => $estado,
				'tipr_fecha_modificacion'=> $fechaActual
			);
			if($this->Tipo_Productos_model->update($tipr_id,$data)){
				$mensajes['correcto'] = 'correcto';
				$this->session->set_flashdata('success', 'Actualizado correctamente!');
			}else{
				$mensajes['error'] = 'Errores al intentar Actualizar!';
				$this->session->set_flashdata('error', 'Errores al Intentar Actualizar!');
			}
		}
		echo json_encode($mensajes);

	}
	public function delete($id)
	{
		if($this->Tipo_Productos_model->delete($id)){
			$this->session->set_flashdata('success', 'Eliminado correctamente!');
			redirect(base_url()."tipo_productos", "refresh");
		}else{
			$this->session->set_flashdata('error', 'Errores al Intentar Actualizar!');
			redirect(base_url()."tipo_productos","refresh");
		}

	}
}