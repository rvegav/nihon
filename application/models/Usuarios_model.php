<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Usuarios_model extends CI_Model {
	
	public function login($username,$password){
		$this->db->select('U.IDEMPLEADO, U.DESUSUARIO,  CONCAT_WS(\' \',NOMBRE, APELLIDO) AS EMPLEADO, E.PERFIL ');
		$this->db->from('usuario u');
		$this->db->join('empleado e', 'e.idempleado = u.idempleado');
		$this->db->where("U.desusuario", $username);
		$this->db->where("U.passusuario", $password);
		$this->db->where("U.nivelcuenta", 1);
		
		$results= $this->db->get("");

		if($results->num_rows()>0){
			return $results->row();
		}else{
			//echo "error en user y clave";
			return false;
		}
	}


	public function getEmpresas(){
		$this->db->select("IDEMPRESA,DESEMPRESA,CONCAT(DESEMPRESA) AS EMPRESA");
		$resultados= $this->db->get("empresa");
		return $resultados->result();
	}

	public function getSucursales(){
		$this->db->select("IDSUCURSAL,NUMSUCURSAL,DESCSUCURSAL,CONCAT(NUMSUCURSAL,' ', DESCSUCURSAL) AS SUCURSAL");
		$resultados= $this->db->get("sucursal");
		return $resultados->result();
	}
	public function getUsuarios(){
		$this->db->select("U.IDUSUARIO, U.NUMUSUARIO, u.DESUSUARIO USERNAME, CONCAT(e.Nombre, ' ', e.Apellido) as NOMBRE, U.FECGRABACION AS FECHA_GRABACION, U.ESTADO");
		$this->db->from('usuario u');
		$this->db->join('empleado e', 'e.idempleado = u.idempleado');
		$this->db->join('permiroles pr', 'pr.idusuario = u.idusuario');
		$this->db->join('roles r', 'r.idrol = pr.idrol');
		// $this->db->join('empresa em', 'em.idempresa = u.idempresa');s
		$this->db->group_by('U.IDUSUARIO, U.NUMUSUARIO, u.DESUSUARIO, CONCAT(e.Nombre, \' \', e.Apellido), U.FECGRABACION , U.ESTADO');
		$results= $this->db->get();
		if($results->num_rows()>0){
			return $results->result();
		}else{
			//echo "error en user y clave";
			return false;
		}
	}
	public function save($data){
		$this->db->where('desusuario', $data['desusuario']);
		$this->db->or_where('idempleado', $data['idempleado']);
		$consulta = $this->db->get('usuario');
		if ($consulta->num_rows()==0) {
			$id = $this->ultimoId();
			$this->db->set('idusuario', $id->MAXIMO);
			
			if ($this->db->insert('usuario', $data)) {
				return $this->db->insert_id();
			}else{
				return false;
			}
		}else{
			return false;
		}
	}
	public function ultimoId(){
		$this->db->select("(CASE WHEN  max(idusuario) IS NULL THEN '1' ELSE max(idusuario) + 1 END) as MAXIMO");
		$this->db->from("usuario");
		$resultado= $this->db->get();
		return $resultado->row();
	}
	public function ultimoIdPermiRoles(){
		$this->db->select("(CASE WHEN  max(idpermirol) IS NULL THEN '1' ELSE max(idpermirol) + 1 END) as MAXIMO");
		$this->db->from("permiroles");
		$resultado= $this->db->get();
		return $resultado->row();
	}
	public function save_permiRoles($data){
		$id = $this->ultimoIdPermiRoles();
		$this->db->set('idpermirol', $id->MAXIMO);
		return $this->db->insert('permiroles', $data);
	}
	public function comprobarPermiso($parametros = false){
		return true;
		// $this->db->distinct();
		// $this->db->select('PE.IDPANTALLA, PE.PERINSERT, PE.PERSELECT, PE.PERDELETE, PE.PERUPDATE, m.DESMODULO, m.IDMODULO, u.DESUSUARIO');
		// $this->db->from('roles r');
		// $this->db->join('permiroles p', 'p.idrol = r.idrol');
		// $this->db->join('usuario u', 'p.idusuario = u.IDUSUARIO');
		// $this->db->join('permisos pe', 'pe.IDROL = p.IDROL');
		// $this->db->join('pantalla pa', 'pa.IDPANTALLA = pe.IDPANTALLA');
		// $this->db->join('modulo m', ' m.IDMODULO = pa.IDMODULO');
		// if ($parametros['idmodulo']!='') {
		// 	$this->db->where('m.IDMODULO', $parametros['idmodulo']);
		// }
		// if ($parametros['idpantalla']!='') {
		// 	$this->db->where('pa.IDPANTALLA', $parametros['idpantalla']);
		// }
		// if ($parametros['select']!='') {
		// 	$this->db->where('PE.PERSELECT', '1');
		// }
		// if ($parametros['update']!='') {
		// 	$this->db->where('PE.PERUPDATE', '1');
		// }
		// if ($parametros['delete']!='') {
		// 	$this->db->where('PE.PERDELETE', '1');
		// }
		// if ($parametros['insert']!='') {
		// 	$this->db->where('PE.PERINSERT', '1');
		// }
		// $this->db->where('u.DESUSUARIO', $parametros['usuario']);
		// $resultado = $this->db->get();
		// if($resultado->num_rows()>0){
		// 	return $resultado->result();
		// }else{
		// 	return false;
		// }
	}
}