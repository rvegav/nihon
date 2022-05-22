<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Agendamientos_model extends CI_Model {

	public $variable;

	public function __construct()
	{
		parent::__construct();
		
	}
	public function getAgendamiento($id = false, $empl_id = false, $mas_id = false, $estado = false){
		$this->db->select('a.age_id, a.age_fecha_creacion age_agendamiento, CONCAT(p.per_nombre, " ", p.per_apellido) age_duenho,
			m.mas_nombre age_mascota, CONCAT(pe.per_nombre, " ", pe.per_apellido) age_emp_atencion, a.age_estado, DATE_FORMAT(a.age_fecha_creacion,"%d/%m/%Y") age_fecha_creacion, DATE_FORMAT(a.age_fecha_atencion,"%d/%m/%Y") age_fecha_atencion, a.age_mas_id,c.clie_id, DATE_FORMAT(t.tude_fecha,"%d/%m/%Y") tude_fecha, t.tude_fecha tude_fecha_sin_formato, pr.prod_descripcion, pr.prod_id, t.tude_id, e.empl_id age_emo_id_atencion, a.age_motivo_agendamiento, a.age_edad_paciente, a.age_diagnostico, a.age_observacion, a.age_peso, CONCAT(pe.per_nombre, " ", pe.per_apellido) empl_atencion, c.clie_ruc, a.age_imagen, a.age_mas_id');
		$this->db->from('agendamientos a');
		$this->db->join('mascotas m', 'm.mas_id = a.age_mas_id');
		$this->db->join('clientes c', 'c.clie_id = m.mas_clie_id');
		$this->db->join('personas p', 'p.per_id = c.clie_per_id');
		$this->db->join('turno_detalles t', 't.tude_id = a.age_tude_id');
		$this->db->join('turnos tu', 'tu.tur_id = t.tude_tur_id');
		$this->db->join('productos pr', 'pr.prod_id = tu.tur_prod_id');
		$this->db->join('empleados e', 'a.age_emp_id_atencion = e.empl_id', 'left');
		$this->db->join('personas pe', 'pe.per_id = e.empl_per_id', 'left');
		$this->db->join('empleados em', 'em.empl_id = a.age_emp_id_recepcion', 'left');
		$this->db->join('personas per', 'per.per_id = em.empl_per_id', 'left');
		// $this->db->group_by('a.age_fecha_creacion, CONCAT(p.per_nombre, " ", p.per_apellido),
		// 	m.mas_nombre, CONCAT(pe.per_nombre, " ", pe.per_apellido), a.age_estado, a.age_fecha_atencion,a.age_mas_id, prod_descripcion');
		if ($empl_id) {
			$this->db->where('age_emp_id_atencion', $empl_id);
		}
		if ($id) {
			$this->db->where('age_id', $id);
		}
		if ($mas_id) {
			$this->db->where('mas_id', $mas_id);
		}
		if ($estado) {
			$this->db->where('age_estado', $estado);
		}
		$resultados= $this->db->get();
		if ($resultados->num_rows()>0) {
			if ($id) {
				return $resultados->row();
			}
			return $resultados->result();
		}
	}
	public function ObtenerCodigo(){
		$this->db->select("(CASE WHEN  max(age_id) IS NULL THEN '01' when (max(age_id) + 1) <= 9 then concat('0',(max(age_id) + 1)) ELSE max(age_id) + 1 END) as MAXIMO");
		$this->db->from("agendamientos");
		$resultado= $this->db->get();
		return $resultado->row();
	}
	public function getDisponibilidadTurnos($fecha, $servicio){
		$this->db->select('tude_hora, tude_estado, tude_fecha, tude_id');
		$this->db->from('turno_detalles td');
		$this->db->join('turnos t', 't.tur_id = td.tude_tur_id');
		$this->db->where('t.tur_prod_id', $servicio);
		$this->db->where('td.tude_fecha', $fecha);
		$this->db->group_by('tude_hora, tude_estado, tude_fecha, tude_id');
		$resultados= $this->db->get();
		if ($resultados->num_rows()>0) {
			return $resultados->result();
		}else{
			return false;
		}
	}
	public function getCantTurnos($servicio){
		$this->db->select('(TIMESTAMPDIFF(MINUTE,t.tur_desde_hora,t.tur_hasta_hora) / t.tur_tiempo_aproximado) as cantidad_disponible,t.tur_desde_hora,t.tur_hasta_hora, tur_tiempo_aproximado,t.tur_id');
		$this->db->from('turnos t');
		$this->db->where('t.tur_prod_id', $servicio);
		$resultados= $this->db->get();
		if ($resultados->num_rows()>0) {
			return $resultados->row();
		}else{
			return false;
		}
	}
	public function save($data){
		return $this->db->insert("agendamientos", $data);
	}
	public function update($id, $data){
		$this->db->where('age_id', $id);
		return $this->db->update("agendamientos", $data);
	}
	public function save_detalle($data){
		return $this->db->insert("agendamiento_detalles", $data);
	}
	public function updateDisponibilidad($id, $estado){
		$this->db->set('tude_estado', $estado);
		$this->db->where('tude_id', $id);
		return $this->db->update('turno_detalles');
	}

	public function getDetalleAgendamiento($age_id = false, $tipo_producto = false){
		$this->db->select('prod_id, prod_descripcion, ad.agde_cantidad, p.prod_precio_venta', FALSE);
		$this->db->from('agendamientos a');
		$this->db->join('agendamiento_detalles ad', 'a.age_id = ad.agde_age_id');
		$this->db->join('productos p', 'p.prod_id = ad.agde_prod_id');
		$this->db->join('tipo_productos tp', 'tp.tipr_id = p.prod_tipr_id');
		if ($age_id) {
			$this->db->where('a.age_id', $age_id);
		}
		if ($tipo_producto) {
			$this->db->where('tp.tipr_inventariable', $tipo_producto);
			
		}
		$resultados= $this->db->get();
		if ($resultados->num_rows()>0) {
			return $resultados->result();
		}else{
			return false;
		}
	}
	public function modificaEstado(){
		$this->db->where('tude_fecha <', 'sysdate()', false);
		$this->db->where('age_estado', 1);
		$this->db->select('age_id');
		$this->db->from('agendamientos');
		$this->db->join('turno_detalles', 'age_tude_id = tude_id');
		$consulta = $this->db->get();
		$array=array();
		foreach ($consulta->result() as $resultado) {
			$array[]=$resultado->age_id;
		}
		if (count($array)>0 ) {
			$this->db->where_in('age_id', $array );
			$this->db->set('age_estado', 4);
			return $this->db->update('agendamientos');
			
		}else{
			return false;
		}
	}
}

/* End of file Agendamientos_model.php */
/* Location: ./application/models/Agendamientos_model.php */