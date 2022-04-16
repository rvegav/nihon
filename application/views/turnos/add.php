<?php $this->layout('v_master')?>
<?php $this->start('contenido')?>
<?php $CI =& get_instance(); ?>
<div class="card">
	<div class="card-header">
		<h4>Agregar Turno</h4>
	</div>
	<div class="card-body">
		<form id="frm_ciudad" data-parsley-validate="" class="" action="" method="POST">
			<div class="row">
				<div class="col-md-4 offset-3">
					<label for="NumTurno">Código Turno<span class="required">*</span></label>
					<div class="input-group">
						<input type="text" class="form-control" id="NumTurno" name="NumTurno" readonly value="<?php echo $maximo->MAXIMO;?>">
					</div>	
				</div>
			</div>
			<div class="row">
				<div class="col-md-4 offset-3">
					<label class="" for="desTurno">Descripcion <span class="required">*</span></label>
					<div class="input-group">
						<input type="text" id="desTurno" placeholder="Descripcion" font style="text-transform: uppercase;" onkeyup="javascript:this.value = this.value.toUpperCase ();"   name="desTurno" class="form-control">
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-4 offset-3">
					<label class="" for="hora_desde">Hora Desde <span class="required">*</span></label>
					<div class="input-group">
						<input  class="form-control" type="time" id="hora_desde" name="hora_desde" min="08:00" max="18:00" required>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-4 offset-3">
					<label class="" for="hora_hasta">Hora Hasta <span class="required">*</span></label>
					<div class="input-group">
						<input  class="form-control" type="time" id="hora_hasta" name="hora_hasta" min="08:00" max="18:00" required>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-4 offset-3">
					<label class="" for="tiempo_aprox">Tiempo Aprox. Minutos <span class="required">*</span></label>
					<div class="input-group">
						<input type="text" id="tiempo_aprox" placeholder="Tiempo Aprox. Minutos" font style="text-transform: uppercase;" onkeyup="javascript:this.value = this.value.toUpperCase ();"   name="tiempo_aprox" class="form-control">
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-md-4 offset-3">
					<label class="" for="desCiudad">Estado <span class="required">*</span></label>
					<select class="form-control" name="estado" id="estado">
						<option value="1">Activo</option>
						<option value="2">Inactivo</option>
					</select>
				</div>
			</div>
			<hr>
			<div class="row">
				<div class="col-md-6 col-sm-6 col-xs-12 offset-3">
					<button type="reset" class="btn btn-primary">Resetear</button>
					<button type="submit" class="btn btn-success">Guardar</button>
				</div>
			</div>
		</form>
	</div>

</div>
<?php $this->stop()?>
<?php $this->push('scripts')?>
<script type="text/javascript">

	$("#frm_ciudad").submit(function(event) {
		event.preventDefault();		
		var formDato = $(this).serialize();
		$.ajax({
			url: "<?php echo base_url()?>store_turno",
			type: 'POST',
			data: formDato
		})
		.done(function(result) {
			var r = JSON.parse(result);
			console.log(r);
			const wrapper = document.createElement('div');
			if (r['alerta']!="") {
				var mensaje = r['alerta'];
				wrapper.innerHTML = mensaje;
				swal.fire({
					title: 'Atención!', 
					html: wrapper,
					icon: "warning",
					columnClass: 'medium',
				});
			}
			if (r['error']!="") {
				wrapper.innerHTML = r['error'];
				swal.fire({
					icon: "error",
					columnClass: 'medium',
					theme: 'modern',
					title: 'Error!',
					html: wrapper,
				});
			}
			if (r['correcto']!="") {
				window.location = "<?php echo base_url()?>turnos";
			}
		}).fail(function() {
			alert("Se produjo un error, contacte con el soporte técnico");
		});
	})

</script>
<?php $this->end()?>

<!-- /.modal -->
