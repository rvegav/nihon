<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Model{

  public function __construct()
  {
    parent::__construct();
    $this->load->library('Bcrypt');
  }

  public function ComprobacionCredenciales($usuario,$password)
  {
    $this->db->select("USUF_ID,USUF_NOMBRE,USUF_PASSWORD,
			PERS_PRIM_NOMBRE||' '||PERS_SEG_NOMBRE||' '||PERS_PRIM_APELLIDO||' '||PERS_SEG_APELLIDO AS FUNC,
			USSI_ROL_ID,USSI_ETUS_ID,USSI_SIST_ID,TO_CHAR(USSI_ULTIMA_CONX,'dd/mm/RRRR HH24:MI:SS') ULTI_CONX,USUF_EMPL_PERS_COD EMPL_COD,ESOR_COD,ESOR_DESC,SEDE_COD,SEDE_DESC,ESSE_ID,ESOR_ESOR_COD_REF DEPE_SUPE,CARG_DESC CARGO");
		$this->db->from('SADU_USUFRUCTUARIO');
		$this->db->join('SADU_USUARIO_SISTEMA', 'USSI_USUF_ID = USUF_ID', 'left');
		$this->db->join('PERS_PERSONAS', 'PERS_COD = USUF_EMPL_PERS_COD', 'left');
		$this->db->join('RRHH_EMPLEADOS', 'EMPL_PERS_COD = PERS_COD', 'left');
		$this->db->join('RRHH_CARGOS', 'CARG_COD = EMPL_CARG_COD', 'left');
		$this->db->join('PERS_IDENTIFIC_PERSONAS', 'IDPR_PERS_COD = PERS_COD', 'left');
		$this->db->join('RRHH_ESTRUCTURAS_SEDES', 'ESSE_ID = EMPL_ESSE_ID_ASIG','left');
		$this->db->join('GRAL_SEDES', 'SEDE_COD = ESSE_SEDE_COD','left');
		$this->db->join('RRHH_ESTRUCTU_ORGANICAS', 'ESOR_COD = ESSE_ESOR_COD','left');
		$this->db->where("(USUF_NOMBRE = '".mb_strtolower($usuario)."' OR IDPR_NRO_DOC = '".mb_strtolower($usuario)."')");

		$this->db->where('USSI_SIST_ID', id_sistema);
		$this->db->where('USSI_ETUS_ID', 1);
		$consulta = $this->db->get('');

		if ($consulta->num_rows()==1) {
			$user = $consulta->row();
			$pass = $user->USUF_PASSWORD;
			if ($this->bcrypt->check_password($password, $pass)) {
				return $consulta->row();
			}else {
				return FALSE;
			}
		}else {
			return FALSE;
		}
  }

  public function update_estado_usuario_activo()
  {
    $this->db->where('USUF_ID', $this->session->userdata('sist_usuid'));
		$this->db->set('USUF_ESTADO_CONX', 'A');
		$this->db->set('USUF_ULTIMA_CONX',"to_date('".date('d/m/Y H:i:s')."','DD/MM/RRRR HH24:MI:SS')",false);
		$this->db->update('SADU_USUFRUCTUARIO');
  }

  public function update_estado_sistrol_activo()
	{
		$this->db->where('USSI_USUF_ID', $this->session->userdata('sist_usuid'));
		$this->db->where('USSI_SIST_ID', id_sistema);
		$this->db->set('USSI_ESTADO_CONX', 'A');
		$this->db->set('USSI_ULTIMA_CONX',"to_date('".date('d/m/Y H:i:s')."','DD/MM/RRRR HH24:MI:SS')",false);
		$this->db->update('SADU_USUARIO_SISTEMA');
	}

  public function ObtenerEstado()
  {
    $this->db->select('USSI_ESTADO_CONX ESTADO');
		$this->db->where('USSI_USUF_ID', $this->session->userdata('sist_usuid'));
		$this->db->where('USSI_SIST_ID', id_sistema);
		$consulta = $this->db->get('SADU_USUARIO_SISTEMA');
		return $consulta->row();
  }

  public function ContarCantidadContratados()
  {
    $this->db->select('COUNT(*) CANTCONTRATADOS');
    $this->db->from('SILSA_CONTRATOS');
    $this->db->where('CONT_EMPL_PERS_COD is NOT NULL');
    $r=$this->db->get('');

    if ($r->num_rows()>0) {
      return $r->result();
    }else {
      return false;
    }
  }

  public function ContarCantidadNombrados()
  {
    $this->db->select('COUNT(*) CANTNOMBRADOS');
    $this->db->from('SILSA_ANEXO_PERSONAS');
    $this->db->where('ANEX_EMPL_PERS_COD is NOT NULL');
    $this->db->where('ANEX_ANE_ANHO',2018);
    //$this->db->where('ANEX_ANE_ANHO',date('Y'));
    $r=$this->db->get('');

    if ($r->num_rows()>0) {
      return $r->result();
    }else {
      return false;
    }
  }

  public function ContarCantidadVacantes()
  {
    $this->db->select('COUNT(*) CANTVACANTES');
    $this->db->from('SILSA_ANEXO_PERSONAS');
    $this->db->where('ANEX_EMPL_PERS_COD is NULL');
    $this->db->where('ANEX_ANE_ANHO',2018);
    //$this->db->where('ANEX_ANE_ANHO',date('Y'));
    $r=$this->db->get('');

    if ($r->num_rows()>0) {
      return $r->result();
    }else {
      return false;
    }
  }

  public function ContarCantidadJubilados()
  {
    $this->db->select('COUNT(*) CANTJUBILADOS');
    $this->db->from('SILSA_EMPLEADOS_JUBILADOS');
  
    $r=$this->db->get('');

    if ($r->num_rows()>0) {
      return $r->result();
    }else {
      return false;
    }
  }

}
