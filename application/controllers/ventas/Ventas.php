	<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	class Ventas extends CI_Controller
	{
	//solo el constructor, para llamar a las clases
		public function __construct()
		{
			parent::__construct();
		// if (!$this->session->userdata("login")){
		// 	redirect(base_url());
		// }
			$this->templates = new League\Plates\Engine(APPPATH.'views');
			$this->templates->addFolder('ventas', APPPATH.'views/ventas');
			$this->data = array('correcto'=>'','alerta'=>'','error'=>'', 'datos'=>'');
			$this->load->model(array('Usuarios_model','Clientes_model', 'Personas_model', 'Ventas_model', 'Agendamientos_model'));

			$this->comprobacionRoles();
		}
		public function comprobacionRoles()
		{
			$usuario = $this->session->userdata("sist_usuname");
			$idmodulo = 7;
			$pantalla = 19;
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
			$data = array(
				'clientes'=> $this->Ventas_model->getVentas()
			);
			echo $this->templates->render('ventas::list', $data);
		}
		public function add(){
			$data = array(			
				'clientes' => $this->Clientes_model->getClientes(false, 1), 
				'agendamientos'=> $this->Agendamientos_model->getAgendamiento(false, false, false, 2) 
			);
			echo $this->templates->render('ventas::add', $data);

		}
		public function store(){
			$mensajes= $this->data;
			$this->form_validation->set_rules("per_id", "Persona", "required");
			$this->form_validation->set_rules("fecha_incorporacion", "Fecha de Incorporacion", "required");
			if ($this->form_validation->run() == FALSE){
				$mensajes['alerta'] = validation_errors('<b style="color:red"><ul><li>', '</ul></li></b>'); 

			}else{
				$per_id = $this->input->post('per_id');
				$fecha_incorporacion = $this->input->post("fecha_incorporacion");
				$id_inventario = $this->Clientes_model->ObtenerCodigo();
				$time = time();
				$fechaActual = date("Y-m-d H:i:s",$time);
				$estado = $this->input->post('estado');
				$data = array(
					'clie_id'  => $id_inventario->MAXIMO,
					'clie_per_id'  => trim($per_id),
					'clie_fecha_incorporacion'  => trim($fecha_incorporacion),
					'clie_estado'  => trim($estado),
					'clie_fecha_creacion' => $fechaActual,
					'clie_fecha_modificacion'  => $fechaActual
				);
				if($this->Clientes_model->save($data)){
					$mensajes['correcto'] = 'correcto';
					$this->session->set_flashdata('success', 'Cliente registrado correctamente!');
					// redirect(base_url()."ciudades/ciudades", "refresh");
				}else{
					$mensajes['error'] = 'Cliente no registrado!';
					$this->session->set_flashdata('error', 'Proveedor no registrado!');
					// redirect(base_url()."ciudades/ciudades/add", "refresh");
				}
			}
			echo json_encode($mensajes);


		}
		public function edit($id)
		{
			$data = array(
				'cliente'=> $this->Clientes_model->getClientes($id),
			);
			echo $this->templates->render('ventas::edit', $data);


		}
		public function update()
		{
			$mensajes= $this->data;
			$this->form_validation->set_rules("per_id", "Persona", "required");
			$this->form_validation->set_rules("fecha_incorporacion", "Fecha de Incorporacion", "required");
			if ($this->form_validation->run() == FALSE){
				$mensajes['alerta'] = validation_errors('<b style="color:red"><ul><li>', '</ul></li></b>'); 

			}else{
				$per_id = $this->input->post('per_id');
				$fecha_incorporacion = $this->input->post("fecha_incorporacion");
				$clie_id = $this->input->post('clie_id');
				$id_inventario = $this->Clientes_model->ObtenerCodigo();
				$estado = $this->input->post('estado');
				$time = time();
				$fechaActual = date("Y-m-d H:i:s",$time);
				$data = array(
					'clie_per_id'  => trim($per_id),
					'clie_estado'  => trim($estado),
					'clie_fecha_incorporacion'  => trim($fecha_incorporacion),
					'clie_fecha_modificacion'  => $fechaActual
				);
				if($this->Clientes_model->update($clie_id,$data)){
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
			if($this->Clientes_model->delete($id)){
				$this->session->set_flashdata('success', 'Eliminado correctamente!');
				redirect(base_url()."clientes", "refresh");
			}else{
				$this->session->set_flashdata('error', 'Errores al Intentar Actualizar!');
				redirect(base_url()."clientes","refresh");
			}

		}
	}