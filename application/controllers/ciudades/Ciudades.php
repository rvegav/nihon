<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Ciudades extends CI_Controller
{
	//solo el constructor, para llamar a las clases
	public function __construct()
	{
		parent::__construct();
		// if (!$this->session->userdata("login")){
		// 	redirect(base_url());
		// }
		$this->templates = new League\Plates\Engine(APPPATH.'views');
		$this->templates->addFolder('ciudades', APPPATH.'views/ciudades');
		$this->data = array('correcto'=>'','alerta'=>'','error'=>'', 'datos'=>'');
		$this->load->model(array('Ciudad_model'));

	}
	
	//esta funcion es la primera que se cargar
	public function index()
	{		
		$data = array(
			'ciudades'=> $this->Ciudad_model->getCiudades()
		);
		echo $this->templates->render('ciudades::list', $data);
	}
	//funcion add para mostrar vistas
	public function add()
	{
		$data = array(			
			'maximo' => $this->Ciudad_model->ObtenerCodigo()
		);
		echo $this->templates->render('ciudades::add', $data);

	}
	//funcion vista
	public function store()
	{

		$mensajes= $this->data;
		$this->form_validation->set_rules("desCiudad", "Descripcion", "required");
		$this->form_validation->set_rules("estado", "Estado", "required");
		if ($this->form_validation->run() == FALSE){
			$mensajes['alerta'] = validation_errors('<b style="color:red"><ul><li>', '</ul></li></b>'); 

		}else{
			$desCiudad   = $this->input->post("desCiudad");
			$estado = $this->input->post('estado');
			$idciudad = $this->Ciudad_model->ObtenerCodigo();
			$time = time();
			$fechaActual = date("Y-m-d H:i:s",$time);
			$data = array(
				'ciu_id'  => $idciudad->MAXIMO,
				'ciu_descripcion'  => trim($desCiudad),
				'ciu_fecha_creacion' => $fechaActual,
				'ciu_fecha_modificacion'  => $fechaActual,
				'ciu_estado' => $estado
			);
			$desCiudad = trim($desCiudad);
			if($this->Ciudad_model->validarExiste($desCiudad)){
				$mensajes['error']= 'Ya existe una ciudad con la misma descripcion';
			}else{
				if($this->Ciudad_model->save($data)){
					$mensajes['correcto'] = 'correcto';
					$this->session->set_flashdata('success', 'Ciudad registrado correctamente!');
						// redirect(base_url()."ciudades", "refresh");
				}else{
					$mensajes['error'] = 'Ciudad no registrado!';
					$this->session->set_flashdata('error', 'Ciudad no registrado!');
						// redirect(base_url()."add_ciudad", "refresh");
				}
			}
		}
		echo json_encode($mensajes);
		

	}
	public function edit($id)
	{
		$data = array(
			'ciudad'=> $this->Ciudad_model->getCiudades($id),
		);
		echo $this->templates->render('ciudades::edit', $data);

		
	}
	public function update()
	{
		$mensajes = $this->data;
		$idCiudad= $this->input->post("NumCiudad");
		$desCiudad= $this->input->post("desCiudad");
		$estado = $this->input->post('estado');
			$this->form_validation->set_rules("desCiudad", "Descripcion", "required");
			$desCiudad = trim($desCiudad);
			if ($this->form_validation->run() == FALSE){
				$mensajes['alerta'] = validation_errors('<b style="color:red"><ul><li>', '</ul></li></b>'); 

			}else{
				$time = time();
				$fechaActual = date("Y-m-d H:i:s",$time);
				$data = array(
					'ciu_descripcion' => $desCiudad,
					'ciu_estado' => $estado,
					'ciu_fecha_modificacion'=> $fechaActual
				);
				if($this->Ciudad_model->update($idCiudad,$data)){
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
			if($this->Ciudad_model->delete($id)){
				$this->session->set_flashdata('success', 'Eliminado correctamente!');
				redirect(base_url()."ciudades", "refresh");
			}else{
				$this->session->set_flashdata('error', 'Errores al Intentar Actualizar!');
				redirect(base_url()."ciudades","refresh");
			}

		}
	}