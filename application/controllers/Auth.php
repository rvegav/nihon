<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {


	public function __construct()
	{
		parent::__construct();
		$this->templates = new League\Plates\Engine(APPPATH.'views');
		$this->templates->addFolder('modulos', APPPATH.'views');
		// $this->load->model(array('Login'));
	}

	public function index()
	{
		if ($this->session->userdata('sist_conex')!="A") {
			$this->load->view('login');
		}else {
			redirect('inicio','refresh');
		}
	}

	public function ObtenerEstado()
	{
		$dato = $this->Login->ObtenerEstado();

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
		$comprobar = $this->Login->ComprobacionCredenciales($usuario,$password);

		if ($comprobar!=false) {

			$data = array(
				'sist_conex' => 'A',
				'sist_funcod' => $comprobar->EMPL_COD,
				'sist_funnom' => $comprobar->FUNC,
				'sist_ofidesc' => $comprobar->ESOR_DESC,
				'sist_sededesc' => $comprobar->SEDE_DESC,
				'sist_estsede' => $comprobar->ESSE_ID,
				'sist_role' => $comprobar->USSI_ROL_ID,
				'sist_usuid'	=> $comprobar->USUF_ID,
				'sist_usuname'	=> $comprobar->USUF_NOMBRE,
				'sist_ultconx' => $comprobar->ULTI_CONX,
				'sist_depsupe' => $comprobar->DEPE_SUPE,
				'sist_sedeco' => $comprobar->SEDE_COD,
				'sist_estorg' => $comprobar->ESOR_COD,
				'sist_cargo' => $comprobar->CARGO
			);


			$this->session->set_userdata($data);
			$this->Login->update_estado_usuario_activo();
			$this->Login->update_estado_sistrol_activo();
			echo json_encode("correcto");
		}else{
			echo json_encode("incorrecto");
		}
	}

	public function inicio()
	{
		$this->ObtenerEstado();
		if ($this->session->userdata('sist_conex')=="A") {
			echo $this->templates->render('modulos::v_inicio');
		}else {
			redirect(base_url(),'refresh');
		}
	}

	public function cerrarSesion()
	{
		$this->session->sess_destroy();
		redirect(base_url(),'refresh');
	}

	public function ContarContratados()
	{
		if ($this->session->userdata('sist_conex')!="I") {
			$response=$this->Login->ContarCantidadContratados();

			if ($response!=false) {
				echo json_encode($response);
			}else {
				echo json_encode("no_data");
			}
		}else {
			redirect(base_url(),'refresh');
		}
	}

	public function ContarNombrados()
	{
		if ($this->session->userdata('sist_conex')!="I") {
			$response=$this->Login->ContarCantidadNombrados();

			if ($response!=false) {
				echo json_encode($response);
			}else {
				echo json_encode("no_data");
			}
		}else {
			redirect(base_url(),'refresh');
		}
	}

	public function ContarVacantes()
	{
		if ($this->session->userdata('sist_conex')!="I") {
			$response=$this->Login->ContarCantidadVacantes();

			if ($response!=false) {
				echo json_encode($response);
			}else {
				echo json_encode("no_data");
			}
		}else {
			redirect(base_url(),'refresh');
		}
	}

	public function ContarJubilados()
	{
		if ($this->session->userdata('sist_conex')!="I") {
			$response=$this->Login->ContarCantidadJubilados();

			if ($response!=false) {
				echo json_encode($response);
			}else {
				echo json_encode("no_data");
			}
		}else {
			redirect(base_url(),'refresh');
		}
	}



}
