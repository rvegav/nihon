<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {


	public function __construct()
	{
		parent::__construct();
		$this->templates = new League\Plates\Engine(APPPATH.'views');
		$this->templates->addFolder('dashboard', APPPATH.'views/dashboard');
		$this->load->model(array('Usuarios_model', 'Turnos_model', 'Agendamientos_model'));
		$this->load->library('Bcrypt');

		$this->date = new Datetime();
		$time = time();
		$this->fechaActual = date("Y-m-d H:i:s",$time);
		setlocale(LC_TIME, 'es_ES');

	}

	public function index()
	{

		if ($this->session->userdata('sist_conex')!="A") {
			$this->load->view('login_2');
		}else {
			redirect('inicio','refresh');
		}
	}

	public function ObtenerEstado()
	{
		$dato = $this->Usuarios_model->ObtenerEstado();

		if ($dato!="") {
			$datestconusu = array(
				'sist_conex' => $dato->ESTADO,
			);
		}else {
			$datestconusu = array(
				'sist_conex' => 'I',
			);
		}
		$this->session->set_userdata($datestconusu);
	}

	public function ProcesoLogin()
	{
		$usuario = $this->input->post('usuario');
		$password = $this->input->post('password');
		$comprobar = $this->Usuarios_model->login($usuario,$password);

		if ($comprobar!=false) {
			$mod_id_aux = '';
			$pan_id_aux = '';
			foreach ($comprobar as $modulo){
				if ($mod_id_aux <> $modulo->mod_id) {
					$modulos[] = $modulo->mod_id;
					$mod_id_aux = $modulo->mod_id;
				}
				if ($pan_id_aux <> $modulo->pant_id) {
					$pantallas[] = $modulo->pant_id;
					$pan_id_aux = $modulo->pant_id;
				}
			}
			$data = array(
				'sist_conex' => 'A',
				'sist_funnom' => $comprobar[0]->usua_empleado,
				'sist_empl_id' => $comprobar[0]->usua_empl_id,
				'sist_modulos' => $modulos,
				'sist_pantallas' => $pantallas,
				'sist_usuid'	=> $comprobar[0]->usua_id,
				'sist_usuname'	=> $comprobar[0]->usua_name,
			);


			$this->session->set_userdata($data);
			$this->Usuarios_model->update_estado_sistrol_activo();
			// $this->Usuarios_model->update_estado_sistrol_activo();
			echo json_encode("correcto");
		}else{
			echo json_encode("incorrecto");
		}
	}

	public function inicio()
	{
		$this->ObtenerEstado();
		if ($this->session->userdata('sist_conex')=="A") {
			$fecha = strftime("%d de %B, %Y", $this->date->getTimestamp());
			$fecha_actual = date('Y-m-d');
			$turnos = $this->Turnos_model->getTurnos();
			if ($turnos) {
				foreach ($turnos as $turno) {
					$disponible=0;
					$ocupado=0;
					$turnosDisponibles = $this->Agendamientos_model->getDisponibilidadTurnos($fecha_actual, $turno->tur_prod_id);
					if (!$turnosDisponibles) {
						$cantidad_turnos = $this->Agendamientos_model->getCantTurnos($turno->tur_prod_id);
						for ($i=0; $i < $cantidad_turnos->cantidad_disponible ; $i++) {
							if ($i==0) {
								$hora = date('H:i:s', strtotime($cantidad_turnos->tur_desde_hora));
							}else{
								$hora = date('H:i:s',strtotime($hora.'+'.$cantidad_turnos->tur_tiempo_aproximado.'minutes'));
							}
							$data = array(
								'tude_tur_id'  => $cantidad_turnos->tur_id,
								'tude_hora'  => trim($hora),
								'tude_estado'=>'DISPONIBLE',
								'tude_fecha'=>$fecha_actual,
								'tude_fecha_creacion'=>$this->fechaActual,
								'tude_fecha_modificacion'=>$this->fechaActual
							);
							$this->Turnos_model->insertDetalle($data);
						}
					}else{
						foreach ($turnosDisponibles as $disponibilidad) {
							if ($disponibilidad->tude_estado == 'DISPONIBLE') {
								$disponible++;
							}elseif ($disponibilidad->tude_estado == 'OCUPADO') {
								$ocupado++;
							}
						}
					}
					$dato[$turno->prod_descripcion]['servicio'] = $turno->prod_descripcion;
					$dato[$turno->prod_descripcion]['disponible'] = $disponible;
					$dato[$turno->prod_descripcion]['ocupado'] = $ocupado;
					
				}
			}
			$data = array(
				'fecha'=>$fecha, 
				'turnos' =>$dato
			);
			echo $this->templates->render('dashboard::inicio', $data);
		}else {
			redirect(base_url(),'refresh');
		}
	}

	public function cerrarSesion()
	{
		$this->session->sess_destroy();
		redirect(base_url(),'refresh');
	}


}
