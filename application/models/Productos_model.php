<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Productos_model extends CI_Model {
	//estos son metodos q tienen q ver con bd
	
	//este metodo es para mostrar todos los empleado
	public function getProductos($id = false, $inventariable = false){
		$this->db->select('p.prod_id, p.prod_descripcion, p.prod_estado, p.prod_marca, DATE_FORMAT(p.prod_fecha_creacion,"%d/%m/%Y")  prod_fecha_creacion, DATE_FORMAT(p.prod_fecha_modificacion,"%d/%m/%Y") prod_fecha_modificacion, pr.prov_descripcion, pr.prov_id, tp.tipr_id, tp.tipr_descripcion, p.prod_precio_venta, p.prod_precio_compra');
		$this->db->from("productos p");
		$this->db->join('proveedores pr', 'pr.prov_id = p.prod_prov_id', 'left');
		$this->db->join('tipo_productos tp', 'tp.tipr_id = prod_tipr_id', 'left');
		if ($id) {
			$this->db->where('p.prod_id', $id);
		}
		if ($inventariable) {
			$this->db->where('tp.tipr_inventariable', $inventariable);
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
		return $this->db->insert("productos", $data);
	}
	
	//esto es para actualizar los empleado
	public function update($id, $data){
		$this->db->where("prod_id", $id);
		return $this->db->update("productos", $data);

	}

	public function delete($id){
		$this->db->set('prod_estado', 2);
		$this->db->where("prod_id", $id);
		return $this->db->update("productos");
	}

	public function validarExiste($descripcion, $prov_id){
	    $this->db->select("prod_id");
		$this->db->from("productos");
		$this->db->where("prod_descripcion", $descripcion);
		$this->db->where('prod_prov_id', $prov_id);
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
	    $this->db->select("(CASE WHEN  max(prod_id) IS NULL THEN '01' when (max(prod_id) + 1) <= 9 then concat('0',(max(prod_id) + 1)) ELSE max(prod_id) + 1 END) as MAXIMO");
		$this->db->from("productos");
		$resultado= $this->db->get();
		return $resultado->row();
	}
}