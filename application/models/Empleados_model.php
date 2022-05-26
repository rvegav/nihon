<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Empleados_model extends CI_Model {
	//estos son metodos q tienen q ver con bd
	
	//este metodo es para mostrar todos los empleado
	public function getEmpleados($id = false, $estado = false, $ocupacion = false){
		$this->db->select('e.empl_id, CONCAT(p.per_nombre, " ", p.per_apellido) empl_nombre, e.empl_per_id, o.ocu_descripcion empl_ocupacion, e.empl_ocu_id, e.empl_estado, DATE_FORMAT(e.empl_fecha_creacion,"%d/%m/%Y") empl_fecha_creacion, DATE_FORMAT(e.empl_fecha_modificacion,"%d/%m/%Y") empl_fecha_modificacion, per_nro_doc empl_nro_doc');
		$this->db->from("empleados e");
		$this->db->join('personas p', 'p.per_id = e.empl_per_id');
		$this->db->join('ocupaciones o', 'o.ocu_id = e.empl_ocu_id');
		if ($id) {
			$this->db->where('empl_id', $id);
		}
		if ($estado) {
			$this->db->where('empl_estado', $estado);
		}
		if ($ocupacion) {
			$this->db->where('ocu_descripcion', $ocupacion);
		}
		$resultados= $this->db->get();
		if ($resultados->num_rows()>0) {
			if ($id) {
				return $resultados->row();
			}
			return $resultados->result();
		}
	}
	
	//esta es la parte para guardar en la bd
	public function save($data)
	{
		return $this->db->insert("empleados", $data);
	}
	
	//esto es para actualizar los empleado
	public function update($id, $data){
		$this->db->where("empl_id", $id);
		return $this->db->update("empleados", $data);

	}

	public function delete($id){
		$this->db->set('empl_estado', 2);
		$this->db->where("empl_id", $id);
		return $this->db->update("empleados");
	}

	public function validarExiste($descripcion){
	    $this->db->select("empl_id");
		$this->db->from("empleados");
		$this->db->where("empl_descripcion", $descripcion);
		$resultados= $this->db->get();
		if($resultados->num_rows()>0){
			return true;
		}else{
			return false;
		}
	}
	public function ultimoNumero(){
	    $this->db->select("(CASE WHEN  max(idciudad) IS NULL THEN '1' ELSE max(idciudad) + 1 END) as MAXIMO");
		$this->db->from("ciudad");
		$resultado= $this->db->get();
		return $resultado->row();
	}

	public function ObtenerCodigo(){
	    $this->db->select("(CASE WHEN  max(empl_id) IS NULL THEN '01' when (max(empl_id) + 1) <= 9 then concat('0',(max(empl_id) + 1)) ELSE max(empl_id) + 1 END) as MAXIMO");
		$this->db->from("empleados");
		$resultado= $this->db->get();
		return $resultado->row();
	}
}