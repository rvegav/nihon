<?php $this->layout('v_master')?>
<?php $this->start('contenido')?>
<?php $CI =& get_instance(); ?>
<div class="card">
	<div class="card-header">
		<h4>Atencion Expediente</h4>
	</div>
	<div class="card-body">
		<h5>Detalles del agendamiento</h5>
		<form id="frm_agendamiento" data-parsley-validate="" class="" action="" method="POST">
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
						<textarea id="peso" name="peso" placeholder="Peso del paciente en Kilogramos" class="form-control" style="overflow: hidden; overflow-wrap: break-word; resize: none; height: 58px;"></textarea>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label for="observacion">Observacion</label>
						<textarea id="observacion" name="observacion" placeholder="Observaciones Adicionales" class="form-control" style="overflow: hidden; overflow-wrap: break-word; resize: none; height: 58px;"></textarea>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<div class="form-group">
						<label for="diagnostico">Diagnostico</label>
						<textarea id="diagnostico" name="diagnostico" placeholder="Diagnostico Especifico" class="form-control" style="overflow: hidden; overflow-wrap: break-word; resize: none; height: 58px;"></textarea>
					</div>
				</div>
			</div>
			<hr>
			<div class="row">
				<div class="col-md-10">
					<h6>Agregar Producto</h6>
				</div>
				<div class="col-md-2">
					<button type="button" id="Agregar" class="btn btn-primary"  data-placement="top" data-toggle="modal" data-target="#producto_select" title="Añadir Producto"><i class="fa fa-plus"></i>Buscar Producto</button>
				</div>
				<div class="col-md-12">
					<br>
					<div class="table-responsive">
						<table class="table table-striped" id="tablaProducto" width="100%">
							<thead>
								<th>Cod. Producto</th>
								<th>Nombre</th>
								<th>Cantidad</th>
								<th>Operaciones</th>
							</thead>
						</table>
					</div>
				</div>
			</div>
			<br>
			<div class="row">
				<div class="col-md-10">
					<h6>Agregar Servicio</h6>
				</div>
				<div class="col-md-2">
					<button type="button" id="Agregar" class="btn btn-primary" data-toggle="modal" data-target="#servicio_select" title="Añadir Servicio"><i class="fa fa-plus"></i>Buscar Servicio</button>
				</div>
				<div class="col-md-12">
					<br>
					<div class="table-responsive">
						<table class="table table-striped" id="tablaServicio" width="100%">
							<thead>
								<th>Cod. Servicio</th>
								<th>Descripcion</th>
								<th>Operaciones</th>
							</thead>
						</table>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-6 col-sm-6 col-xs-12 offset-5">
					<button type="reset" class="btn btn-primary">Resetear</button>
					<button type="submit" class="btn btn-primary">Guardar</button>
				</div>
			</div>
		</form>
	</div>

