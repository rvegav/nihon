<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Personas_model extends CI_Model {
	//estos son metodos q tienen q ver con bd
	
	//este metodo es para mostrar todos los empleado
	public function getPersonas($id = false, $estado = false){
		$this->db->select('p.per_id, p.per_nombre, p.per_apellido, p.per_nro_doc,p.per_fecha_nacimiento,  p.per_tipo_doc, p.per_direccion, p.per_telefono, p.per_correo, c.ciu_id,c.ciu_descripcion, p.per_estado, DATE_FORMAT(p.per_fecha_creacion,"%d/%m/%Y") per_fecha_creacion, DATE_FORMAT(p.per_fecha_modificacion,"%d/%m/%Y") per_fecha_modificacion');
		$this->db->from("personas p");
		$this->db->join('ciudades c', 'p.per_ciu_id = c.ciu_id', 'left');
		if ($id) {
			$this->db->where('per_id', $id);
		}
		if ($estado) {
			$this->db->where('p.per_estado', $estado);
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
		return $this->db->insert("personas", $data);
	}
	
	//esto es para actualizar los empleado
	public function update($id, $data){
		$this->db->where("per_id", $id);
		return $this->db->update("personas", $data);

	}

	public function delete($id){
		$this->db->set('per_estado', 2);
		$this->db->where("per_id", $id);
		return $this->db->update("personas");
	}

	public function validarExiste($descripcion){
	    $this->db->select("per_id");
		$this->db->from("personas");
		$this->db->where("per_descripcion", $descripcion);
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
	    $this->db->select("(CASE WHEN  max(per_id) IS NULL THEN '01' when (max(per_id) + 1) <= 9 then concat('0',(max(per_id) + 1)) ELSE max(per_id) + 1 END) as MAXIMO");
		$this->db->from("personas");
		$resultado= $this->db->get();
		return $resultado->row();
	}
}