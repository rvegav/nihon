<?php $this->layout('v_master')?>
<?php $this->start('contenido')?>
<?php $CI =& get_instance(); ?>
<div class="card">
	<div class="card-header">
		<h4>Historial de Consultas</h4>
	</div>
	<div class="card-body">
		<form id="frm_atencion" data-parsley-validate="" class="" action="" method="POST">
			<table class="table table-striped">
				<tbody>
					<tr>
						<th>Cliente</th>
						<td><?php echo $mascota->mas_nombre_duenho ?></td>
					</tr>
					<tr>
						<th>Paciente</th>
						<td><?php echo $mascota->mas_nombre ?></td>
					</tr>
					<tr>
						<th>Edad</th>
						<td><?php echo $edad ?></td>
					</tr>
					<tr>
						<th>Raza</th>
						<td><?php echo $mascota->mas_raza ?></td>
					</tr>
					<tr>
						<th>Especie</th>
						<td><?php echo $mascota->mas_especie ?></td>
					</tr>
					<tr>
						<th>Fecha de Nacimiento</th>
						<td><?php echo $mascota->mas_fecha_nacimiento ?></td>
					</tr>

				</tbody>
			</table>
			<hr>
			<div class="row">
				<div class="col-md-12">
					<h6>Historial de Visitas</h6>
				</div>
				<div class="col-md-12">
					<br>
					<div class="table-responsive">
						<table class="table table-striped" id="tablaProducto" width="100%">
							<thead>
								<th>Item</th>
								<th>Motivo Visita</th>
								<th>Peso</th>
								<th>Edad</th>
								<th>Diagnostico</th>
								<th>Observacion</th>
								<th>Fecha Atencion</th>
								<th>Atendido por</th>
							</thead>
							<tbody>
								<?php if ($agendamientos): ?>
									
									<?php $c=1 ?>
									<?php foreach ($agendamientos as $agendamiento): ?>
										<tr>
											
											<th><?php echo $c ?></th>
											<td><?php echo $agendamiento->age_motivo_agendamiento ?></td>
											<td><?php echo $agendamiento->age_peso ?></td>
											<td><?php echo $agendamiento->age_edad_paciente ?></td>
											<td><?php echo $agendamiento->age_diagnostico ?></td>
											<td><?php echo $agendamiento->age_observacion ?></td>
											<td><?php echo $agendamiento->age_fecha_atencion ?></td>
											<td><?php echo $agendamiento->empl_atencion ?></td>
										</tr>

									<?php endforeach ?>
								<?php endif ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-6 col-sm-6 col-xs-12 offset-5">
					<button type="button" id="volver" class="btn btn-primary">Volver</button>
				</div>
			</div>
		</form>
	</div>

</div>

<?php $this->stop()?>
<?php $this->push('scripts')?>
<script type="text/javascript">
	$('#volver').click(function(){
		let prevUrl = document.referrer;
		window.location = prevUrl;

	})
	
</script>
<?php $this->end()?>

<!-- /.modal -->
