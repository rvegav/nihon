<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Permiso_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
		
	}
	public function save($data)
	{
		return $this->db->insert("permisos", $data);
	}
	public function ultimoInsert(){
		$this->db->select('MAX(idpermiso) AS IDPERMISO');
		$this->db->from('permisos');
		$resultado = $this->db->get();
		return $resultado->row();
	}
	public function ObtenerCodigo(){
	    $this->db->select("(CASE WHEN  max(IDPERMISO) IS NULL THEN 1 ELSE max(IDPERMISO) + 1 END) as MAXIMO");
		$this->db->from("permisos");
		$resultado= $this->db->get();
		return $resultado->row();
	}
	public function save_permiRoles($data){
		return $this->db->insert("permiroles", $data);
	}
	public function getPermisosRol($idRol){
		$this->db->select('M.DESMODULO, PA.DESPANTALLA,PA.IDPANTALLA, P.PERSELECT, P.PERUPDATE, P.PERDELETE, P.PERINSERT, P.IDPERMISO');
		$this->db->from('ROLES R');
		$this->db->join('PERMISOS P', 'P.IDROL = R.IDROL');
		$this->db->join('PANTALLA PA', 'PA.IDPANTALLA = P.IDPANTALLA');
		$this->db->join('MODULO M', 'M.IDMODULO = PA.IDMODULO');
		$this->db->where('R.IDROL', $idRol);
		$resultado = $this->db->get();
		if($resultado->num_rows()>0){
			return $resultado->result();
		}else{
			//echo "error en user y clave";
			return false;
		}

	}
	public function update($idRol, $idPermiso, $data){
		// echo $idPermiso;
		echo "<pre>";
		var_dump($data);
		var_dump($idPermiso);
		
		echo "</pre>";

		// die();
		if ($idPermiso !='') {
			$this->db->where('IDPERMISO', $idPermiso);
			return $this->db->update('PERMISOS', $data);
		}else{
			$this->db->set('IDROL', $idRol);
			$idpermiso = $this->ObtenerCodigo();
			$this->db->set('IDPERMISO', $idpermiso->MAXIMO);
			return $this->db->insert('PERMISOS', $data);
		}
	}
}

/* End of file Permiso_model.php */
/* Location: ./application/models/Permiso_model.php */