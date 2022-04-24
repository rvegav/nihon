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
		$this->load->model(array('Usuarios_model','Agendamientos_model', 'Turnos_model','Clientes_model', 'Razas_model', 'Empleados_model', 'Mascotas_model', 'Productos_model'));

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
			'agendamientos'=> $this->Agendamientos_model->getAgendamiento($empl_id)
		);
		echo $this->templates->render('agendamientos::list_atencion', $data);	
	}

	//funcion add para mostrar vistas
	public function add()
	{
		$data = array(			
			'maximo' => $this->Agendamientos_model->ObtenerCodigo(),
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
			'agenda'=> $this->Agendamientos_model->getMascotas($id),
			'mascotas' => $this->Clientes_model->getClientes(),
			'empleados' => $this->Razas_model->getRazas()
		);
		echo $this->templates->render('agendamientos::edit', $data);

		
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
			if($this->Agendamientos_model->update($idMascota,$data)){
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
		if($this->Agendamientos_model->delete($id)){
			$this->session->set_flashdata('success', 'Eliminado correctamente!');
			redirect(base_url()."productos", "refresh");
		}else{
			$this->session->set_flashdata('error', 'Errores al Intentar Actualizar!');
			redirect(base_url()."productos","refresh");
		}

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
}