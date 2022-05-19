<?php $this->layout('v_master')?>
<?php $this->start('contenido')?>
<?php $CI =& get_instance(); ?>
<div class="card">
	<div class="card-header">
		<h4>Editar Especie</h4>
	</div>
	<div class="card-body">
		<form id="frm_ciudad" data-parsley-validate="" class="" action="" method="POST">
			<div class="row">
				<div class="col-md-4 offset-3">
					<label for="NumCiudad">Código Especie<span class="required">*</span></label>
					<div class="input-group">
						<input type="text" class="form-control" id="NumCiudad" name="NumCiudad" readonly value="<?php echo $especie->esp_id ?>">
					</div>	
				</div>
			</div>
			<div class="row">
				<div class="col-md-4 offset-3">
					<label class="" for="desEspecie">Especie <span class="required">*</span></label>
					<div class="input-group">
						<input type="text" id="desEspecie" placeholder="Descripcion" font style="text-transform: uppercase;" onkeyup="javascript:this.value = this.value.toUpperCase ();"   name="desEspecie" class="form-control" value="<?php echo $especie->esp_descripcion ?>">
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-4 offset-3">
					<?php
					$estado = $especie->esp_estado;
					if($estado == 1){
						$estado2     = "Activo";$label_class = 'label-success';
					}else{
						if($estado == 2){
							$estado2     = "Inactivo";$label_class = 'label-warning';
						}else{
							$estado2     = "Anulado";$label_class = 'label-danger';
						}
					}
					;?>
					<label class="" for="">Estado <span class="required">*</span></label>
					<select class="form-control" style="width: 100%;" name="estado" id="estado">
						<optgroup label="Estado Actual"></optgroup>
						<option value="<?php echo $especie->esp_estado ?>"><?php echo $estado2 ?></option>
						<optgroup label="Estado a Asignar"></optgroup>
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

		$("#frm_ciudad").submit(function(event) {
			event.preventDefault();		
			var formDato = $(this).serialize();
			$.ajax({
				url: "<?php echo base_url()?>update_especie",
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
					swal({
						title: 'Atención!', 
						content: wrapper,
						icon: "warning",
						columnClass: 'medium',
					});
				}
				if (r['error']!="") {
					wrapper.innerHTML = r['error'];
					swal({
						icon: "error",
						columnClass: 'medium',
						theme: 'modern',
						title: 'Error!',
						content: wrapper,
					});
				}
				if (r['correcto']!="") {
					window.location = "<?php echo base_url()?>especies";
				}
			}).fail(function() {
				alert("Se produjo un error, contacte con el soporte técnico");
			});
		})

	</script>
	<?php $this->end()?>

	<!-- /.modal -->
