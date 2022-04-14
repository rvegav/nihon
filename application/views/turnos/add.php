<?php $this->layout('v_master')?>
<?php $this->start('contenido')?>
<?php $CI =& get_instance(); ?>
<div class="card">
	<div class="card-header">
		<h4>Agregar Ciudad</h4>
	</div>
	<div class="card-body">
		<form id="frm_ciudad" data-parsley-validate="" class="" action="" method="POST">
			<div class="row">
				<div class="col-md-4 offset-3">
					<label for="NumCiudad">Código Rol<span class="required">*</span></label>
					<div class="input-group">
						<input type="text" class="form-control" id="NumCiudad" name="NumCiudad" readonly value="<?php echo $maximo->MAXIMO;?>">
					</div>	
				</div>
			</div>
			<div class="row">
				<div class="col-md-4 offset-3">
					<label class="" for="desCiudad">Descripcion <span class="required">*</span></label>
					<div class="input-group">
						<input type="text" id="desCiudad" placeholder="Descripcion" font style="text-transform: uppercase;" onkeyup="javascript:this.value = this.value.toUpperCase ();"   name="desCiudad" class="form-control">
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
			url: "<?php echo base_url()?>store_ciudad",
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
				window.location = "<?php echo base_url()?>ciudades";
			}
		}).fail(function() {
			alert("Se produjo un error, contacte con el soporte técnico");
		});
	})

</script>
<?php $this->end()?>

<!-- /.modal -->
