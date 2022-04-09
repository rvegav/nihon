	<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	class Empleados extends CI_Controller
	{
	//solo el constructor, para llamar a las clases
		public function __construct()
		{
			parent::__construct();
		// if (!$this->session->userdata("login")){
		// 	redirect(base_url());
		// }
			$this->templates = new League\Plates\Engine(APPPATH.'views');
			$this->templates->addFolder('empleados', APPPATH.'views/empleados');
			$this->data = array('correcto'=>'','alerta'=>'','error'=>'', 'datos'=>'');
			$this->load->model(array('Usuarios_model','Empleados_model', 'Personas_model', 'Ocupacion_model'));

		}
		public function index()
		{		
			$data = array(
				'empleados'=> $this->Empleados_model->getempleados()
			);
			echo $this->templates->render('empleados::list', $data);
		}
		public function add(){
			$data = array(			
				'maximo' => $this->Empleados_model->ObtenerCodigo(), 
				'personas'=> $this->Personas_model->getPersonas(),
				'ocupaciones' => $this->Ocupacion_model->getOcupaciones() 
			);
			echo $this->templates->render('empleados::add', $data);

		}
		public function store(){
			$mensajes= $this->data;
			$this->form_validation->set_rules("per_id", "Persona", "required");
			$this->form_validation->set_rules("ocu_id", "Ocupacion", "required");
			if ($this->form_validation->run() == FALSE){
				$mensajes['alerta'] = validation_errors('<b style="color:red"><ul><li>', '</ul></li></b>'); 

			}else{
				$per_id = $this->input->post('per_id');
				$ocu_id = $this->input->post("ocu_id");
				$id_inventario = $this->Empleados_model->ObtenerCodigo();
				$time = time();
				$fechaActual = date("Y-m-d H:i:s",$time);
				$estado = $this->input->post('estado');
				$data = array(
					'empl_id'  => $id_inventario->MAXIMO,
					'empl_per_id'  => trim($per_id),
					'empl_ocu_id'  => trim($ocu_id),
					'empl_estado'  => trim($estado),
					'empl_fecha_creacion' => $fechaActual,
					'empl_fecha_modificacion'  => $fechaActual
				);
				if($this->Empleados_model->save($data)){
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
				'empleado'=> $this->Empleados_model->getEmpleados($id),
				'personas'=> $this->Personas_model->getPersonas(),
				'ocupaciones' => $this->Ocupacion_model->getOcupaciones() 
			);
			echo $this->templates->render('empleados::edit', $data);


		}
		public function update()
		{
			$mensajes= $this->data;

			$this->form_validation->set_rules("per_id", "Persona", "required");
			$this->form_validation->set_rules("ocu_id", "Ocupacion", "required");
			if ($this->form_validation->run() == FALSE){
				$mensajes['alerta'] = validation_errors('<b style="color:red"><ul><li>', '</ul></li></b>'); 

			}else{
				$per_id = $this->input->post('per_id');
				$ocu_id = $this->input->post("ocu_id");
				$empl_id = $this->input->post('empl_id');
				$estado = $this->input->post('estado');
				$time = time();
				$fechaActual = date("Y-m-d H:i:s",$time);
				$data = array(
					'empl_per_id'  => trim($per_id),
					'empl_estado'  => trim($estado),
					'empl_ocu_id'  => trim($ocu_id),
					'empl_fecha_modificacion'  => $fechaActual
				);
				if($this->Empleados_model->update($empl_id,$data)){
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
			if($this->Empleados_model->delete($id)){
				$this->session->set_flashdata('success', 'Eliminado correctamente!');
				redirect(base_url()."empleados", "refresh");
			}else{
				$this->session->set_flashdata('error', 'Errores al Intentar Actualizar!');
				redirect(base_url()."empleados","refresh");
			}

		}
	}