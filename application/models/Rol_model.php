<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Rol_model extends CI_Model {
	//estos son metodos q tienen q ver con bd
	
	//este metodo es para mostrar todos los empleado

	public function getModulos(){
	//	$this->db->where("estempleado", "1");
		$resultados= $this->db->get("modulos");
		return $resultados->result();
	}

	public function getPantallas(){
	//	$this->db->where("estempleado", "1");
		$resultados= $this->db->get("pantallas");
		return $resultados->result();
	}

	public function getPantallaModulo($id){
		$this->db->where("pant_mod_id", $id);
		$resultados= $this->db->get("pantallas");
		return $resultados->result();
	}
	
	//esta es la parte para guardar en la bd
	public function save($data)
	{
		return $this->db->insert("roles", $data);
	}
	
	//esto es una funcion o metodo para mostrar 1 empleado por id
	public function getRoles($id = false){
		$this->db->select("rol_id,rol_descripcion,rol_fecha_creacion, rol_fecha_modificacion");
		if ($id) {
			$this->db->where("rol_id",$id);
		}
		$resultado= $this->db->get("roles");
		if ($resultado->num_rows()>0) {
			if ($id) {
				return $resultado->row();
			}else{
				return $resultado->result();
			}
		}
	}
	//esto es para actualizar los empleado
	public function update($id, $data){
		$this->db->where("rol_id", $id);
		return $this->db->update("roles", $data);

	}

	public function validarExiste($numRol){
		$this->db->select("count(*) as cantidad");
		$this->db->from("roles");
		$resultados= $this->db->get();
		return $resultados->result();	
	}
//obtener el ultimo id mas 1
	public function ultimoNumero(){
		$this->db->select("(CASE WHEN  max(rol_id) IS NULL THEN '1' ELSE max(rol_id) + 1 END) as MAXIMO");
		$this->db->from("roles");
		$resultado= $this->db->get();
		return $resultado->row();
	}

	public function ObtenerCodigo(){
		$this->db->select("(CASE WHEN  max(rol_id) IS NULL THEN '01' when (max(rol_id) + 1) <= 9 then concat('0',(max(rol_id) + 1)) ELSE max(rol_id) + 1 END) as MAXIMO");
		$this->db->from("roles");
		$resultado= $this->db->get();
		return $resultado->row();
	}

	public function delete($id){
		$this->db->where("rol_id", $id);
		$this->db->delete("permisos");
		$this->db->where("idrol", $id);
		return $this->db->delete("roles");

	}
	public function ultimoInsert(){
		$this->db->select('MAX(rol_id) AS rol_id');
		$this->db->from('roles');
		$resultado = $this->db->get();
		return $resultado->row();
	}
	public function save_detalle($data){
		$rol_id = $data['rol_det_rol_id'];
		$pant_id = $data['rol_det_pant_id'];
		$this->db->where('rol_det_rol_id', $rol_id);
		$this->db->where('rol_det_pant_id', $pant_id);
		$resultado = $this->db->get('rol_detalles');
		if ($resultado->num_rows()>0) {
			$this->db->where('rol_det_rol_id', $rol_id);
			$this->db->where('rol_det_pant_id', $pant_id);
			$this->db->update('rol_detalles', $data);
		}else{
			$time = time();
			$fechaActual = date("Y-m-d H:i:s",$time);
			$this->db->set('rol_det_fecha_creacion', $fechaActual);
			return $this->db->insert("rol_detalles", $data);

		}
	}
	public function getDetalleRol($id_rol){
		$this->db->select('p.pant_descripcion,p.pant_id, (CASE WHEN  rd.rol_det_insertar = 0 THEN "NO" ELSE "SI" END) insercion, (CASE WHEN  rd.rol_det_actualizar = 0 THEN "NO" ELSE "SI" END) actualizacion , (CASE WHEN  rd.rol_det_borrar = 0 THEN "NO" ELSE "SI" END) borrado,(CASE WHEN  rd.rol_det_visualizar = 0 THEN "NO" ELSE "SI" END) visualizacion, m.mod_descripcion');
		$this->db->from('rol_detalles rd');
		$this->db->join('pantallas p', 'p.pant_id = rd.rol_det_pant_id');
		$this->db->join('modulos m', 'm.mod_id = p.pant_mod_id');
		$this->db->where('rol_det_rol_id', $id_rol);
		$resultado = $this->db->get();
		if($resultado->num_rows()>0){
			return $resultado->result();
		}else{
			return false;
		}
	}
}