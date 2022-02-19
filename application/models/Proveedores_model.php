<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Proveedores_model extends CI_Model {
	//estos son metodos q tienen q ver con bd
	
	//este metodo es para mostrar todos los empleado
	public function getProveedores($id = false){
		$this->db->select("p.prov_id, p.prov_descripcion, p.prov_documento, p.prov_telefono, p.prov_correo, c.ciu_descripcion ciudad, p.prov_fecha_creacion, p.prov_fecha_modificacion, p.prov_estado");
		$this->db->from("proveedores p");
		$this->db->join('ciudades c', 'c.ciu_id = p.prov_ciu_id', 'left');
		if ($id) {
			$this->db->where('prov_id', $id);
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
		return $this->db->insert("proveedores", $data);
	}
	
	//esto es para actualizar los empleado
	public function update($id, $data){
		$this->db->where("ciu_id", $id);
		return $this->db->update("proveedores", $data);

	}

	public function delete($id){
		$this->db->set('ciu_estado', 2);
		$this->db->where("ciu_id", $id);
		return $this->db->update("proveedores");
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
	    $this->db->select("(CASE WHEN  max(prov_id) IS NULL THEN '01' when (max(prov_id) + 1) <= 9 then concat('0',(max(prov_id) + 1)) ELSE max(prov_id) + 1 END) as MAXIMO");
		$this->db->from("proveedores");
		$resultado= $this->db->get();
		return $resultado->row();
	}
}