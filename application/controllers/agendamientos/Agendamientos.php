<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Agendamientos extends CI_Controller
{
	//solo el constructor, para llamar a las clases
	public function __construct()
	{
		parent::__construct();
		// if (!$this->session->userdata("login")){
		// 	redirect(base_url());
		// }
		$this->templates = new League\Plates\Engine(APPPATH.'views');
		$this->templates->addFolder('agendamientos', APPPATH.'views/agendamientos');
		$this->data = array('correcto'=>'','alerta'=>'','error'=>'', 'datos'=>'');
		$this->load->model(array('Usuarios_model','Agendamientos_model', 'Turnos_model','Clientes_model', 'Razas_model', 'Empleados_model', 'Mascotas_model', 'Productos_model', 'Control_Stock_model'));

		$this->comprobacionRoles();
		$time = time();
		$this->fechaActual = date("Y-m-d H:i:s",$time);
	}
	public function comprobacionRoles()
	{
		$usuario = $this->session->userdata("sist_usuname");
		$idmodulo = 2;
		$pantalla = 2;
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
		$data = array(
			'agendamientos'=> $this->Agendamientos_model->getMascotas()
		);
		echo $this->templates->render('agendamientos::list', $data);
	}
	public function recepcion(){
		$data = array(
			'agendamientos'=> $this->Agendamientos_model->getAgendamiento()
		);
		echo $this->templates->render('agendamientos::list_recepcion', $data);	
	}

	public function atencion(){	
		$empl_id = $this->session->userdata('sist_empl_id');	
		$data = array(
			'agendamientos'=> $this->Agendamientos_model->getAgendamiento(false, $empl_id)
		);
		echo $this->templates->render('agendamientos::list_atencion', $data);	
	}

	//funcion add para mostrar vistas
	public function add()
	{
		$data = array(			
			'clientes' => $this->Clientes_model->getClientes(),
			'empleados' => $this->Empleados_model->getempleados(), 
			'servicios' => $this->Productos_model->getProductos(false, 'N'),
		);
		echo $this->templates->render('agendamientos::add', $data);

	}
	//funcion vista
	public function store()
	{

		$mensajes= $this->data;
		$this->form_validation->set_rules("mascota", "Paciente", "required");
		$this->form_validation->set_rules("empl_id", "Empleado", "required");
		if ($this->form_validation->run() == FALSE){
			$mensajes['alerta'] = validation_errors('<b style="color:red"><ul><li>', '</ul></li></b>'); 

		}else{

			$turnos = $this->input->post('turnos');
			$mascota = $this->input->post('mascota');
			$empl_id_atencion = $this->input->post('empl_id');
			$razon = $this->input->post('razon');
			$estado = $this->input->post('estado');
			$datoMascota = $this->Mascotas_model->getMascotas($mascota);
			$firstDate  = new DateTime($datoMascota->mas_fecha_nacimiento_sin);
			$secondDate = new DateTime($this->fechaActual);
			$intvl = $firstDate->diff($secondDate);
			foreach ($turnos as $turno) {
				$data = array(
					'age_estado'  => $estado,
					'age_mas_id'  => $mascota,
					'age_emp_id_atencion'=>$empl_id_atencion,
					'age_emp_id_recepcion' => $this->session->userdata('sist_empl_id'),
					'age_tude_id' => $turno,
					'age_motivo_agendamiento' => $razon,
					'age_edad_paciente' =>$intvl->y . " años, " . $intvl->m."meses y ".$intvl->d." días",
					'age_fecha_creacion' => $this->fechaActual,
					'age_fecha_modificacion'  => $this->fechaActual
				);
				$this->Agendamientos_model->updateDisponibilidad($turno, 'OCUPADO');
				if($this->Agendamientos_model->save($data)){
					$mensajes['correcto'] = 'correcto';
					$this->session->set_flashdata('success', 'Atencion registrada correctamente!');
				}else{
					$mensajes['error'] = 'Atencion no registrada!';
					$this->session->set_flashdata('error', 'Atencion no registrada!');
				}
			}
			
		}
		echo json_encode($mensajes);
		

	}
	public function edit($id)
	{
		$data = array(

			'agenda'=> $this->Agendamientos_model->getAgendamiento($id),
			'clientes' => $this->Clientes_model->getClientes(),
			'empleados' => $this->Empleados_model->getempleados(), 
			'servicios' => $this->Productos_model->getProductos(false, 'N'),
		);
		echo $this->templates->render('agendamientos::edit_recepcion', $data);

		
	}
	public function update()
	{
		$mensajes= $this->data;
		$this->form_validation->set_rules("mascota", "Paciente", "required");
		$this->form_validation->set_rules("empl_id", "Empleado", "required");
		if ($this->form_validation->run() == FALSE){
			$mensajes['alerta'] = validation_errors('<b style="color:red"><ul><li>', '</ul></li></b>'); 

		}else{
			$turnos = $this->input->post('turnos');
			$mascota = $this->input->post('mascota');
			$empl_id_atencion = $this->input->post('empl_id');
			$razon = $this->input->post('razon');
			$estado = $this->input->post('estado');
			foreach ($turnos as $turno) {
				$data = array(
					'age_estado'  => $estado,
					'age_mas_id'  => $mascota,
					'age_emp_id_atencion'=>$empl_id_atencion,
					'age_emp_id_recepcion' => $this->session->userdata('sist_empl_id'),
					'age_tude_id' => $turno,
					'age_motivo_agendamiento' => $razon,
					'age_fecha_creacion' => $this->fechaActual,
					'age_fecha_modificacion'  => $this->fechaActual
				);
				$this->Agendamientos_model->updateDisponibilidad($turno, 'OCUPADO');
				if($this->Agendamientos_model->update($age_id, $data)){
					$mensajes['correcto'] = 'correcto';
					$this->session->set_flashdata('success', 'Atencion registrada correctamente!');
				}else{
					$mensajes['error'] = 'Atencion no registrada!';
					$this->session->set_flashdata('error', 'Atencion no registrada!');
				}
			}
		}
		echo json_encode($mensajes);

	}
	public function delete($id)
	{
		if($this->Agendamientos_model->delete($id)){
			$this->session->set_flashdata('success', 'Eliminado correctamente!');
			redirect(base_url()."productos", "refresh");
		}else{
			$this->session->set_flashdata('error', 'Errores al Intentar Actualizar!');
			redirect(base_url()."productos","refresh");
		}

	}

	public function atender($id){
		$agenda = $this->Agendamientos_model->getAgendamiento($id);
		$data = array(

			'agenda'=> $agenda, 
			'servicios' => $this->Productos_model->getProductos(false, 'N'),
			'productos' => $this->Control_Stock_model->getInventarios(),
			'mascota' => $this->Mascotas_model->getMascotas($agenda->age_mas_id),
			'fechaActual' => $this->fechaActual,
		);
		echo $this->templates->render('agendamientos::edit_atencion', $data);
	}
	public function viewAgendamiento($id){
		$agenda = $this->Agendamientos_model->getAgendamiento($id);
		$data = array(
			'agenda'=> $agenda, 
			'mascota' => $this->Mascotas_model->getMascotas($agenda->age_mas_id),
			'servicios' => $this->Agendamientos_model->getDetalleAgendamiento($id, 'N'),
			'productos' => $this->Agendamientos_model->getDetalleAgendamiento($id, 'S'),
		);
		echo $this->templates->render('agendamientos::view_agendamiento', $data);
	}
	public function atencionExpediente(){

		$mensajes= $this->data;
		$peso = $this->input->post('peso');
		$diagnostico = $this->input->post('diagnostico');
		$observacion = $this->input->post('observacion');
		$productos = $this->input->post('productos');
		$servicios = $this->input->post('servicios');
		$age_id = $this->input->post('age_id');
		$config['upload_path']          = './uploads/';
		$config['allowed_types']        = 'gif|jpg|png|csv|xlsx|xls';
		$config['overwrite'] = true;
		$config['file_name'] = $age_id;
		$this->load->library('upload', $config);
		if ( !$this->upload->do_upload('userfile')){
			$error = array('error' => $this->upload->display_errors());
			$image  ='';
		}else{
			$perfil = $this->upload->data();
			$image = $perfil['file_name'];

			// $data = file_get_contents('uploads/'.$perfil['file_name']);
			// $base64 = base64_encode($data);
			// $perfil = 'data:image/' . $perfil['image_type'] . ';base64,'.$base64;
		}
		$data = array(
			'age_peso'  => $peso,
			'age_diagnostico'  =>strtoupper( $diagnostico),
			'age_observacion'=>strtoupper($observacion),
			'age_fecha_atencion'=>$this->fechaActual,
			'age_fecha_modificacion'=>$this->fechaActual,
			'age_imagen' =>$image
		);
		$this->Agendamientos_model->update($age_id, $data);
		if ($productos) {
			foreach ($productos as $producto) {
				$data = array(
					'agde_prod_id' => $producto['prod_id'],
					'agde_cantidad' => $producto['cantidad'],
					'agde_age_id' => $age_id
				);
				$this->Agendamientos_model->save_detalle($data);
				$stock_producto = $this->Control_Stock_model->getInventarios(false, $producto['prod_id'] );
				$data = array(
					'inve_cantidad'=> $stock_producto->inve_cantidad - $producto['cantidad']
				);
				$this->Control_Stock_model->update($stock_producto->inve_id, $data);
			}
		}
		foreach ($servicios as $servicio) {
			$data = array(
				'agde_prod_id' => $servicio['serv_id'],
				'agde_cantidad' => 1,
				'agde_age_id' => $age_id
			);
			$this->Agendamientos_model->save_detalle($data);
		}
		$data = array(
			'age_estado' => 2
		);
		if($this->Agendamientos_model->update($age_id, $data)){
			$mensajes['correcto'] = 'correcto';
			$this->session->set_flashdata('success', 'Atencion registrada correctamente!');
		}else{
			$mensajes['error'] = 'Atencion no registrada!';
			$this->session->set_flashdata('error', 'Atencion no registrada!');
		}
		echo json_encode($mensajes);

	}
	public function getMascotasCliente(){
		$clie_id = $this->input->post('clie_id');
		if ($clie_id) {
			$mascotas = $this->Mascotas_model->getMascotas(false, $clie_id);
			if ($mascotas) {

				foreach ($mascotas as $mascota) {
					$array = [];
					$array['MAS_ID'] = $mascota->mas_id;
					$array['MAS_NOMBRE'] = $mascota->mas_nombre;
					$array['MAS_RAZA'] = $mascota->mas_raza;
					$firstDate  = new DateTime($mascota->mas_fecha_nacimiento_sin);
					$secondDate = new DateTime($this->fechaActual);
					$intvl = $firstDate->diff($secondDate);
					$array['EDAD'] = $intvl->y . " años, " . $intvl->m."meses y ".$intvl->d." días"; 
					$datos[] = $array;
				}
				$data['data'] = $datos;

			}else{
				$data['data'] =[];
			}
		}else{
			$data['data'] =[];

		}
		echo json_encode($data);
	}
	public function getDisponibilidadTurno(){
		$fecha = $this->input->post('fecha_consulta');
		$servicio = $this->input->post('servicio_consulta');
		$turno = $this->Agendamientos_model->getCantTurnos(4);

		if ($fecha and $servicio) {
			$turnosDisponibles = $this->Agendamientos_model->getDisponibilidadTurnos($fecha, $servicio);
			if (!$turnosDisponibles) {
				$turno = $this->Agendamientos_model->getCantTurnos($servicio);
				if ($turno) {
					for ($i=0; $i < $turno->cantidad_disponible ; $i++) {
						if ($i==0) {
							$hora = date('H:i:s', strtotime($turno->tur_desde_hora));
						}else{
							$hora = date('H:i:s',strtotime($hora.'+'.$turno->tur_tiempo_aproximado.'minutes'));
						}
						$data = array(
							'tude_tur_id'  => $turno->tur_id,
							'tude_hora'  => trim($hora),
							'tude_estado'=>'DISPONIBLE',
							'tude_fecha'=>$fecha,
							'tude_fecha_creacion'=>$this->fechaActual,
							'tude_fecha_modificacion'=>$this->fechaActual
						);
						$this->Turnos_model->insertDetalle($data);
					}
					
				}else{
					$data['error'] = 'No existe un Turno asociado al servicio seleccionado';
				}
			}
			$item = 1;
			foreach ($turnosDisponibles as $turno) {
				$array = [];
				$array['ITEM'] = $item;
				setlocale(LC_ALL, 'Spanish_Paraguay');
				$dia = strftime('%A', strtotime($turno->tude_fecha));
				$array['DIA'] = strtoupper($dia);
				$array['HORA'] = $turno->tude_hora;
				$array['ESTADO'] = $turno->tude_estado;
				$array['ID'] = $turno->tude_id;
				$datos[] = $array;
				$item++;
			}
			$data['data'] = $datos;
		}else{
			$data['data'] =[];
		}
		echo json_encode($data);
	}
	public function getServicio(){
		$age_id = $this->input->post('age_id');
		$agendamiento_data = $this->Agendamientos_model->getAgendamiento($age_id);
		$array['ID'] = $agendamiento_data->prod_id;
		$array['DESCRIPCION'] = $agendamiento_data->prod_descripcion;
		$dato[] = $array;
		$data['data'] = $dato;
		echo json_encode($data);
	}
	public function getDisponibilidadProductos(){
		$productos = $this->Control_Stock_model->getInventarios();
		if ($productos) {
			foreach ($productos as $producto) {
				$array = [];
				$array['ID'] = $producto->prod_id;
				$array['DESCRIPCION'] = $producto->prod_descripcion;
				$array['CANTIDAD'] = $producto->inve_cantidad;
				$array['PRECIO'] = $producto->prod_precio_venta;
				$datos[] = $array;
				$data['data'] = $datos;
			}
			$data['data'] = $datos;
		}else{
			$data['data'] =[];
		}
		echo json_encode($data);

	}
	public function getDetallesAgendamientos(){
		$age_id = $this->input->post('age_id');
		$detalles = $this->Agendamientos_model->getDetalleAgendamiento($age_id);
		foreach ($detalles as $detalle) {
			$array = [];
			$array['ID'] = $detalle->prod_id;
			$array['DESCRIPCION'] = $detalle->prod_descripcion;
			$array['CANTIDAD'] = $detalle->agde_cantidad;
			$array['PRECIO'] = $detalle->prod_precio_venta;
			$datos[] = $array;
		}
		echo json_encode($datos);
	}
}