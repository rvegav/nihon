<?php $this->layout('v_master')?>
<?php $this->start('contenido')?>
<?php $CI =& get_instance(); ?>
<div class="card">
	<div class="card-header">
		<h4>Editar Cliente</h4>
	</div>
	<div class="card-body">
		<form id="frm_ciudad" data-parsley-validate="" class="" action="" method="POST">
			<div class="row">
				<div class="col-md-4 offset-3">
					<label for="clie_id">Código Cliente<span class="required">*</span></label>
					<div class="input-group">
						<input type="text" class="form-control" id="clie_id" name="clie_id" readonly value="<?php echo $cliente->clie_id;?>">
					</div>	
				</div>
			</div>
			<div class="row">
				<div class="col-md-4 offset-3">
					<label class="" for="desCiudad">Persona <span class="required">*</span></label>
					<div id="custom-search-input">
						<div class="input-group">
							<input type="hidden" name="per_id" id="per_id" value="<?php echo $cliente->clie_per_id ?>">	
							<input type="text" name="persona" id="persona" class="form-control" placeholder="Buscar Persona" disabled="disabled" required="required" value="<?php echo $cliente->clie_nombre ?>">
							<span class="input-group-btn">
								<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#persona_select">
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
					<label for="fecha_incorporacion">Fecha de Incorporacion<span class="required">*</span></label>
					<div class="input-group">
						<input type="date" class="form-control" id="fecha_incorporacion" name="fecha_incorporacion" value="<?php echo $cliente->fecha_incorporacion ?>">
					</div>	
				</div>
			</div>
			<div class="row">
				<?php
				$estado = $cliente->clie_estado;
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
				<div class="col-md-4 offset-3">
					<label class="" for="desCiudad">Estado <span class="required">*</span></label>
					<select class="form-control" style="width: 100%;" name="estado" id="estado">
						<optgroup label="Estado Actual"></optgroup>
						<option value="<?php echo $cliente->clie_estado ?>"><?php echo $estado2 ?></option>
						<optgroup label="Estado a Asignar"></optgroup>
						<option value="1">Activo</option>
						<option value="2">Inactivo</option>
					</select>
				</div>
			</div>
			<hr>
			<div class="row">
				<div class="col-md-6 col-sm-6 col-xs-12 offset-3">
					<button type="button" onclick="history.back()" class="btn btn-primary">Cancelar</button>
					<button type="submit" class="btn btn-primary">Guardar</button>
				</div>
			</div>
		</form>
	</div>

</div>
<div class="modal fade" id="persona_select">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Lista de Personas</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			</div>
			<div class="modal-body">
				<table class="table table-bordered" id="tablaPersona" width="100%">
					<thead>
						<tr>
							<th class="text-center">Codigo</th>
							<th class="text-center">Nombre</th>
							<th class="text-center">Apellido</th>
							<th class="text-center">Direccion</th>
							<th class="text-center">Accion</th>
						</tr>
					</thead>
					<tbody>
						<?php if(!empty($personas)):?>
							<?php
							foreach($personas as $persona):?>
								<tr>
									<td><?php echo $persona->per_id; ?></td>
									<td><?php echo $persona->per_nombre;?></td>
									<td><?php echo $persona->per_apellido;?></td>
									<td><?php echo $persona->per_direccion;?></td>
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
	var tablaPersona = $("#tablaPersona").DataTable({
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

	$('#tablaPersona tbody').on('click', 'tr', function (event) {
		var data = tablaPersona.row(this).data();
		$('#per_id').val(data[0]);
		$('#persona').val(data[1]+' '+data[2]);
		$('#persona_select').modal('hide');
	} );


	$("#frm_ciudad").submit(function(event) {
		event.preventDefault();		
		var formDato = $(this).serialize();
		$.ajax({
			url: "<?php echo base_url()?>update_cliente",
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
					// icon: "warning",
					// columnClass: 'medium',
				});
			}
			if (r['error']!="") {
				wrapper.innerHTML = r['error'];
				swal.fire({
					// icon: "error",
					// columnClass: 'medium',
					// theme: 'modern',
					title: 'Error!',
					html: wrapper,
				});
			}
			if (r['correcto']!="") {
				window.location = "<?php echo base_url()?>clientes";
			}
		}).fail(function() {
			alert("Se produjo un error, contacte con el soporte técnico");
		});
	})


</script>
<?php $this->end()?>

<!-- /.modal -->
