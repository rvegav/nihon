<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ocupacion_model extends CI_Model {
	//estos son metodos q tienen q ver con bd
	
	//este metodo es para mostrar todos los empleado
	public function getOcupaciones($id = false){
		$this->db->select('o.ocu_id, o.ocu_descripcion, o.ocu_estado, DATE_FORMAT(o.ocu_fecha_creacion,"%d/%m/%Y")  ocu_fecha_creacion, DATE_FORMAT(o.ocu_fecha_modificacion,"%d/%m/%Y") ocu_fecha_modificacion');
		$this->db->from("ocupaciones o");
		if ($id) {
			$this->db->where('ocu_id', $id);
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
		return $this->db->insert("ocupaciones", $data);
	}
	
	//esto es para actualizar los empleado
	public function update($id, $data){
		$this->db->where("ocu_id", $id);
		return $this->db->update("ocupaciones", $data);

	}

	public function delete($id){
		$this->db->set('ocu_estado', 2);
		$this->db->where("ocu_id", $id);
		return $this->db->update("ocupaciones");
	}

	public function validarExiste($descripcion){
	    $this->db->select("ocu_id");
		$this->db->from("ocupaciones");
		$this->db->where("ocu_descripcion", $descripcion);
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
	    $this->db->select("(CASE WHEN  max(ocu_id) IS NULL THEN '01' when (max(ocu_id) + 1) <= 9 then concat('0',(max(ocu_id) + 1)) ELSE max(ocu_id) + 1 END) as MAXIMO");
		$this->db->from("ocupaciones");
		$resultado= $this->db->get();
		return $resultado->row();
	}
}