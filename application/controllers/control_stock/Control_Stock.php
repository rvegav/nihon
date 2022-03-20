	<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	class Control_Stock extends CI_Controller
	{
	//solo el constructor, para llamar a las clases
		public function __construct()
		{
			parent::__construct();
		// if (!$this->session->userdata("login")){
		// 	redirect(base_url());
		// }
			$this->templates = new League\Plates\Engine(APPPATH.'views');
			$this->templates->addFolder('control_stock', APPPATH.'views/control_stock');
			$this->data = array('correcto'=>'','alerta'=>'','error'=>'', 'datos'=>'');
			$this->load->model(array('Control_Stock_model', 'Productos_model'));

		}
		public function index()
		{		
			$data = array(
				'inventarios'=> $this->Control_Stock_model->getInventarios()
			);
			echo $this->templates->render('control_stock::list', $data);
		}
		public function add(){
			$data = array(			
				'maximo' => $this->Control_Stock_model->ObtenerCodigo(), 
				'productos'=> $this->Productos_model->getProductos(false, true) 
			);
			echo $this->templates->render('control_stock::add', $data);

		}
		public function store(){
			$mensajes= $this->data;
			$this->form_validation->set_rules("cantidad_minima", "Cantidad Minima", "required");
			$this->form_validation->set_rules("prod_id", "Producto", "required");
			$this->form_validation->set_rules("cantidad_inicial", "Cantidad Inicial", "required");
			$this->form_validation->set_rules("precio_venta", "Precio Venta", "required");
			$this->form_validation->set_rules("precio_compra", "Precio Compra", "required");
			if ($this->form_validation->run() == FALSE){
				$mensajes['alerta'] = validation_errors('<b style="color:red"><ul><li>', '</ul></li></b>'); 

			}else{
				$cantidad_minima = $this->input->post("cantidad_minima");
				$cantidad_inicial  = $this->input->post('cantidad_inicial');
				$precio_venta = $this->input->post('precio_venta');
				$precio_compra  = $this->input->post('precio_compra');
				$prod_id = $this->input->post('prod_id');
				$id_inventario = $this->Control_Stock_model->ObtenerCodigo();
				$time = time();
				$fechaActual = date("Y-m-d H:i:s",$time);
				$data = array(
					'inve_id'  => $id_inventario->MAXIMO,
					'inve_prod_id'  => trim($prod_id),
					'inve_precio_compra'  => trim($precio_compra),
					'inve_precio_venta'  => trim($precio_venta),
					'inve_cantidad'  => trim($cantidad_inicial),
					'inve_cantidad_minima'  => trim($cantidad_minima),
					'inve_fecha_creacion' => $fechaActual,
					'inve_fecha_modificacion'  => $fechaActual
				);
				if($this->Control_Stock_model->save($data)){
					$mensajes['correcto'] = 'correcto';
					$this->session->set_flashdata('success', 'Item registrado correctamente!');
					// redirect(base_url()."ciudades/ciudades", "refresh");
				}else{
					$mensajes['error'] = 'Item no registrado!';
					$this->session->set_flashdata('error', 'Proveedor no registrado!');
					// redirect(base_url()."ciudades/ciudades/add", "refresh");
				}
			}
			echo json_encode($mensajes);


		}
		public function edit($id)
		{
			$data = array(
				'inventario'=> $this->Control_Stock_model->getInventarios($id),
			);
			echo $this->templates->render('control_stock::edit', $data);


		}
		public function update()
		{
			$mensajes= $this->data;
			$this->form_validation->set_rules("cantidad_minima", "Cantidad Minima", "required");
			$this->form_validation->set_rules("prod_id", "Producto", "required");
			$this->form_validation->set_rules("cantidad_inicial", "Cantidad Inicial", "required");
			$this->form_validation->set_rules("precio_venta", "Precio Venta", "required");
			$this->form_validation->set_rules("precio_compra", "Precio Compra", "required");
			if ($this->form_validation->run() == FALSE){
				$mensajes['alerta'] = validation_errors('<b style="color:red"><ul><li>', '</ul></li></b>'); 

			}else{
				$cantidad_minima = $this->input->post("cantidad_minima");
				$cantidad_inicial  = $this->input->post('cantidad_inicial');
				$precio_venta = $this->input->post('precio_venta');
				$precio_compra  = $this->input->post('precio_compra');
				$prod_id = $this->input->post('prod_id');
				$inve_id = $this->input->post('inve_id');
				$time = time();
				$fechaActual = date("Y-m-d H:i:s",$time);
				$data = array(
					'inve_prod_id'  => trim($prod_id),
					'inve_precio_compra'  => trim($precio_compra),
					'inve_precio_venta'  => trim($precio_venta),
					'inve_cantidad'  => trim($cantidad_inicial),
					'inve_cantidad_minima'  => trim($cantidad_minima),
					'inve_fecha_creacion' => $fechaActual,
					'inve_fecha_modificacion'  => $fechaActual
				);
				if($this->Control_Stock_model->update($inve_id,$data)){
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
			if($this->control_stock_model->delete($id)){
				$this->session->set_flashdata('success', 'Eliminado correctamente!');
				redirect(base_url()."control_stock", "refresh");
			}else{
				$this->session->set_flashdata('error', 'Errores al Intentar Actualizar!');
				redirect(base_url()."control_stock","refresh");
			}

		}
	}