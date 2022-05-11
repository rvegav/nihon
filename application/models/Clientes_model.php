<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Clientes_model extends CI_Model {
	//estos son metodos q tienen q ver con bd
	
	//este metodo es para mostrar todos los empleado
	public function getClientes($id = false, $estado = false){
		$this->db->select('c.clie_id, CONCAT(p.per_nombre, " ", p.per_apellido) clie_nombre, c.clie_per_id ,DATE_FORMAT(c.clie_fecha_incorporacion,"%d/%m/%Y") clie_fecha_incorporacion, c.clie_fecha_incorporacion fecha_incorporacion, c.clie_estado, DATE_FORMAT(c.clie_fecha_creacion,"%d/%m/%Y")  clie_fecha_creacion, DATE_FORMAT(c.clie_fecha_modificacion,"%d/%m/%Y") clie_fecha_modificacion, clie_ruc, p.per_nro_doc clie_cedula');
		$this->db->from("clientes c");
		$this->db->join('personas p', 'p.per_id = c.clie_per_id');
		if ($id) {
			$this->db->where('clie_id', $id);
		}
		if ($estado) {
			$this->db->where('clie_estado', $estado);
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
		return $this->db->insert("clientes", $data);
	}
	
	//esto es para actualizar los empleado
	public function update($id, $data){
		$this->db->where("clie_id", $id);
		return $this->db->update("clientes", $data);

	}

	public function delete($id){
		$this->db->set('clie_estado', 2);
		$this->db->where("clie_id", $id);
		return $this->db->update("clientes");
	}

	public function validarExiste($descripcion){
	    $this->db->select("clie_id");
		$this->db->from("clientes");
		$this->db->where("clie_descripcion", $descripcion);
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
	    $this->db->select("(CASE WHEN  max(clie_id) IS NULL THEN '01' when (max(clie_id) + 1) <= 9 then concat('0',(max(clie_id) + 1)) ELSE max(clie_id) + 1 END) as MAXIMO");
		$this->db->from("clientes");
		$resultado= $this->db->get();
		return $resultado->row();
	}
}