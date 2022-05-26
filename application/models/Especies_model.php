<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Especies_model extends CI_Model {
	//estos son metodos q tienen q ver con bd
	
	//este metodo es para mostrar todos los empleado
	public function getEspecies($id = false, $estado = false){
		$this->db->select('c.esp_id, c.esp_descripcion, c.esp_estado, DATE_FORMAT(c.esp_fecha_creacion,"%d/%m/%Y")  esp_fecha_creacion, DATE_FORMAT(c.esp_fecha_modificacion,"%d/%m/%Y") esp_fecha_modificacion');
		$this->db->from("especies c");
		if ($id) {
			$this->db->where('esp_id', $id);
		}
		if ($estado) {
			$this->db->where('c.esp_estado', $estado);
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
		return $this->db->insert("especies", $data);
	}
	
	//esto es para actualizar los empleado
	public function update($id, $data){
		$this->db->where("esp_id", $id);
		return $this->db->update("especies", $data);

	}

	public function delete($id){
		$this->db->set('esp_estado', 2);
		$this->db->where("esp_id", $id);
		return $this->db->update("especies");
	}

	public function validarExiste($descripcion){
	    $this->db->select("esp_id");
		$this->db->from("especies");
		$this->db->where("esp_descripcion", $descripcion);
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
	    $this->db->select("(CASE WHEN  max(esp_id) IS NULL THEN '01' when (max(esp_id) + 1) <= 9 then concat('0',(max(esp_id) + 1)) ELSE max(esp_id) + 1 END) as MAXIMO");
		$this->db->from("especies");
		$resultado= $this->db->get();
		return $resultado->row();
	}
}