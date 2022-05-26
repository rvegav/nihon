	<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	class Personas extends CI_Controller
	{
	//solo el constructor, para llamar a las clases
		public function __construct()
		{
			parent::__construct();
		// if (!$this->session->userdata("login")){
		// 	redirect(base_url());
		// }
			$this->templates = new League\Plates\Engine(APPPATH.'views');
			$this->templates->addFolder('personas', APPPATH.'views/personas');
			$this->data = array('correcto'=>'','alerta'=>'','error'=>'', 'datos'=>'');
			$this->load->model(array('Usuarios_model','Personas_model', 'Ciudad_model'));

			$this->comprobacionRoles();
		}
		public function comprobacionRoles()
		{
			$usuario = $this->session->userdata("sist_usuname");
			$idmodulo = 2;
			$pantalla = 6;
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
				'personas'=> $this->Personas_model->getPersonas()
			);
			echo $this->templates->render('personas::list', $data);
		}
		public function add(){
			$data = array(			
				'maximo' => $this->Personas_model->ObtenerCodigo(), 
				'ciudades'=> $this->Ciudad_model->getCiudades(false, 1) 
			);
			echo $this->templates->render('personas::add', $data);

		}
		public function store(){
			$mensajes= $this->data;
			$this->form_validation->set_rules("nombre", "Nombre", "required");
			$this->form_validation->set_rules("apellido", "Apellido", "required");
			$this->form_validation->set_rules("nro_doc", "Nro Documento", "required");
			$this->form_validation->set_rules("tipo_doc", "Tipo de Documento", "required");
			$this->form_validation->set_rules("estado", "Estado", "required");
			if ($this->form_validation->run() == FALSE){
				$mensajes['alerta'] = validation_errors('<b style="color:red"><ul><li>', '</ul></li></b>'); 

			}else{
				$nombre = $this->input->post("nombre");
				$apellido  = $this->input->post('apellido');
				$nro_doc = $this->input->post('nro_doc');
				$correo  = $this->input->post('correo');
				$direccion = $this->input->post('direccion');
				$fecha_nacimiento = $this->input->post('fecha_nacimiento');
				$tipo_doc = $this->input->post('tipo_doc');
				$telefono = $this->input->post('telefono');
				$estado = $this->input->post('estado');
				$idciudad = $this->input->post('ciudad_id');
				$idPersona = $this->Personas_model->ObtenerCodigo();
				$time = time();
				$fechaActual = date("Y-m-d H:i:s",$time);
				$data = array(
					'per_id'  => $idPersona->MAXIMO,
					'per_nombre'  => trim($nombre),
					'per_apellido'  => trim($apellido),
					'per_nro_doc'  => trim($nro_doc),
					'per_tipo_doc'  => trim($tipo_doc),
					'per_fecha_nacimiento'  => trim($fecha_nacimiento),
					'per_direccion'  => trim($direccion),
					'per_telefono' => $telefono,
					'per_correo'  => trim($correo),
					'per_ciu_id'  => trim($idciudad),
					'per_fecha_creacion' => $fechaActual,
					'per_fecha_modificacion'  => $fechaActual,
					'per_estado' => $estado
				);
				if($this->Personas_model->save($data)){
					$mensajes['correcto'] = 'correcto';
					$this->session->set_flashdata('success', 'Persona registrado correctamente!');
					// redirect(base_url()."ciudades/ciudades", "refresh");
				}else{
					$mensajes['error'] = 'Persona no registrado!';
					$this->session->set_flashdata('error', 'Proveedor no registrado!');
					// redirect(base_url()."ciudades/ciudades/add", "refresh");
				}
			}
			echo json_encode($mensajes);


		}
		public function edit($id)
		{
			$data = array(
				'persona'=> $this->Personas_model->getPersonas($id),
				'ciudades'=> $this->Ciudad_model->getCiudades(false, 1) 
				
			);
			echo $this->templates->render('personas::edit', $data);


		}
		public function update()
		{
			$mensajes= $this->data;
			$this->form_validation->set_rules("nombre", "Nombre", "required");
			$this->form_validation->set_rules("apellido", "Apellido", "required");
			$this->form_validation->set_rules("nro_doc", "Nro Documento", "required");
			$this->form_validation->set_rules("tipo_doc", "Tipo de Documento", "required");
			$this->form_validation->set_rules("estado", "Estado", "required");
			if ($this->form_validation->run() == FALSE){
				$mensajes['alerta'] = validation_errors('<b style="color:red"><ul><li>', '</ul></li></b>'); 

			}else{

				$nombre = $this->input->post("nombre");
				$apellido  = $this->input->post('apellido');
				$nro_doc = $this->input->post('nro_doc');
				$tipo_doc = $this->input->post('tipo_doc');
				$correo  = $this->input->post('correo');
				$direccion = $this->input->post('direccion');
				$fecha_nacimiento = $this->input->post('fecha_nacimiento');
				$estado = $this->input->post('estado');
				$idciudad = $this->input->post('ciudad_id');
				$telefono = $this->input->post('telefono');
				$idPersona = $this->input->post('persona_id');
				$time = time();
				$fechaActual = date("Y-m-d H:i:s",$time);
				$data = array(
					'per_nombre'  => trim($nombre),
					'per_apellido'  => trim($apellido),
					'per_nro_doc'  => trim($nro_doc),
					'per_tipo_doc'  => trim($tipo_doc),
					'per_fecha_nacimiento'  => trim($fecha_nacimiento),
					'per_direccion'  => trim($direccion),
					'per_telefono' => $telefono,
					'per_correo'  => trim($correo),
					'per_ciu_id'  => trim($idciudad),
					'per_fecha_modificacion'  => $fechaActual,
					'per_estado' => $estado
				);
				if($this->Personas_model->update($idPersona,$data)){
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
			if($this->Personas_model->delete($id)){
				$this->session->set_flashdata('success', 'Eliminado correctamente!');
				redirect(base_url()."personas", "refresh");
			}else{
				$this->session->set_flashdata('error', 'Errores al Intentar Actualizar!');
				redirect(base_url()."personas","refresh");
			}

		}
	}