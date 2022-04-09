	<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	class Proveedores extends CI_Controller
	{
	//solo el constructor, para llamar a las clases
		public function __construct()
		{
			parent::__construct();
		// if (!$this->session->userdata("login")){
		// 	redirect(base_url());
		// }
			$this->templates = new League\Plates\Engine(APPPATH.'views');
			$this->templates->addFolder('proveedores', APPPATH.'views/proveedores');
			$this->data = array('correcto'=>'','alerta'=>'','error'=>'', 'datos'=>'');
			$this->load->model(array('Usuarios_model','Proveedores_model', 'Ciudad_model'));

		}
		public function index()
		{		
			$data = array(
				'proveedores'=> $this->Proveedores_model->getProveedores()
			);
			echo $this->templates->render('proveedores::list', $data);
		}
		public function add(){
			$data = array(			
				'maximo' => $this->Proveedores_model->ObtenerCodigo(), 
				'ciudades'=> $this->Ciudad_model->getCiudades() 
			);
			echo $this->templates->render('proveedores::add', $data);

		}
		public function store(){
			$mensajes= $this->data;
			$this->form_validation->set_rules("description", "Nombre", "required");
			$this->form_validation->set_rules("estado", "Estado", "required");
			if ($this->form_validation->run() == FALSE){
				$mensajes['alerta'] = validation_errors('<b style="color:red"><ul><li>', '</ul></li></b>'); 

			}else{
				$descProveedor = $this->input->post("description");
				$docuProveedor  = $this->input->post('documento');
				$telProveedor = $this->input->post('telefono');
				$correoProveedor  = $this->input->post('correo');
				$direccion = $this->input->post('direccion');
				$estado = $this->input->post('estado');
				$idciudad = $this->input->post('ciudad_id');
				$idProveedor = $this->Proveedores_model->ObtenerCodigo();
				$time = time();
				$fechaActual = date("Y-m-d H:i:s",$time);
				$data = array(
					'prov_id'  => $idProveedor->MAXIMO,
					'prov_descripcion'  => trim($descProveedor),
					'prov_documento'  => trim($docuProveedor),
					'prov_telefono'  => trim($telProveedor),
					'prov_direccion'  => trim($direccion),
					'prov_correo'  => trim($correoProveedor),
					'prov_ciu_id'  => trim($idciudad),
					'prov_fecha_creacion' => $fechaActual,
					'prov_fecha_modificacion'  => $fechaActual,
					'prov_estado' => $estado
				);
				if($this->Proveedores_model->save($data)){
					$mensajes['correcto'] = 'correcto';
					$this->session->set_flashdata('success', 'Proveedor registrado correctamente!');
					// redirect(base_url()."ciudades/ciudades", "refresh");
				}else{
					$mensajes['error'] = 'Proveedor no registrado!';
					$this->session->set_flashdata('error', 'Proveedor no registrado!');
					// redirect(base_url()."ciudades/ciudades/add", "refresh");
				}
			}
			echo json_encode($mensajes);


		}
		public function edit($id)
		{
			$data = array(
				'proveedor'=> $this->Proveedores_model->getProveedores($id),
			);
			echo $this->templates->render('proveedores::edit', $data);


		}
		public function update()
		{
			$mensajes= $this->data;
			$this->form_validation->set_rules("description", "Nombre", "required");
			$this->form_validation->set_rules("estado", "Estado", "required");
			if ($this->form_validation->run() == FALSE){
				$mensajes['alerta'] = validation_errors('<b style="color:red"><ul><li>', '</ul></li></b>'); 

			}else{
				$descProveedor = $this->input->post("description");
				$docuProveedor  = $this->input->post('documento');
				$telProveedor = $this->input->post('telefono');
				$correoProveedor  = $this->input->post('correo');
				$estado = $this->input->post('estado');
				$idciudad = $this->input->post('ciudad_id');
				$direccion = $this->input->post('direccion');
				$idProveedor = $this->input->post('cod_proveedor');
				$time = time();
				$fechaActual = date("Y-m-d H:i:s",$time);
				$data = array(
					'prov_descripcion'  => trim($descProveedor),
					'prov_documento'  => trim($docuProveedor),
					'prov_telefono'  => trim($telProveedor),
					'prov_direccion'  => $direccion,
					'prov_correo'  => trim($correoProveedor),
					'prov_ciu_id'  => trim($idciudad),
					'prov_fecha_modificacion'  => $fechaActual,
					'prov_estado' => $estado
				);
				// echo "<pre>";
				// print_r($data);
				// echo "</pre>";
				// die();
				if($this->Proveedores_model->update($idProveedor,$data)){
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
			if($this->Proveedores_model->delete($id)){
				$this->session->set_flashdata('success', 'Eliminado correctamente!');
				redirect(base_url()."proveedores", "refresh");
			}else{
				$this->session->set_flashdata('error', 'Errores al Intentar Actualizar!');
				redirect(base_url()."proveedores","refresh");
			}

		}
	}