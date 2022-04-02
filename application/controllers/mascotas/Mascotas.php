<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Mascotas extends CI_Controller
{
	//solo el constructor, para llamar a las clases
	public function __construct()
	{
		parent::__construct();
		// if (!$this->session->userdata("login")){
		// 	redirect(base_url());
		// }
		$this->templates = new League\Plates\Engine(APPPATH.'views');
		$this->templates->addFolder('mascotas', APPPATH.'views/mascotas');
		$this->data = array('correcto'=>'','alerta'=>'','error'=>'', 'datos'=>'');
		$this->load->model(array('Mascotas_model', 'Clientes_model', 'Razas_model'));

	}
	
	//esta funcion es la primera que se cargar
	public function index()
	{		
		$data = array(
			'mascotas'=> $this->Mascotas_model->getMascotas()
		);
		echo $this->templates->render('mascotas::list', $data);
	}
	//funcion add para mostrar vistas
	public function add()
	{
		$data = array(			
			'maximo' => $this->Mascotas_model->ObtenerCodigo(),
			'clientes' => $this->Clientes_model->getClientes(),
			'razas' => $this->Razas_model->getRazas()
		);
		echo $this->templates->render('mascotas::add', $data);

	}
	//funcion vista
	public function store()
	{

		$mensajes= $this->data;
		$this->form_validation->set_rules("nombreMascota", "Nombre", "required");
		$this->form_validation->set_rules("estado", "Estado", "required");
		$this->form_validation->set_rules("clie_id", "Cliente", "required");
		$this->form_validation->set_rules("raz_id", "Raza", "required");
		$this->form_validation->set_rules("fecha_nacimiento", "Fecha de Nacimiento", "required");
		if ($this->form_validation->run() == FALSE){
			$mensajes['alerta'] = validation_errors('<b style="color:red"><ul><li>', '</ul></li></b>'); 

		}else{
			$idMascota = $this->Mascotas_model->ObtenerCodigo();
			$nombreMascota   = $this->input->post("nombreMascota");
			$estado = $this->input->post('estado');
			$clie_id = $this->input->post('clie_id');
			$raz_id = $this->input->post('raz_id');
			$sexo = $this->input->post('sexo');
			$fecha_nacimiento = $this->input->post('fecha_nacimiento');
			$time = time();
			$fechaActual = date("Y-m-d H:i:s",$time);
			$data = array(
				'mas_id'  => $idMascota->MAXIMO,
				'mas_nombre'  => trim($nombreMascota),
				'mas_fecha_nacimiento'=>$fecha_nacimiento,
				'mas_clie_id' => $clie_id,
				'mas_raz_id' => $raz_id,
				'mas_sexo' => $sexo,
				'mas_estado' => $estado,
				'mas_fecha_creacion' => $fechaActual,
				'mas_fecha_modificacion'  => $fechaActual
			);
			$nombreMascota = trim($nombreMascota);
			if($this->Mascotas_model->save($data)){
				$mensajes['correcto'] = 'correcto';
				$this->session->set_flashdata('success', 'Mascota registrado correctamente!');
					// redirect(base_url()."productos", "refresh");
			}else{
				$mensajes['error'] = 'Mascota no registrado!';
				$this->session->set_flashdata('error', 'Mascota no registrado!');
					// redirect(base_url()."add_producto", "refresh");
			}
			
		}
		echo json_encode($mensajes);
		

	}
	public function edit($id)
	{
		$data = array(
			'mascota'=> $this->Mascotas_model->getMascotas($id),
			'clientes' => $this->Clientes_model->getClientes(),
			'razas' => $this->Razas_model->getRazas()
		);
		echo $this->templates->render('mascotas::edit', $data);

		
	}
	public function update()
	{
		$mensajes = $this->data;
		$this->form_validation->set_rules("nombreMascota", "Nombre", "required");
		$this->form_validation->set_rules("estado", "Estado", "required");
		$this->form_validation->set_rules("clie_id", "Cliente", "required");
		$this->form_validation->set_rules("raz_id", "Raza", "required");
		$this->form_validation->set_rules("fecha_nacimiento", "Fecha de Nacimiento", "required");

		if ($this->form_validation->run() == FALSE){
			$mensajes['alerta'] = validation_errors('<b style="color:red"><ul><li>', '</ul></li></b>'); 

		}else{
			$idMascota = $this->input->post('mas_id');
			$nombreMascota   = $this->input->post("nombreMascota");
			$estado = $this->input->post('estado');
			$clie_id = $this->input->post('clie_id');
			$raz_id = $this->input->post('raz_id');
			$sexo = $this->input->post('sexo');
			$fecha_nacimiento = $this->input->post('fecha_nacimiento');
			$time = time();
			$fechaActual = date("Y-m-d H:i:s",$time);
			$data = array(
				'mas_nombre'  => trim($nombreMascota),
				'mas_nombre'  => trim($nombreMascota),
				'mas_fecha_nacimiento'=>$fecha_nacimiento,
				'mas_clie_id' => $clie_id,
				'mas_raz_id' => $raz_id,
				'mas_sexo' => $sexo,
				'mas_estado' => $estado,
				'mas_fecha_modificacion'  => $fechaActual
			);
			$nombreMascota = trim($nombreMascota);
			if($this->Mascotas_model->update($idMascota,$data)){
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
		if($this->Mascotas_model->delete($id)){
			$this->session->set_flashdata('success', 'Eliminado correctamente!');
			redirect(base_url()."productos", "refresh");
		}else{
			$this->session->set_flashdata('error', 'Errores al Intentar Actualizar!');
			redirect(base_url()."productos","refresh");
		}

	}
}