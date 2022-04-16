<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Usuarios_model extends CI_Model {
	
	public function login($username,$password){
		$this->db->select('usua_id, usua_name, CONCAT(p.per_nombre, " ", p.per_apellido) usua_empleado, usua_estado, mod_id, pant_id, usua_clave');
		$this->db->from('usuarios u');
		$this->db->join('empleados e', 'e.empl_id = u.usua_empl_id ');
		$this->db->join('personas p', 'e.empl_per_id = p.per_id');
		$this->db->join('roles_usuarios ru', 'ru.rol_usu_usu_id = u.usua_id');
		$this->db->join('roles r', 'r.rol_id = ru.rol_usu_rol_id');
		$this->db->join('rol_detalles rd', 'rd.rol_det_rol_id = r.rol_id');
		$this->db->join('pantallas pa', 'pa.pant_id = rd.rol_det_pant_id');
		$this->db->join('modulos m', 'm.mod_id = pa.pant_mod_id');
		$this->db->where("u.usua_name", $username);
		$this->db->order_by('5', 'asc');
		$this->db->order_by('6', 'asc');
		$results= $this->db->get();

		if($results->num_rows()>0){
			$user = $results->row();
			$pass = $user->usua_clave;
			if ($this->bcrypt->check_password($password, $pass)) {
				return $results->result();
			}else {
				return FALSE;
			}
		}else{
			return false;
		}
	}

	public function getUsuarios($id= false){
		$this->db->select("usua_id, usua_name, CONCAT(p.per_nombre, ' ', p.per_apellido) usua_empleado,u.usua_empl_id, usua_estado, usua_fecha_creacion, usua_fecha_modificacion");
		$this->db->from('usuarios u');
		$this->db->join('empleados e', 'e.empl_id = u.usua_empl_id');
		$this->db->join('personas p', 'e.empl_per_id = p.per_id');
		$this->db->join('roles_usuarios ru', 'ru.rol_usu_usu_id = u.usua_id');
		$this->db->join('roles r', 'r.rol_id = ru.rol_usu_rol_id');
		$this->db->group_by('usua_id, usua_name, usua_estado, usua_fecha_creacion, usua_fecha_modificacion');
		if ($id) {
			$this->db->where('usua_id', $id);
		}
		$results= $this->db->get();
		if($results->num_rows()>0){
			if ($id) {
				return $results->row();
			}
			return $results->result();
		}else{
			//echo "error en user y clave";
			return false;
		}
	}
	public function getRolUsuario($id_usuario){
		$this->db->select('rol_id, rol_descripcion');
		$this->db->from('roles');
		$this->db->join('roles_usuarios', 'rol_id = rol_usu_rol_id');
		$this->db->where('rol_usu_usu_id', $id_usuario);
		$resultado = $this->db->get();
		if ($resultado->num_rows()>0) {
			return $resultado->result();
		}else{
			return false;
		}
	}
	public function save($data){
		$this->db->where('usua_name', $data['usua_name']);
		$this->db->or_where('usua_empl_id', $data['usua_empl_id']);
		$consulta = $this->db->get('usuarios');
		if ($consulta->num_rows()==0) {			
			if ($this->db->insert('usuarios', $data)) {
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
	public function save_rol_usuario($data){
		return $this->db->insert('roles_usuarios', $data);
	}


	public function update_estado_sistrol_activo()
	{
		$this->db->where('usua_id', $this->session->userdata('sist_usuid'));
		$this->db->set('usua_estado_conexion', 'A');
		$this->db->update('usuarios');
	}
	public function ObtenerEstado()
	{
		$this->db->select('usua_estado_conexion ESTADO');
		$this->db->where('usua_id', $this->session->userdata('sist_usuid'));
		$consulta = $this->db->get('usuarios');
		return $consulta->row();
	}
	public function getPermisosRol($username, $pantalla = false, $modulo = false){
		$this->db->select('pant_descripcion, rd.rol_det_actualizar, rd.rol_det_visualizar, rd.rol_det_borrar, rd.rol_det_insertar');
		$this->db->from('usuarios u');
		$this->db->join('roles_usuarios ru', 'ru.rol_usu_usu_id = u.usua_id');
		$this->db->join('roles r', 'r.rol_id = ru.rol_usu_rol_id');
		$this->db->join('rol_detalles rd', 'rd.rol_det_rol_id = r.rol_id');
		$this->db->join('pantallas pa', 'pa.pant_id = rd.rol_det_pant_id');
		$this->db->join('modulos m', 'm.mod_id = pa.pant_mod_id');
		$this->db->where('u.usua_name', $username);
		if ($pantalla) {
			$this->db->where('pa.pant_id', $pantalla);
		}
		if ($modulo) {
			$this->db->where('m.mod_id', $modulo);
		}
		$resultado = $this->db->get();
		if ($resultado->num_rows()>0) {
			return $resultado->row();
		}else{
			return false;
		}
	}
	public function update($id, $data, $password = false){
		if ($password) {
			$this->db->set('usua_clave', $password);			
		}
		$this->db->where("usua_id", $id);
		return $this->db->update("usuarios", $data);
	}
	public function resetRoles($id_usuario){
		$this->db->where('rol_usu_usu_id', $id_usuario);
		$this->db->delete('roles_usuarios');
	}
}