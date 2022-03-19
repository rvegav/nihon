<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Rol_model extends CI_Model {
	//estos son metodos q tienen q ver con bd
	
	//este metodo es para mostrar todos los empleado
	public function getRoles(){
	//	$this->db->where("estempleado", "1");
		$resultados= $this->db->get("roles");
		return $resultados->result();
	}

	public function getModulos(){
	//	$this->db->where("estempleado", "1");
		$resultados= $this->db->get("modulo");
		return $resultados->result();
	}

	public function getPantallas(){
	//	$this->db->where("estempleado", "1");
		$resultados= $this->db->get("pantalla");
		return $resultados->result();
	}

	public function getPantalla($id){
		$this->db->where("idmodulo", $id);
		$resultados= $this->db->get("pantalla");
		return $resultados->result();
	}
	
	//esta es la parte para guardar en la bd
	public function save($data)
	{
		return $this->db->insert("roles", $data);
	}
	
	//esto es una funcion o metodo para mostrar 1 empleado por id
	public function getRol($id){
		$this->db->select("IDROL,DESCRIPCION,FECGRA");
		$this->db->where("IDROL",$id);
		$resultado= $this->db->get("roles");
		return $resultado->row();
	}
	//esto es para actualizar los empleado
	public function update($id, $data){
		$this->db->where("idrol", $id);
		return $this->db->update("roles", $data);

	}

	public function validarExiste($numRol){
	    $this->db->select("count(*) as cantidad");
		$this->db->from("roles");
		$resultados= $this->db->get();
		return $resultados->result();	
	}
//obtener el ultimo id mas 1
	public function ultimoNumero(){
	    $this->db->select("(CASE WHEN  max(idrol) IS NULL THEN '1' ELSE max(idrol) + 1 END) as MAXIMO");
		$this->db->from("roles");
		$resultado= $this->db->get();
		return $resultado->row();
	}

	public function ObtenerCodigo(){
	    $this->db->select("(CASE WHEN  max(idrol) IS NULL THEN '01' when (max(idrol) + 1) <= 9 then concat('0',(max(idrol) + 1)) ELSE max(idrol) + 1 END) as MAXIMO");
		$this->db->from("roles");
		$resultado= $this->db->get();
		return $resultado->result();
	}

	public function delete($id){
		$this->db->where("idrol", $id);
		$this->db->delete("permisos");
		$this->db->where("idrol", $id);
		return $this->db->delete("roles");

	}
	public function ultimoInsert(){
		$this->db->select('MAX(idrol) AS IDROL');
		$this->db->from('roles');
		$resultado = $this->db->get();
		return $resultado->row();
	}

}