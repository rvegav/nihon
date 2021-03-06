<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ventas_model extends CI_Model {
	//estos son metodos q tienen q ver con bd
	
	//este metodo es para mostrar todos los empleado
	public function getVentas($id = false){
		$this->db->select('CONCAT(p.per_nombre, " ", p.per_apellido) clie_nombre, DATE_FORMAT(v.ven_fecha_creacion,"%d/%m/%Y") ven_fecha_venta, sum(pr.prod_precio_venta * vd.vede_cantidad) ven_total_venta, (CASE WHEN  v.ven_forma_pago = "E" THEN "EFECTIVO" when v.ven_forma_pago = "T" then "TARJETA" END) as ven_forma_pago, ven_razon_social, ven_ruc, ven_id');
		$this->db->from('ventas v');
		$this->db->join('clientes c ', 'c.clie_id  = v.ven_clie_id');
		$this->db->join('personas p', 'p.per_id = c.clie_per_id');
		$this->db->join('venta_detalles vd', 'vd.vede_ven_id = v.ven_id');
		$this->db->join('productos pr', 'pr.prod_id = vd.vede_prod_id', 'left');
		$this->db->group_by('CONCAT(p.per_nombre, " ", p.per_apellido), v.ven_fecha_creacion, v.ven_forma_pago, ven_razon_social, ven_ruc, ven_id');
		if ($id) {
			$this->db->where('v.ven_id', $id);
		}
		$resultados= $this->db->get();
		if ($resultados->num_rows()>0) {
			if ($id) {
				return $resultados->row();
			}
			return $resultados->result();
		}
	}
	public function getDetalleVenta($id_venta){
		$this->db->select('p.prod_descripcion, vd.vede_cantidad, p.prod_id, p.prod_precio_venta', FALSE);
		$this->db->from('venta_detalles vd');
		$this->db->join('productos p', 'vd.vede_prod_id = p.prod_id');
		$this->db->where('vede_ven_id', $id_venta);
		$resultados= $this->db->get();
		if ($resultados->num_rows()>0) {
			return $resultados->result();
		}
	}
	
	//esta es la parte para guardar en la bd
	public function save($data)
	{
		return $this->db->insert("ventas", $data);
	}

	public function save_detalle($data){
		return $this->db->insert("venta_detalles", $data);
	}
	
	//esto es para actualizar los empleado
	public function update($id, $data){
		$this->db->where("ven_id", $id);
		return $this->db->update("ventas", $data);

	}

	public function getUltimoInsert($cliente, $razon_social, $ruc){
		$this->db->select_max('ven_id', 'ven_id');
		$this->db->from('ventas');
		$this->db->where('ven_clie_id', $cliente);
		$this->db->where('ven_razon_social', $razon_social);
		$this->db->where('ven_ruc', $ruc);
		$resultados= $this->db->get();
		if ($resultados->num_rows()>0) {
			return $resultados->row();
		}
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