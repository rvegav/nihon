<?php $this->layout('v_master')?>
<?php $this->start('contenido')?>
<?php $CI =& get_instance(); ?>
<div class="card">
	<div class="card-header">
		<h4>Expediente</h4>
	</div>
	<div class="card-body">
		<h5>Detalles del agendamiento</h5>
		<form id="frm_atencion" data-parsley-validate="" class="" action="" method="POST">
			<table class="table table-striped">
				<tbody>
					<tr>
						<th>Cliente</th>
						<td><?php echo $agenda->age_duenho ?></td>
					</tr>
					<tr>
						<th>Paciente</th>
						<td><?php echo $agenda->age_mascota ?></td>
					</tr>
					<tr>
						<th>Edad</th>
						<td><?php echo $agenda->age_edad_paciente ?></td>
					</tr>
					<tr>
						<th>Raza</th>
						<td><?php echo $mascota->mas_raza ?></td>
					</tr>
					<tr>
						<th>Motivo</th>
						<td><?php echo $agenda->age_motivo_agendamiento ?></td>
					</tr>
					<tr>
						<th>Fecha de creación Expediente</th>
						<td><?php echo $agenda->age_fecha_creacion ?></td>
					</tr>

				</tbody>
			</table>
			<input type="hidden" name="age_id" id="age_id" value="<?php echo $agenda->age_id ?>">
			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<label for="peso">Peso</label>
						<textarea disabled id="peso" name="peso" placeholder="Peso del paciente en Kilogramos" class="form-control" style="overflow: hidden; overflow-wrap: break-word; resize: none; height: 58px;"><?php echo $agenda->age_peso ?>KG</textarea>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label for="observacion">Observacion</label>
						<textarea disabled id="observacion" name="observacion" placeholder="Observaciones Adicionales" class="form-control" style="overflow: hidden; overflow-wrap: break-word; resize: none; height: 58px;"><?php echo $agenda->age_observacion ?></textarea>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<div class="form-group">
						<label for="diagnostico">Diagnostico</label>
						<textarea disabled id="diagnostico" name="diagnostico" placeholder="Diagnostico Especifico" class="form-control" style="overflow: hidden; overflow-wrap: break-word; resize: none; height: 58px;"><?php echo $agenda->age_diagnostico ?></textarea>
					</div>
				</div>
			</div>
			<hr>
			<div class="row">
				<div class="col-md-12">
					<h6>Productos</h6>
				</div>
				<div class="col-md-12">
					<br>
					<div class="table-responsive">
						<table class="table table-striped" id="tablaProducto" width="100%">
							<thead>
								<th>Cod. Producto</th>
								<th>Nombre</th>
								<th>Cantidad</th>
							</thead>
							<tbody>
								<?php foreach ($productos as $producto): ?>
									<tr>
										<td><?php echo $producto->prod_id ?></td>
										<td><?php echo $producto->prod_descripcion; ?></td>
										<td><?php echo $producto->agde_cantidad; ?></td>
									</tr>
								<?php endforeach ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
			<br>
			<div class="row">
				<div class="col-md-12">
					<h6>Servicios</h6>
				</div>
				<div class="col-md-12">
					<br>
					<div class="table-responsive">
						<table class="table table-striped" id="tablaServicio" width="100%">
							<thead>
								<th>Cod. Servicio</th>
								<th>Descripcion</th>
							</thead>
							<tbody>
								<?php foreach ($servicios as $servicio): ?>
									<tr>
										<td><?php echo $servicio->prod_id ?></td>
										<td><?php echo $servicio->prod_descripcion; ?></td>
									</tr>
								<?php endforeach ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-6 col-sm-6 col-xs-12 offset-5">
					<button type="reset" id="volver" class="btn btn-primary">Volver</button>
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