<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Productos extends CI_Controller
{
	//solo el constructor, para llamar a las clases
	public function __construct()
	{
		parent::__construct();
		// if (!$this->session->userdata("login")){
		// 	redirect(base_url());
		// }
		$this->templates = new League\Plates\Engine(APPPATH.'views');
		$this->templates->addFolder('productos', APPPATH.'views/productos');
		$this->data = array('correcto'=>'','alerta'=>'','error'=>'', 'datos'=>'');
		$this->load->model(array('Usuarios_model','Productos_model', 'Proveedores_model', 'Tipo_Productos_model'));

		$this->comprobacionRoles();
	}
	public function comprobacionRoles()
	{
		$usuario = $this->session->userdata("sist_usuname");
		$idmodulo = 2;
		$pantalla = 5;
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
			'productos'=> $this->Productos_model->getProductos()
		);
		echo $this->templates->render('productos::list', $data);
	}
	//funcion add para mostrar vistas
	public function add()
	{
		$data = array(			
			'maximo' => $this->Productos_model->ObtenerCodigo(),
			'proveedores' => $this->Proveedores_model->getProveedores(),
			'tipo_productos' => $this->Tipo_Productos_model->getTipoProductos()
		);
		echo $this->templates->render('productos::add', $data);

	}
	//funcion vista
	public function store()
	{

		$mensajes= $this->data;
		$this->form_validation->set_rules("desProducto", "Descripcion", "required");
		// $this->form_validation->set_rules("marcaProducto", "Marca", "required");
		$this->form_validation->set_rules("estado", "Estado", "required");
		$this->form_validation->set_rules("tipr_id", "Tipo Producto", "required");
		$this->form_validation->set_rules("precio_venta", "Tipo Producto", "required");
		// $this->form_validation->set_rules("precio_compra", "Tipo Producto", "required");
		if ($this->form_validation->run() == FALSE){
			$mensajes['alerta'] = validation_errors('<b style="color:red"><ul><li>', '</ul></li></b>'); 

		}else{
			$desProducto   = $this->input->post("desProducto");
			$estado = $this->input->post('estado');
			$idProducto = $this->Productos_model->ObtenerCodigo();
			$prov_id = $this->input->post('prov_id');
			$tipr_id = $this->input->post('tipr_id');
			$precio_venta = $this->input->post('precio_venta');
			$precio_compra = $this->input->post('precio_compra');
			if ($prov_id=='') {
				$prov_id = NULL;
			}
			$marca = $this->input->post('marcaProducto');
			$time = time();
			$fechaActual = date("Y-m-d H:i:s",$time);
			$data = array(
				'prod_id'  => $idProducto->MAXIMO,
				'prod_descripcion'  => trim($desProducto),
				'prod_marca'=>$marca,
				'prod_tipr_id' => $tipr_id,
				'prod_prov_id' => $prov_id,
				'prod_estado' => $estado,
				'prod_precio_compra'=> $precio_compra,
				'prod_precio_venta'=> $precio_venta,
				'prod_fecha_creacion' => $fechaActual,
				'prod_fecha_modificacion'  => $fechaActual
			);
			$desProducto = trim($desProducto);
			if($this->Productos_model->validarExiste($desProducto, $prov_id)){
				$mensajes['error']= 'Ya existe un Producto con la misma descripcion';
			}else{
				if($this->Productos_model->save($data)){
					$mensajes['correcto'] = 'correcto';
					$this->session->set_flashdata('success', 'Producto registrado correctamente!');
					// redirect(base_url()."productos", "refresh");
				}else{
					$mensajes['error'] = 'Producto no registrado!';
					$this->session->set_flashdata('error', 'Producto no registrado!');
					// redirect(base_url()."add_producto", "refresh");
				}
			}
		}
		echo json_encode($mensajes);
		

	}
	public function edit($id)
	{
		$data = array(
			'producto'=> $this->Productos_model->getProductos($id),
			'proveedores' => $this->Proveedores_model->getProveedores(),
			'tipo_productos' => $this->Tipo_Productos_model->getTipoProductos()
		);
		echo $this->templates->render('productos::edit', $data);

		
	}
	public function update()
	{
		$mensajes = $this->data;
		$this->form_validation->set_rules("desProducto", "Descripcion", "required");
		// $this->form_validation->set_rules("marcaProducto", "Marca", "required");
		$this->form_validation->set_rules("tipr_id", "Tipo Producto", "required");
		$this->form_validation->set_rules("precio_venta", "Precio de Venta", "required");
		// $this->form_validation->set_rules("precio_compra", "Precio de Compra", "required");

		if ($this->form_validation->run() == FALSE){
			$mensajes['alerta'] = validation_errors('<b style="color:red"><ul><li>', '</ul></li></b>'); 

		}else{
			$desProducto   = $this->input->post("desProducto");
			$estado = $this->input->post('estado');
			$idProducto = $this->input->post('prod_id');
			$prov_id = $this->input->post('prov_id');
			$tipr_id = $this->input->post('tipr_id');
			$marca = $this->input->post('marcaProducto');
			$precio_venta = $this->input->post('precio_venta');
			$precio_compra = $this->input->post('precio_compra');
			$time = time();
			$fechaActual = date("Y-m-d H:i:s",$time);
			if ($prov_id=='') {
				$prov_id = NULL;
			}
			$data = array(
				'prod_descripcion'  => trim($desProducto),
				'prod_marca'=>$marca,
				'prod_tipr_id' => $tipr_id,
				'prod_prov_id'=>$prov_id,
				'prod_precio_compra'=> $precio_compra,
				'prod_precio_venta'=> $precio_venta,
				'prod_fecha_modificacion'  => $fechaActual,
				'prod_estado' => $estado
			);
			$desProducto = trim($desProducto);
			if($this->Productos_model->update($idProducto,$data)){
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
		if($this->Productos_model->delete($id)){
			$this->session->set_flashdata('success', 'Eliminado correctamente!');
			redirect(base_url()."productos", "refresh");
		}else{
			$this->session->set_flashdata('error', 'Errores al Intentar Actualizar!');
			redirect(base_url()."productos","refresh");
		}

	}
}