<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ciudad_model extends CI_Model {
	//estos son metodos q tienen q ver con bd
	
	//este metodo es para mostrar todos los empleado
	public function getCiudades($id = false){
		$this->db->select("c.ciu_id, c.ciu_descripcion, c.ciu_estado, c.ciu_fecha_creacion, c.ciu_fecha_modificacion");
		$this->db->from("ciudades c");
		if ($id) {
			$this->db->where('ciu_id', $id);
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
		return $this->db->insert("ciudades", $data);
	}
	
	//esto es para actualizar los empleado
	public function update($id, $data){
		$this->db->where("ciu_id", $id);
		return $this->db->update("ciudades", $data);

	}

	public function delete($id){
		$this->db->set('ciu_estado', 2);
		$this->db->where("ciu_id", $id);
		return $this->db->update("ciudades");
	}

	public function validarExiste($numCiudad){
	    $this->db->select("count(*) as cantidad");
		$this->db->from("ciudad");
		$resultados= $this->db->get();
		return $resultados->result();	
	}
	public function ultimoNumero(){
	    $this->db->select("(CASE WHEN  max(idciudad) IS NULL THEN '1' ELSE max(idciudad) + 1 END) as MAXIMO");
		$this->db->from("ciudad");
		$resultado= $this->db->get();
		return $resultado->row();
	}

	public function ObtenerCodigo(){
	    $this->db->select("(CASE WHEN  max(ciu_id) IS NULL THEN '01' when (max(ciu_id) + 1) <= 9 then concat('0',(max(ciu_id) + 1)) ELSE max(ciu_id) + 1 END) as MAXIMO");
		$this->db->from("ciudades");
		$resultado= $this->db->get();
		return $resultado->row();
	}
}