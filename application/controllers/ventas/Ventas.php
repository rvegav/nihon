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
			$this->load->library('pdf');
			$options = new Dompdf\Options();
			$options->setIsRemoteEnabled(true);
			$options->setIsPhpEnabled(true);
			$this->dompdf = new Dompdf\Dompdf($options);
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
				'ventas'=> $this->Ventas_model->getVentas()
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
			$this->form_validation->set_rules("ruc", "RUC", "required");
			$this->form_validation->set_rules("nombre_razon_social", "Nombre o Razon Social", "required");
			if ($this->form_validation->run() == FALSE){
				$mensajes['alerta'] = validation_errors('<b style="color:red"><ul><li>', '</ul></li></b>'); 

			}else{
				$clie_id = $this->input->post('clie_id');
				$razon_social = $this->input->post('nombre_razon_social');
				$productos = $this->input->post('productos');
				$ruc = $this->input->post('ruc');
				$data = array(
					'ven_clie_id' => $clie_id,
					'ven_ruc' => $ruc,
					'ven_razon_social' => $razon_social,
					'ven_forma_pago' => 'E'

				);
				$this->Ventas_model->save($data);
				$ultimo_id = $this->Ventas_model->getUltimoInsert($clie_id, $razon_social, $ruc);
				foreach ($productos as $producto) {
					if (isset($producto['prod_id_nuevo'])) {
						$prod_id = $producto['prod_id_nuevo'];
						$cantidad = $producto['cantidad_nuevo'];
						$stock_producto = $this->Control_Stock_model->getInventarios(false, $producto['prod_id_nuevo'] );
						$data = array(
							'inve_cantidad'=> $stock_producto->inve_cantidad - $producto['cantidad']
						);
						$this->Control_Stock_model->update($stock_producto->inve_id, $data);
					}else{
						$prod_id = $producto['prod_id'];
						$cantidad = $producto['cantidad'];
					}
					$data = array(
						'vede_prod_id' => $prod_id,
						'vede_cantidad' => $cantidad,
						'vede_ven_id' => $ultimo_id->ven_id
					);
					$this->Ventas_model->save_detalle($data);
				}
				$data = array(
					'ven_estado'=>2
				);
				if($this->Ventas_model->update($ultimo_id->ven_id, $data)){
					$mensajes['correcto'] = 'correcto';
					$this->session->set_flashdata('success', 'Venta registrada correctamente!');
				}else{
					$mensajes['error'] = 'Venta no registrada!';
					$this->session->set_flashdata('error', 'Venta no registrada!');
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

		public function viewFactura($id_ventas){
			$data = array(
				'venta'=> $this->Ventas_model->getVentas($id_ventas),
				'detalles' =>$this->Ventas_model->getDetalleVenta($id_ventas)
			);
			$cuerpo = $this->load->view('ventas/view',$data, true);
			$this->load->view('ventas/view');
			$this->dompdf->load_html($cuerpo);
			$this->dompdf->set_paper('Legal','portrait');


			$this->dompdf->render();

			$this->dompdf->stream('factura',array("Attachment" => 0) );
			// if ($stream=TRUE) {
			// 	$this->dompdf->stream("$archivo", array("Attachment" => 0));
			// } else {
			// 	return $this->dompdf->output();
			// }
		}
	}