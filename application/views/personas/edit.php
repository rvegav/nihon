<?php $this->layout('v_master')?>
<?php $this->start('contenido')?>
<?php $CI =& get_instance(); ?>
<div class="card">
	<div class="card-header">
		<h4>Editar Persona</h4>
	</div>
	<div class="card-body">
		<form id="frm_persona" data-parsley-validate="" class="" action="" method="POST">
			<!-- <input type="hidden" name="persona_id" value="<?php echo $persona->per_id ?>"> -->
			<div class="row">
				<div class="col-md-3 offset-5">
					<label for="NumCiudad">C�digo Persona<span class="required">*</span></label>
					<div class="input-group">
						<input type="text" class="form-control" id="persona_id" name="persona_id" readonly value="<?php echo $persona->per_id;?>">
					</div>	
				</div>
			</div>
			<div class="row">
				<div class="col-md-3">
					<label class="" for="desCiudad">Nombre <span class="required">*</span></label>
					<div class="input-group">
						<input value ="<?php echo $persona->per_nombre ?>" type="text" id="nombre" placeholder="Nombre" font style="text-transform: uppercase;" onkeyup="javascript:this.value = this.value.toUpperCase ();"   name="nombre" class="form-control">
					</div>
				</div>
				<div class="col-md-3">
					<label class="" for="desCiudad">Apellido <span class="required">*</span></label>
					<div class="input-group">
						<input value ="<?php echo $persona->per_apellido ?>" type="text" id="apellido" placeholder="Apellido" font style="text-transform: uppercase;" onkeyup="javascript:this.value = this.value.toUpperCase ();"   name="apellido" class="form-control">
					</div>
				</div>
				<div class="col-md-3">
					<label class="" for="desCiudad">Tipo de Documento <span class="required">*</span></label>
					<select class="form-control" name="tipo_doc" id="tipo_doc">
						<option value="C">CEDULA</option>
						<option value="R">Ruc</option>
					</select>
				</div>
				<div class="col-md-3">
					<label for="NumCiudad">Documento<span class="required">*</span></label>
					<div class="input-group">
						<input value ="<?php echo $persona->per_nro_doc ?>" type="text" class="form-control" id="nro_doc" name="nro_doc" placeholder="Documento">
					</div>	
				</div>
			</div>
			<div class="row">
				<div class="col-md-3">
					<label class="" for="telefono">Telefono <span class="required">*</span></label>
					<div class="input-group">
						<input value ="<?php echo $persona->per_telefono ?>" type="text" id="telefono" placeholder="Telefono" font style="text-transform: uppercase;" onkeyup="javascript:this.value = this.value.toUpperCase ();"   name="telefono" class="form-control">
					</div>
				</div>
				<div class="col-md-3">
					<label class="" for="correo">Correo <span class="required">*</span></label>
					<div class="input-group">
						<input value ="<?php echo $persona->per_correo ?>" type="text" id="correo" placeholder="Correo" font style="text-transform: uppercase;" onkeyup="javascript:this.value = this.value.toUpperCase ();"   name="correo" class="form-control">
					</div>
				</div>
				<div class="col-md-3">
					<label class="" for="desCiudad">Ciudad <span class="required">*</span></label>
					<div id="custom-search-input">
						<div class="input-group">
							<input value ="<?php echo $persona->ciu_id ?>" type="hidden" name="ciudad_id" id="ciudad_id">	
							<input value ="<?php echo $persona->ciu_descripcion ?>" type="text" name="Ciudad" id="Ciudad" class="form-control" placeholder="Buscar Ciudad" disabled="disabled" required="required"/>
							<span class="input-group-btn">
								<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#ciudad_select">
									<span class="fa fa-search" aria-hidden="true">
									</span>
								</button>
							</span>
						</div>
					</div>
				</div>
				<div class="col-md-3">
					<label class="" for="correo">Direccion<span class="required">*</span></label>
					<div class="input-group">
						<input value ="<?php echo $persona->per_direccion ?>" type="text" id="direccion" placeholder="Direccion" font style="text-transform: uppercase;" onkeyup="javascript:this.value = this.value.toUpperCase ();"   name="direccion" class="form-control">
					</div>
				</div>
				<div class="col-md-3 offset-5">
					<?php
								$estado = $persona->per_estado;
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
					<label class="" for="desCiudad">Estado <span class="required">*</span></label>
					<select class="form-control" name="estado" id="estado">
						<optgroup label="Estado Actual"></optgroup>
						<option value="<?php echo $persona->per_estado ?>"><?php echo $estado2 ?></option>
						<optgroup label="Estado a Asignar"></optgroup>
						<option value="1">Activo</option>
						<option value="2">Inactivo</option>
					</select>
				</div>
			</div>
			<hr>
			<div class="row">
				<div class="col-md-3 offset-5">
					<button type="button" onclick="location.href=document.referrer" class="btn btn-primary">Cancelar</button>
					<button type="submit" class="btn btn-primary">Guardar</button>
				</div>
			</div>
		</form>
	</div>
