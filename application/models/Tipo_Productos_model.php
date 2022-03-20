<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tipo_Productos_model extends CI_Model {
	//estos son metodos q tienen q ver con bd
	
	//este metodo es para mostrar todos los empleado
	public function getTipoProductos($id = false){
		$this->db->select('tp.tipr_id, tp.tipr_descripcion, tp.tipr_estado, tp.tipr_inventariable,DATE_FORMAT(tp.tipr_fecha_creacion,"%d/%m/%Y")  tipr_fecha_creacion, DATE_FORMAT(tp.tipr_fecha_modificacion,"%d/%m/%Y") tipr_fecha_modificacion');
		$this->db->from("tipo_productos tp");
		if ($id) {
			$this->db->where('tp.tipr_id', $id);
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
		return $this->db->insert("tipo_productos", $data);
	}
	
	//esto es para actualizar los empleado
	public function update($id, $data){
		$this->db->where("tipr_id", $id);
		return $this->db->update("tipo_productos", $data);

	}

	public function delete($id){
		$this->db->set('tipr_estado', 2);
		$this->db->where("tipr_id", $id);
		return $this->db->update("tipo_productos");
	}

	public function validarExiste($descripcion){
	    $this->db->select("tipr_id");
		$this->db->from("tipo_productos");
		$this->db->where("tipr_descripcion", $descripcion);
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
	    $this->db->select("(CASE WHEN  max(tipr_id) IS NULL THEN '01' when (max(tipr_id) + 1) <= 9 then concat('0',(max(tipr_id) + 1)) ELSE max(tipr_id) + 1 END) as MAXIMO");
		$this->db->from("tipo_productos");
		$resultado= $this->db->get();
		return $resultado->row();
	}
}