</div>
<div class="modal fade" id="producto_select">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Productos</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			</div>
			<div class="modal-body">
				<table class="table table-bordered" id="tablaInventario" width="100%">
					<thead>
						<tr>
							<th class="text-center">Codigo</th>
							<th class="text-center">Descripcion</th>
							<th class="text-center">Disponibilidad</th>
							<th class="text-center">Accion</th>
						</tr>
					</thead>
					<tbody>
						<?php if(!empty($productos)):?>
							<?php
							foreach($productos as $producto):?>
								<tr>
									<td><?php echo $producto->prod_id; ?></td>
									<td><?php echo $producto->prod_descripcion;?></td>
									<td><?php echo $producto->inve_cantidad ?></td>
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
<div class="modal fade" id="servicio_select">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Servicios</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			</div>
			<div class="modal-body">
				<table class="table table-bordered" id="tablaCliente" width="100%">
					<thead>
						<tr>
							<th class="text-center">Codigo</th>
							<th class="text-center">Nombre</th>
							<th class="text-center">Accion</th>
						</tr>
					</thead>
					<tbody>
						<?php if(!empty($servicios)):?>
							<?php
							foreach($servicios as $servicio):?>
								<tr>
									<td><?php echo $servicio->prod_id; ?></td>
									<td><?php echo $servicio->prod_descripcion;?></td>
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

	$("#frm_agendamiento").submit(function(event) {
		event.preventDefault();
		event.preventDefault();
		// var tabla = $('#tablaPaciente').DataTable();
		if (tablaPaciente) {

			$.each(tablaPaciente.rows('.selected').data(), function(index, val) {
				$('<input />', {
					type:'hidden',
					name:'mascota',
					value: val.MAS_ID
				}).appendTo($('#frm_agendamiento'));

			});
		}
		if (tablaDisponibilidad) {

			$.each(tablaDisponibilidad.rows('.selected').data(), function(index, val) {
				$('<input />', {
					type:'hidden',
					name:'turnos[]',
					value: val.ID
				}).appendTo($('#frm_agendamiento'));

			});
		}		
		var formDato = $(this).serialize();
		$.ajax({
			url: "<?php echo base_url()?>update_agendamiento",
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
				window.location = "<?php echo base_url()?>recepcion";
			}
		}).fail(function() {
			alert("Se produjo un error, contacte con el soporte técnico");
		});
		$('#frm_agendamiento').trigger("reset");
	})
	var tablaProducto = $("#tablaProducto").DataTable({
		'lengthChange':false,
		'lengthMenu':[3],
		'paging':true,
		'info':false,
		'filter':true,
		'stateSave':false,
		'processing':true,
		'scrollX':false,
		'searching':false,
		
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
	var tablaServicio = $("#tablaServicio").DataTable({
		'lengthChange':false,
		'lengthMenu':[3],
		'paging':true,
		'info':false,
		'filter':true,
		'stateSave':false,
		'processing':true,
		'scrollX':false,
		'searching':false,
		'ajax':{
			"url":"<?php echo base_url()?>get_servicio",
			"type":"POST",
			"data":function(data){
				data.age_id=$('#age_id').val();
			}
		},
		'columns':[
		{data:'ID'},
		{data:'DESCRIPCION'},
		{data: function(){
			return null;
		}},
		],
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
	var tablaInventario = $("#tablaInventario").DataTable({
		'lengthChange':false,
		'lengthMenu':[3],
		'paging':true,
		'info':false,
		'filter':true,
		'stateSave':false,
		'processing':true,
		'scrollX':false,
		'searching':false,
		'ajax':{
			"url":"<?php echo base_url()?>get_disponibilidad_producto",
			"type":"POST",
		},
		'columns':[
		{data:'ID'},
		{data:'DESCRIPCION'},
		{data:'CANTIDAD'},
		{data: function(data){
			return '<button class="btn btn-success btn-block select" value'+data.ID+'><i class="fa fa-check"></i></button>';
		}},
		],
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
	$('#tablaInventario tbody').on('click', '.select', function (event) {
		registro = $(this).parents('tr');
		var data = tablaInventario.row(registro).data();
		tablaProducto.row.add( [
            data.ID,
            data.DESCRIPCION,
         	0,
         	'<button type="button" class="btn btn-default mas"  ><i class="fa fa-plus"></i></button><button type="button" class="btn btn-default menos"><i class="fa fa-minus"></i></button><button type="button" class="btn btn-danger eliminar"><i class="fa fa-trash"></i></button>'
        ] ).draw( false );
		$('#producto_select').modal('hide');

	} );
	$('#tablaProducto tbody').on('click', '.mas', function (event) {
		registro = $(this).parents('tr');
		var data = tablaProducto.row(registro).data();
		tablaProducto.row(registro).data()[2]++;
		// tablaProducto.draw();
		// console.log(tablaProducto.row(registro).columns().data());
		$("#tablaProducto").DataTable().draw();
		console.log(tablaProducto.row(registro).data());
	} );
</script>
<?php $this->end()?>

<!-- /.modal -->