</div>
<div class="modal fade" id="ciudad_select">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Lista de Ciudades</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			</div>
			<div class="modal-body">
				<table class="table table-bordered" id="tablaCiudad" width="100%">
					<thead>
						<tr>
							<th class="text-center">Codigo</th>
							<th class="text-center">Descripcion</th>
							<th class="text-center">Operaciones</th>
						</tr>
					</thead>
					<tbody>
						<?php if(!empty($ciudades)):?>
							<?php
							foreach($ciudades as $ciudad):?>
								<tr>
									<td><?php echo $ciudad->ciu_id; ?></td>
									<td><?php echo $ciudad->ciu_descripcion;?></td>
									<td><button class="btn btn-success btn-block select"><i class="fa fa-check"></i></button></td>
								</tr>
							<?php endforeach; ?>
						<?php endif; ?>
					</tbody>
				</table>
			</div>
			<!-- <div class="modal-footer">
				<button type="button" class="btn btn-danger pull-left" data-dismiss="modal">Cerrar</button>
			</div> -->
		</div>
	</div>
</div>
<?php $this->stop()?>
<?php $this->push('scripts')?>
<script type="text/javascript">
	var tabla = $("#tablaCiudad").DataTable({
		'lengthMenu':[[10, 15, 20], [10, 15, 20]],
		'paging':true,
		'info':true,
		'filter':true,
		'stateSave':true,
		'processing':true,
		'scrollX':false,
		'searching':true,
		
		'language':{
			"sProcessing":     "Procesando...",
			"sLengthMenu":     "Mostrar _MENU_ registros",
			"sZeroRecords":    "No se encontraron resultados",
			"sEmptyTable":     "Ning�n dato disponible en esta tabla",
			"sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
			"sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
			"sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
			"sInfoPostFix":    "",
			"sSearch":         "Buscar:",
			"sUrl":            "",
			"sInfoThousands":  ",",
			"oPaginate": {
				"sFirst":    "Primero",
				"sLast":     "�ltimo",
				"sNext":     "Siguiente",
				"sPrevious": "Anterior"
			},
			"oAria": {
				"sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
				"sSortDescending": ": Activar para ordenar la columna de manera descendente"
			}
		},
		
	});

	$('#tablaCiudad tbody').on('click', 'tr', function (event) {
		var data = tabla.row(this).data();
		$('#ciudad_id').val(data[0]);
		$('#Ciudad').val(data[1]);
		$('#ciudad_select').modal('hide');
	} );
	$("#frm_persona").submit(function(event) {
		event.preventDefault();		
		var formDato = $(this).serialize();
		$.ajax({
			url: "<?php echo base_url()?>update_persona",
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
					title: 'Atenci�n!', 
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
				window.location = "<?php echo base_url()?>personas";
			}
		}).fail(function() {
			alert("Se produjo un error, contacte con el soporte t�cnico");
		});
	})

</script>
<?php $this->end()?>

<!-- /.modal -->
