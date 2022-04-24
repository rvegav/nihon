<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mascotas_model extends CI_Model {
	//estos son metodos q tienen q ver con bd
	
	//este metodo es para mostrar todos los empleado
	public function getMascotas($id = false, $duenho = false){
		$this->db->select('m.mas_id, m.mas_nombre , m.mas_estado, CONCAT(p.per_nombre, " ", p.per_apellido) mas_nombre_duenho,DATE_FORMAT(m.mas_fecha_nacimiento,"%d/%m/%Y")  mas_fecha_nacimiento, m.mas_fecha_nacimiento mas_fecha_nacimiento_sin, DATE_FORMAT(m.mas_fecha_creacion,"%d/%m/%Y")  mas_fecha_creacion, DATE_FORMAT(m.mas_fecha_modificacion,"%d/%m/%Y") mas_fecha_modificacion, raz_descripcion mas_raza, esp_descripcion mas_especie, mas_clie_id, mas_raz_id');
		$this->db->from("mascotas m");
		$this->db->join('clientes cl', 'cl.clie_id = m.mas_clie_id');
		$this->db->join('personas p', 'p.per_id = cl.clie_per_id');
		$this->db->join('razas r', 'r.raz_id = mas_raz_id');
		$this->db->join('especies e', 'e.esp_id = r.raz_esp_id');
		if ($id) {
			$this->db->where('m.mas_id', $id);
		}
		if ($duenho) {
			$this->db->where('mas_clie_id', $duenho);
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
		return $this->db->insert("mascotas", $data);
	}
	
	//esto es para actualizar los empleado
	public function update($id, $data){
		$this->db->where("mas_id", $id);
		return $this->db->update("mascotas", $data);

	}

	public function delete($id){
		$this->db->set('mas_estado', 2);
		$this->db->where("mas_id", $id);
		return $this->db->update("mascotas");
	}

	public function validarExiste($descripcion, $prov_id){
	    $this->db->select("mas_id");
		$this->db->from("mascotas");
		$this->db->where("mas_descripcion", $descripcion);
		$this->db->where('mas_prov_id', $prov_id);
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
	    $this->db->select("(CASE WHEN  max(mas_id) IS NULL THEN '01' when (max(mas_id) + 1) <= 9 then concat('0',(max(mas_id) + 1)) ELSE max(mas_id) + 1 END) as MAXIMO");
		$this->db->from("mascotas");
		$resultado= $this->db->get();
		return $resultado->row();
	}
}