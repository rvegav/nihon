<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Turnos_model extends CI_Model {
	//estos son metodos q tienen q ver con bd
	
	//este metodo es para mostrar todos los empleado
	public function getTurnos($id = false){
		$this->db->select('tur_id, tur_descripcion, tur_desde_hora, tur_hasta_hora, tur_tiempo_aproximado, DATE_FORMAT(tur_fecha_creacion,"%d/%m/%Y")  tur_fecha_creacion, DATE_FORMAT(tur_fecha_modificacion,"%d/%m/%Y") tur_fecha_modificacion, tur_estado, tur_prod_id, prod_descripcion');
		$this->db->from("turnos t");
		$this->db->join('productos p', 'p.prod_id = t.tur_prod_id');
		if ($id) {
			$this->db->where('tur_id', $id);
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
		return $this->db->insert("turnos", $data);
	}
	
	//esto es para actualizar los empleado
	public function update($id, $data){
		$this->db->where("tur_id", $id);
		return $this->db->update("turnos", $data);

	}

	public function delete($id){
		$this->db->set('tur_estado', 2);
		$this->db->where("tur_id", $id);
		return $this->db->update("turnos");
	}

	public function validarExiste($prod_id){
	    $this->db->select("tur_id");
		$this->db->from("turnos");
		$this->db->where("tur_prod_id", $prod_id);
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
	    $this->db->select("(CASE WHEN  max(tur_id) IS NULL THEN '01' when (max(tur_id) + 1) <= 9 then concat('0',(max(tur_id) + 1)) ELSE max(tur_id) + 1 END) as MAXIMO");
		$this->db->from("turnos");
		$resultado= $this->db->get();
		return $resultado->row();
	}
	public function insertDetalle($data){
		return $this->db->insert("turno_detalles", $data);
	}
}