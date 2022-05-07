<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Control_Stock_model extends CI_Model {
	//estos son metodos q tienen q ver con bd
	
	//este metodo es para mostrar todos los empleado
	public function getInventarios($id = false, $prod_id = false){
		$this->db->select('i.inve_id, p.prod_id,  i.inve_cantidad_minima, i.inve_cantidad, p.prod_descripcion,p.prod_precio_compra, p.prod_precio_venta , DATE_FORMAT(i.inve_fecha_modificacion,"%d/%m/%Y") inve_fecha_modificacion, p.prod_marca, tp.tipr_descripcion, pr.prov_descripcion');
		$this->db->from("inventarios i");
		$this->db->join('productos p', 'p.prod_id = i.inve_prod_id');
		$this->db->join('tipo_productos tp', 'tp.tipr_id = p.prod_tipr_id');
		$this->db->join('proveedores pr', 'pr.prov_id = p.prod_prov_id');
		if ($id) {
			$this->db->where('inve_id', $id);
		}
		if ($prod_id) {
			$this->db->where('prod_id', $prod_id);
		}
		$resultados= $this->db->get();
		if ($resultados->num_rows()>0) {
			if ($id || $prod_id) {
				return $resultados->row();
			}
			return $resultados->result();
		}
	}
	
	//esta es la parte para guardar en la bd
	public function save($data)
	{
		return $this->db->insert("inventarios", $data);
	}
	
	//esto es para actualizar los empleado
	public function update($id, $data){
		$this->db->where("inve_id", $id);
		return $this->db->update("inventarios", $data);

	}

	public function validarExiste($descripcion){
	    $this->db->select("inve_id");
		$this->db->from("inventarios");
		$this->db->where("prov_descripcion", $descripcion);
		$resultados= $this->db->get();
		if($resultados->num_rows()>0){
			return true;
		}else{
			return false;
		}
	}
	public function ultimoNumero(){
	    $this->db->select("(CASE WHEN  max(inve_id) IS NULL THEN '1' ELSE max(inve_id) + 1 END) as MAXIMO");
		$this->db->from("inventarios");
		$resultado= $this->db->get();
		return $resultado->row();
	}

	public function ObtenerCodigo(){
	    $this->db->select("(CASE WHEN  max(inve_id) IS NULL THEN '01' when (max(inve_id) + 1) <= 9 then concat('0',(max(inve_id) + 1)) ELSE max(inve_id) + 1 END) as MAXIMO");
		$this->db->from("inventarios");
		$resultado= $this->db->get();
		return $resultado->row();
	}
	public function getProductosRevision(){
		$this->db->where('inve_cantidad < inve_cantidad_minima');
		$this->db->from('inventarios');
		$resultado = $this->db->get();
		return $resultado->num_rows();
	}
}