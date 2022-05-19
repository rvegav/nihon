<?php $this->layout('v_master')?>
<?php $this->start('contenido')?>
<?php $CI =& get_instance(); ?>
<div class="card">
	<div class="card-header">
		<h4>Editar Mascota</h4>
	</div>
	<div class="card-body">
		<form id="frm_mascota" data-parsley-validate="" class="" action="" method="POST">
			<div class="row">
				<div class="col-md-4 offset-3">
					<label for="mas_id">Código Mascota<span class="required">*</span></label>
					<div class="input-group">
						<input type="text" class="form-control" id="mas_id" name="mas_id" readonly value="<?php echo $mascota->mas_id;?>">
					</div>	
				</div>
			</div>
			<div class="row">
				<div class="col-md-4 offset-3">
					<label class="" for="desCiudad">Nombre <span class="required">*</span></label>
					<div class="input-group">
						<input value ="<?php echo $mascota->mas_nombre ?>" type="text" id="nombreMascota" placeholder="Descripcion" font style="text-transform: uppercase;" onkeyup="javascript:this.value = this.value.toUpperCase ();"   name="nombreMascota" class="form-control">
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-4 offset-3">
					<label class="" for="desCiudad">Dueño<span class="required">*</span></label>
					<div id="custom-search-input">
						<div class="input-group">
							<input value ="<?php echo $mascota->mas_clie_id ?>" type="hidden" name="clie_id" id="clie_id">	
							<input value ="<?php echo $mascota->mas_nombre_duenho?>" type="text" name="cliente_nombre" id="cliente_nombre" class="form-control" placeholder="Buscar Dueño" disabled="disabled" required="required">
							<span class="input-group-btn">
								<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#cliente_select">
									<span class="fa fa-search" aria-hidden="true">
									</span>
								</button>
							</span>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-4 offset-3">
					<label class="" for="desCiudad">Fecha de Nacimiento <span class="required">*</span></label>
					<div class="input-group">
						<input value ="<?php echo $mascota->mas_fecha_nacimiento_sin ?>" type="date" id="fecha_nacimiento" placeholder="Fecha de Nacimiento" font style="text-transform: uppercase;" onkeyup="javascript:this.value = this.value.toUpperCase ();"   name="fecha_nacimiento" class="form-control">
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-4 offset-3">
					<label class="" for="desCiudad">Raza <span class="required">*</span></label>
					<div id="custom-search-input">
						<div class="input-group">
							<input value ="<?php echo $mascota->mas_raz_id ?>" type="hidden" name="raz_id" id="raz_id">	
							<input value ="<?php echo $mascota->mas_raza ?>" type="text" name="raza" id="raza" class="form-control" placeholder="Buscar Raza" disabled="disabled" required="required"/>
							<span class="input-group-btn">
								<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#raza_select">
									<span class="fa fa-search" aria-hidden="true">
									</span>
								</button>
							</span>
						</div>
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
					<button type="button" onclick="location.href=document.referrer" class="btn btn-primary">Cancelar</button>
					<button type="submit" class="btn btn-primary">Guardar</button>
				</div>

			</div>
		</form>
	</div>
</div>
<div class="modal fade" id="raza_select">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Lista de Raza</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			</div>
			<div class="modal-body">
				<table class="table table-bordered" id="tablaRaza" width="100%">
					<thead>
						<tr>
							<th class="text-center">Codigo</th>
							<th class="text-center">Descripcion</th>
							<th class="text-center">Especie</th>
							<th class="text-center">Operaciones</th>
						</tr>
					</thead>
					<tbody>
						<?php if(!empty($razas)):?>
							<?php
							foreach($razas as $raza):?>
								<tr>
									<td><?php echo $raza->raz_id; ?></td>
									<td><?php echo $raza->raz_descripcion;?></td>
									<td><?php echo $raza->raz_especie;?></td>
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
<div class="modal fade" id="cliente_select">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Lista de Clientes</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			</div>
			<div class="modal-body">
				<table class="table table-bordered" id="tablaCliente" width="100%">
					<thead>
						<tr>
							<th class="text-center">Codigo</th>
							<th class="text-center">Nombre</th>
							<th class="text-center">Operaciones</th>
						</tr>
					</thead>
					<tbody>
						<?php if(!empty($clientes)):?>
							<?php
							foreach($clientes as $cliente):?>
								<tr>
									<td><?php echo $cliente->clie_id; ?></td>
									<td><?php echo $cliente->clie_nombre;?></td>
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
	$('#inventariable').hide();
	var tabla = $("#tablaRaza").DataTable({
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
			"sEmptyTable":     "Ningún dato disponible en esta tabla",
			"sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
			"sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
			"sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
			"sInfoPostFix":    "",
			"sSearch":         "Buscar:",
			"sUrl":            "",
			"sInfoThousands":  ",",
			"oPaginate": {
				"sFirst":    "Primero",
				"sLast":     "Último",
				"sNext":     "Siguiente",
				"sPrevious": "Anterior"
			},
			"oAria": {
				"sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
				"sSortDescending": ": Activar para ordenar la columna de manera descendente"
			}
		},
		
	});
	$('#tablaRaza tbody').on('click', 'tr', function (event) {
		var data = tabla.row(this).data();
		$('#raz_id').val(data[0]);
		$('#raza').val(data[1]);
		$('#raza_select').modal('hide');
	} );
	var tablaTipo = $("#tablaCliente").DataTable({
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
			"sEmptyTable":     "Ningún dato disponible en esta tabla",
			"sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
			"sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
			"sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
			"sInfoPostFix":    "",
			"sSearch":         "Buscar:",
			"sUrl":            "",
			"sInfoThousands":  ",",
			"oPaginate": {
				"sFirst":    "Primero",
				"sLast":     "Último",
				"sNext":     "Siguiente",
				"sPrevious": "Anterior"
			},
			"oAria": {
				"sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
				"sSortDescending": ": Activar para ordenar la columna de manera descendente"
			}
		},
		
	});

	$('#tablaCliente tbody').on('click', 'tr', function (event) {
		var data = tablaTipo.row(this).data();
		$('#clie_id').val(data[0]);
		$('#cliente_nombre').val(data[1]);
		$('#cliente_select').modal('hide');
	} );

	$("#frm_mascota").submit(function(event) {
		event.preventDefault();		
		var formDato = $(this).serialize();
		$.ajax({
			url: "<?php echo base_url()?>update_mascota",
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
				window.location = "<?php echo base_url()?>mascotas";
			}
		}).fail(function() {
			alert("Se produjo un error, contacte con el soporte técnico");
		});
	})

</script>
<?php $this->end()?>

<!-- /.modal -->
