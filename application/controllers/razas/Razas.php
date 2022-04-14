<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Razas extends CI_Controller
{
	//solo el constructor, para llamar a las clases
	public function __construct()
	{
		parent::__construct();
		// if (!$this->session->userdata("login")){
		// 	redirect(base_url());
		// }
		$this->templates = new League\Plates\Engine(APPPATH.'views');
		$this->templates->addFolder('razas', APPPATH.'views/razas');
		$this->data = array('correcto'=>'','alerta'=>'','error'=>'', 'datos'=>'');
		$this->load->model(array('Usuarios_model','Razas_model', 'Especies_model'));

		$this->comprobacionRoles();
	}
	public function comprobacionRoles()
	{
		$usuario = $this->session->userdata("sist_usuname");
		$idmodulo = 2;
		$pantalla = 8;
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
			'razas'=> $this->Razas_model->getRazas()
		);
		echo $this->templates->render('razas::list', $data);
	}
	//funcion add para mostrar vistas
	public function add()
	{
		$data = array(			
			'maximo' => $this->Razas_model->ObtenerCodigo(),
			'especies' => $this->Especies_model->getEspecies()
		);
		echo $this->templates->render('razas::add', $data);

	}
	//funcion vista
	public function store()
	{

		$mensajes= $this->data;
		$this->form_validation->set_rules("desRaza", "Descripcion", "required");
		$this->form_validation->set_rules("estado", "Estado", "required");
		if ($this->form_validation->run() == FALSE){
			$mensajes['alerta'] = validation_errors('<b style="color:red"><ul><li>', '</ul></li></b>'); 

		}else{
			$desRaza   = $this->input->post("desRaza");
			$estado = $this->input->post('estado');
			$idRaza = $this->Razas_model->ObtenerCodigo();
			$idEspecie = $this->input->post('esp_id');
			$time = time();
			$fechaActual = date("Y-m-d H:i:s",$time);
			$data = array(
				'raz_id'  => $idRaza->MAXIMO,
				'raz_descripcion'  => trim($desRaza),
				'raz_esp_id'  => trim($idEspecie),
				'raz_fecha_creacion' => $fechaActual,
				'raz_fecha_modificacion'  => $fechaActual,
				'raz_estado' => $estado
			);
			$desRaza = trim($desRaza);
			if($this->Razas_model->validarExiste($desRaza)){
				$mensajes['error']= 'Ya existe una ciudad con la misma descripcion';
			}else{
				if($this->Razas_model->save($data)){
					$mensajes['correcto'] = 'correcto';
					$this->session->set_flashdata('success', 'Raza registrado correctamente!');
						// redirect(base_url()."razas", "refresh");
				}else{
					$mensajes['error'] = 'Raza no registrado!';
					$this->session->set_flashdata('error', 'Raza no registrado!');
						// redirect(base_url()."add_ciudad", "refresh");
				}
			}
		}
		echo json_encode($mensajes);
		

	}
	public function edit($id)
	{
		$data = array(
			'raza'=> $this->Razas_model->getrazas($id),
			'especies' => $this->Especies_model->getEspecies()
		);
		echo $this->templates->render('razas::edit', $data);

		
	}
	public function update()
	{
		$mensajes = $this->data;
		$idRaza= $this->input->post("raz_id");
		$desRaza= $this->input->post("desRaza");
		$estado = $this->input->post('estado');
		$idEspecie = $this->input->post('esp_id');

		$this->form_validation->set_rules("desRaza", "Descripcion", "required");
		$desRaza = trim($desRaza);
		if ($this->form_validation->run() == FALSE){
			$mensajes['alerta'] = validation_errors('<b style="color:red"><ul><li>', '</ul></li></b>'); 

		}else{
			$time = time();
			$fechaActual = date("Y-m-d H:i:s",$time);
			$data = array(
				'raz_descripcion' => $desRaza,
				'raz_esp_id'  => trim($idEspecie),
				'raz_estado' => $estado,
				'raz_fecha_modificacion'=> $fechaActual
			);
			if($this->Razas_model->update($idRaza,$data)){
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
		if($this->Razas_model->delete($id)){
			$this->session->set_flashdata('success', 'Eliminado correctamente!');
			redirect(base_url()."razas", "refresh");
		}else{
			$this->session->set_flashdata('error', 'Errores al Intentar Actualizar!');
			redirect(base_url()."razas","refresh");
		}

	}
}