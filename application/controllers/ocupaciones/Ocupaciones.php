<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Ocupaciones extends CI_Controller
{
	//solo el constructor, para llamar a las clases
	public function __construct()
	{
		parent::__construct();
		// if (!$this->session->userdata("login")){
		// 	redirect(base_url());
		// }
		$this->templates = new League\Plates\Engine(APPPATH.'views');
		$this->templates->addFolder('ocupaciones', APPPATH.'views/ocupaciones');
		$this->data = array('correcto'=>'','alerta'=>'','error'=>'', 'datos'=>'');
		$this->load->model(array('Ocupacion_model'));

	}
	
	//esta funcion es la primera que se cargar
	public function index()
	{		
		$data = array(
			'ocupaciones'=> $this->Ocupacion_model->getOcupaciones()
		);
		echo $this->templates->render('ocupaciones::list', $data);
	}
	//funcion add para mostrar vistas
	public function add()
	{
		$data = array(			
			'maximo' => $this->Ocupacion_model->ObtenerCodigo()
		);
		echo $this->templates->render('ocupaciones::add', $data);

	}
	//funcion vista
	public function store()
	{

		$mensajes= $this->data;
		$this->form_validation->set_rules("desOcupacion", "Descripcion", "required");
		$this->form_validation->set_rules("estado", "Estado", "required");
		if ($this->form_validation->run() == FALSE){
			$mensajes['alerta'] = validation_errors('<b style="color:red"><ul><li>', '</ul></li></b>'); 

		}else{
			$desOcupacion   = $this->input->post("desOcupacion");
			$estado = $this->input->post('estado');
			$idciudad = $this->Ocupacion_model->ObtenerCodigo();
			$time = time();
			$fechaActual = date("Y-m-d H:i:s",$time);
			$data = array(
				'ocu_id'  => $idciudad->MAXIMO,
				'ocu_descripcion'  => trim($desOcupacion),
				'ocu_fecha_creacion' => $fechaActual,
				'ocu_fecha_modificacion'  => $fechaActual,
				'ocu_estado' => $estado
			);
			$desOcupacion = trim($desOcupacion);
			if($this->Ocupacion_model->validarExiste($desOcupacion)){
				$mensajes['error']= 'Ya existe una ciudad con la misma descripcion';
			}else{
				if($this->Ocupacion_model->save($data)){
					$mensajes['correcto'] = 'correcto';
					$this->session->set_flashdata('success', 'Ocupacion registrado correctamente!');
						// redirect(base_url()."ocupaciones", "refresh");
				}else{
					$mensajes['error'] = 'Ocupacion no registrado!';
					$this->session->set_flashdata('error', 'Ocupacion no registrado!');
						// redirect(base_url()."add_ciudad", "refresh");
				}
			}
		}
		echo json_encode($mensajes);
		

	}
	public function edit($id)
	{
		$data = array(
			'ocupacion'=> $this->Ocupacion_model->getOcupaciones($id),
		);
		echo $this->templates->render('ocupaciones::edit', $data);

		
	}
	public function update()
	{
		$mensajes = $this->data;
		$idCiudad= $this->input->post("NumOcupacion");
		$desOcupacion= $this->input->post("desOcupacion");
		$estado = $this->input->post('estado');
		$this->form_validation->set_rules("desOcupacion", "Descripcion", "required");
		$desOcupacion = trim($desOcupacion);
		if ($this->form_validation->run() == FALSE){
			$mensajes['alerta'] = validation_errors('<b style="color:red"><ul><li>', '</ul></li></b>'); 

		}else{
			$time = time();
			$fechaActual = date("Y-m-d H:i:s",$time);
			$data = array(
				'ocu_descripcion' => $desOcupacion,
				'ocu_estado' => $estado,
				'ocu_fecha_modificacion'=> $fechaActual
			);
			if($this->Ocupacion_model->update($idCiudad,$data)){
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
		if($this->Ocupacion_model->delete($id)){
			$this->session->set_flashdata('success', 'Eliminado correctamente!');
			redirect(base_url()."ocupaciones", "refresh");
		}else{
			$this->session->set_flashdata('error', 'Errores al Intentar Actualizar!');
			redirect(base_url()."ocupaciones","refresh");
		}

	}
}