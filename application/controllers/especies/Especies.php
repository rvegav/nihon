<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Especies extends CI_Controller
{
	//solo el constructor, para llamar a las clases
	public function __construct()
	{
		parent::__construct();
		// if (!$this->session->userdata("login")){
		// 	redirect(base_url());
		// }
		$this->templates = new League\Plates\Engine(APPPATH.'views');
		$this->templates->addFolder('especies', APPPATH.'views/especies');
		$this->data = array('correcto'=>'','alerta'=>'','error'=>'', 'datos'=>'');
		$this->load->model(array('Usuarios_model','Especies_model'));

	}
	
	//esta funcion es la primera que se cargar
public function index()
{
$username = $this->session->userdata('sist_usuname');		
		$data = array(
			'especies'=> $this->Especies_model->getEspecies()
		);
		echo $this->templates->render('especies::list', $data);
	}
	//funcion add para mostrar vistas
	public function add()
	{
		$data = array(			
			'maximo' => $this->Especies_model->ObtenerCodigo()
		);
		echo $this->templates->render('especies::add', $data);

	}
	//funcion vista
	public function store()
	{

		$mensajes= $this->data;
		$this->form_validation->set_rules("desEspecie", "Descripcion", "required");
		$this->form_validation->set_rules("estado", "Estado", "required");
		if ($this->form_validation->run() == FALSE){
			$mensajes['alerta'] = validation_errors('<b style="color:red"><ul><li>', '</ul></li></b>'); 

		}else{
			$desEspecie   = $this->input->post("desEspecie");
			$estado = $this->input->post('estado');
			$idEspecie = $this->Especies_model->ObtenerCodigo();
			$time = time();
			$fechaActual = date("Y-m-d H:i:s",$time);
			$data = array(
				'esp_id'  => $idEspecie->MAXIMO,
				'esp_descripcion'  => trim($desEspecie),
				'esp_fecha_creacion' => $fechaActual,
				'esp_fecha_modificacion'  => $fechaActual,
				'esp_estado' => $estado
			);
			$desEspecie = trim($desEspecie);
			if($this->Especies_model->validarExiste($desEspecie)){
				$mensajes['error']= 'Ya existe una Especie con la misma descripcion';
			}else{
				if($this->Especies_model->save($data)){
					$mensajes['correcto'] = 'correcto';
					$this->session->set_flashdata('success', 'Especie registrado correctamente!');
						// redirect(base_url()."especies", "refresh");
				}else{
					$mensajes['error'] = 'Ciudad no registrado!';
					$this->session->set_flashdata('error', 'Especie no registrado!');
						// redirect(base_url()."add_ciudad", "refresh");
				}
			}
		}
		echo json_encode($mensajes);
		

	}
	public function edit($id)
	{
		$data = array(
			'especie'=> $this->Especies_model->getEspecies($id),
		);
		echo $this->templates->render('especies::edit', $data);

		
	}
	public function update()
	{
		$mensajes = $this->data;
		$idEspecie= $this->input->post("NumCiudad");
		$desEspecie= $this->input->post("desEspecie");
		$estado = $this->input->post('estado');
			$this->form_validation->set_rules("desEspecie", "Descripcion", "required");
			$desEspecie = trim($desEspecie);
			if ($this->form_validation->run() == FALSE){
				$mensajes['alerta'] = validation_errors('<b style="color:red"><ul><li>', '</ul></li></b>'); 

			}else{
				$time = time();
				$fechaActual = date("Y-m-d H:i:s",$time);
				$data = array(
					'esp_descripcion' => $desEspecie,
					'esp_estado' => $estado,
					'esp_fecha_modificacion'=> $fechaActual
				);
				if($this->Especies_model->update($idEspecie,$data)){
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
			if($this->Especies_model->delete($id)){
				$this->session->set_flashdata('success', 'Eliminado correctamente!');
				redirect(base_url()."especies", "refresh");
			}else{
				$this->session->set_flashdata('error', 'Errores al Intentar Actualizar!');
				redirect(base_url()."especies","refresh");
			}

		}
	}