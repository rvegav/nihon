<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Razas_model extends CI_Model {
	//estos son metodos q tienen q ver con bd
	
	//este metodo es para mostrar todos los empleado
	public function getRazas($id = false, $estado = false){
		$this->db->select('r.raz_id, r.raz_descripcion, r.raz_estado, DATE_FORMAT(r.raz_fecha_creacion,"%d/%m/%Y") raz_fecha_creacion, DATE_FORMAT(r.raz_fecha_modificacion,"%d/%m/%Y") raz_fecha_modificacion, e.esp_descripcion raz_especie, raz_esp_id');
		$this->db->from("razas r");
		$this->db->join('especies e', 'e.esp_id = r.raz_esp_id');
		if ($id) {
			$this->db->where('raz_id', $id);
		}
		if ($estado) {
			$this->db->where('raz_estado', $estado);
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
		return $this->db->insert("razas", $data);
	}
	
	//esto es para actualizar los empleado
	public function update($id, $data){
		$this->db->where("raz_id", $id);
		return $this->db->update("razas", $data);

	}

	public function delete($id){
		$this->db->set('raz_estado', 2);
		$this->db->where("raz_id", $id);
		return $this->db->update("razas");
	}

	public function validarExiste($descripcion){
	    $this->db->select("raz_id");
		$this->db->from("razas");
		$this->db->where("raz_descripcion", $descripcion);
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
	    $this->db->select("(CASE WHEN  max(raz_id) IS NULL THEN '01' when (max(raz_id) + 1) <= 9 then concat('0',(max(raz_id) + 1)) ELSE max(raz_id) + 1 END) as MAXIMO");
		$this->db->from("razas");
		$resultado= $this->db->get();
		return $resultado->row();
	}
}