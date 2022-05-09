<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Turnos extends CI_Controller
{
	//solo el constructor, para llamar a las clases
	public function __construct()
	{
		parent::__construct();
		// if (!$this->session->userdata("login")){
		// 	redirect(base_url());
		// }
		$this->templates = new League\Plates\Engine(APPPATH.'views');
		$this->templates->addFolder('turnos', APPPATH.'views/turnos');
		$this->data = array('correcto'=>'','alerta'=>'','error'=>'', 'datos'=>'');
		$this->load->model(array('Usuarios_model','Turnos_model', 'Productos_model'));

		$this->comprobacionRoles();
	}
	public function comprobacionRoles()
	{
		$usuario = $this->session->userdata("sist_usuname");
		$idmodulo = 2;
		$pantalla = 16;
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
			'turnos'=> $this->Turnos_model->getTurnos(),
			'permiso'=> $this->Usuarios_model->getPermisosRol($username, 16)
		);
		echo $this->templates->render('turnos::list', $data);
	}
	//funcion add para mostrar vistas
	public function add()
	{
		$data = array(			
			'maximo' => $this->Turnos_model->ObtenerCodigo(),
			'servicios' =>$this->Productos_model->getProductos(false, 'N'),
		);
		echo $this->templates->render('turnos::add', $data);

	}
	//funcion vista
	public function store()
	{
		$mensajes= $this->data;
		$this->form_validation->set_rules("desTurno", "Descripcion", "required");
		$this->form_validation->set_rules("estado", "Estado", "required");
		$this->form_validation->set_rules("hora_desde", "Hora Desde", "required");
		$this->form_validation->set_rules("hora_hasta", "Hora Hasta", "required");
		$this->form_validation->set_rules("prod_id", "Servicios", "required");
		$this->form_validation->set_rules("tiempo_aprox", "Tiempo Aproximado", "required");

		if ($this->form_validation->run() == FALSE){
			$mensajes['alerta'] = validation_errors('<b style="color:red"><ul><li>', '</ul></li></b>'); 

		}else{
			$desTurno   = $this->input->post("desTurno");
			$estado = $this->input->post('estado');
			$hora_desde = $this->input->post('hora_desde');
			$hora_hasta = $this->input->post('hora_hasta');
			$tiempo_aproximado = $this->input->post('tiempo_aprox');
			$prod_id = $this->input->post('prod_id');
			$idTurno = $this->Turnos_model->ObtenerCodigo();
			$time = time();
			$fechaActual = date("Y-m-d H:i:s",$time);
			$data = array(
				'tur_id'  => $idTurno->MAXIMO,
				'tur_prod_id' =>$prod_id,
				'tur_descripcion'  => trim($desTurno),
				'tur_desde_hora'  => trim($hora_desde),
				'tur_hasta_hora'  => trim($hora_hasta),
				'tur_tiempo_aproximado'  => trim($tiempo_aproximado),
				'tur_fecha_creacion' => $fechaActual,
				'tur_fecha_modificacion'  => $fechaActual,
				'tur_estado' => $estado
			);
			if($this->Turnos_model->validarExiste($desTurno)){
				$mensajes['error']= 'Ya exist un turno con la misma descripcion';
			}else{
				if($this->Turnos_model->save($data)){
					$mensajes['correcto'] = 'correcto';
					$this->session->set_flashdata('success', 'Turno registrado correctamente!');
						// redirect(base_url()."turnos", "refresh");
				}else{
					$mensajes['error'] = 'Turno no registrado!';
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
			'turno'=> $this->Turnos_model->getTurnos($id),
			'servicios' =>$this->Productos_model->getProductos(false, 'N'),
		);
		echo $this->templates->render('turnos::edit', $data);

		
	}
	public function update()
	{
		$mensajes = $this->data;
		$idTurno= $this->input->post("NumTurno");
		$this->form_validation->set_rules("desTurno", "Descripcion", "required");
		$this->form_validation->set_rules("estado", "Estado", "required");
		$this->form_validation->set_rules("hora_desde", "Hora Desde", "required");
		$this->form_validation->set_rules("hora_hasta", "Hora Hasta", "required");
		$this->form_validation->set_rules("tiempo_aprox", "Tiempo Aproximado", "required");
		$this->form_validation->set_rules("prod_id", "Servicios", "required");

		if ($this->form_validation->run() == FALSE){
			$mensajes['alerta'] = validation_errors('<b style="color:red"><ul><li>', '</ul></li></b>'); 

		}else{
			$desTurno   = $this->input->post("desTurno");
			$estado = $this->input->post('estado');
			$hora_desde = $this->input->post('hora_desde');
			$hora_hasta = $this->input->post('hora_hasta');
			$prod_id = $this->input->post('prod_id');

			$tiempo_aproximado = $this->input->post('tiempo_aprox');
			$time = time();
			$fechaActual = date("Y-m-d H:i:s",$time);
			$data = array(
				'tur_descripcion'  => trim($desTurno),
				'tur_prod_id' =>$prod_id,
				'tur_desde_hora'  => trim($hora_desde),
				'tur_hasta_hora'  => trim($hora_hasta),
				'tur_tiempo_aproximado'  => trim($tiempo_aproximado),
				'tur_fecha_modificacion'  => $fechaActual,
				'tur_estado' => $estado
			);
			if($this->Turnos_model->update($idTurno,$data)){
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
		if($this->Turnos_model->delete($id)){
			$this->session->set_flashdata('success', 'Eliminado correctamente!');
			redirect(base_url()."turnos", "refresh");
		}else{
			$this->session->set_flashdata('error', 'Errores al Intentar Actualizar!');
			redirect(base_url()."turnos","refresh");
		}

	}
}