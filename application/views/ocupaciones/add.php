<?php $this->layout('v_master')?>
<?php $this->start('contenido')?>
<?php $CI =& get_instance(); ?>
<div class="card">
	<div class="card-header">
		<h4>Agregar Ocupacion</h4>
	</div>
	<div class="card-body">
		<form id="frm_ocupacion" data-parsley-validate="" class="" action="" method="POST">
			<div class="row">
				<div class="col-md-4 offset-3">
					<label for="NumOcupacion">Código Ocupacion<span class="required">*</span></label>
					<div class="input-group">
						<input type="text" class="form-control" id="NumOcupacion" name="NumOcupacion" readonly value="<?php echo $maximo->MAXIMO;?>">
					</div>	
				</div>
			</div>
			<div class="row">
				<div class="col-md-4 offset-3">
					<label class="" for="desOcupacion">Ocupacion <span class="required">*</span></label>
					<div class="input-group">
						<input type="text" id="desOcupacion" placeholder="Descripcion" font style="text-transform: uppercase;" onkeyup="javascript:this.value = this.value.toUpperCase ();"   name="desOcupacion" class="form-control">
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-4 offset-3">
					<label class="" for="desOcupacion">Estado <span class="required">*</span></label>
					<select class="form-control" name="estado" id="estado">
						<option value="1">Activo</option>
						<option value="2">Inactivo</option>
					</select>
				</div>
			</div>
			<hr>
			<div class="row">
				<!-- <div class="form-group"> -->
					<div class="col-md-6 col-sm-6 col-xs-12 offset-3">
						<button type="button" onclick="history.back()" class="btn btn-primary">Cancelar</button>
						<button type="submit" class="btn btn-success">Guardar</button>
					</div>
					<!-- </div> -->

				</div>
			</form>
		</div>

	</div>
	<?php $this->stop()?>
	<?php $this->push('scripts')?>
	<script type="text/javascript">

		$("#frm_ocupacion").submit(function(event) {
			event.preventDefault();		
			var formDato = $(this).serialize();
			$.ajax({
				url: "<?php echo base_url()?>store_ocupacion",
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
					window.location = "<?php echo base_url()?>ocupaciones";
				}
			}).fail(function() {
				alert("Se produjo un error, contacte con el soporte técnico");
			});
		})

	</script>
	<?php $this->end()?>

	<!-- /.modal -->
