<?php $this->layout('v_master')?>
<?php $this->start('contenido')?>
<?php $CI =& get_instance(); ?>
<div class="card">
	<div class="card-header">
		<h4>Agendar Paciente</h4>
	</div>
	<div class="card-body">
		<form id="frm_agendamiento" data-parsley-validate="" class="" action="" method="POST">
			<div class="row">
				<div class="col-md-12">
					<label class="" for="desCiudad">Cliente <span class="required">*</span></label>
					<div id="custom-search-input">
						<div class="input-group">
							<input type="hidden" name="clie_id" id="clie_id">	
							<input type="text" name="cliente" id="cliente" class="form-control" placeholder="Buscar Persona" disabled="disabled" required="required">
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
				<div class="col-md-12">

					<div class="table-responsive">
						<table class="table table-striped" id="tablaPaciente" width="100%">
							<thead>
								<th>Cod. Paciente</th>
								<th>Nombre</th>
								<th>Raza</th>
								<th>Edad</th>
							</thead>
						</table>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-6">
					<label class="" for="desCiudad">Tipo de Servicio <span class="required">*</span></label>
					<select class="form-control" name="servicio" id="servicio">
						<?php foreach ($servicios as $servicio): ?>
							<option value="<?php echo $servicio->prod_id ?>"><?php echo $servicio->prod_descripcion ?></option>
						<?php endforeach ?>
						
					</select>
				</div>
				<div class="col-md-6">
					<label for="fecha_agendamiento">Fecha de Agendamiento<span class="required">*</span></label>
					<div class="input-group">
						<input type="date" class="form-control" id="fecha_agendamiento" name="fecha_agendamiento" value="">
						<span class="input-group-btn">
							<button type="button" class="btn btn-primary" id="consulta_disponibilidad">
								<span class="fa fa-search" aria-hidden="true">
								</span>
							</button>
						</span>
					</div>	
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<div class="table-responsive">
						<table class="table table-striped" id="tablaDisponibilidad" width="100%">
							<thead>
								<th>Item</th>
								<th>Dia</th>
								<th>Hora</th>
								<th>Estado</th>
							</thead>
						</table>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<div class="form-group">
						<label for="razon">Motivo de la visita</label>
						<textarea id="razon" name="razon" placeholder="Descripcion breve" class="form-control" style="overflow: hidden; overflow-wrap: break-word; resize: none; height: 58px;"></textarea>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-6">
					<label class="" for="estado">Estado <span class="required">*</span></label>
					<select class="form-control" name="estado" id="estado">
						<option value="1">Activo</option>
					</select>
				</div>
				<div class="col-md-6">
					<label class="" for="empleado">Derivar a:<span class="required">*</span></label>
					<div class="input-group">
						<input type="hidden" name="empl_id" id="empl_id" >
						<input type="text" name="" id="empleado" placeholder="Buscar Empleado" class="form-control" disabled="disabled" />
						<span class="input-group-btn">
							<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#empleado_select">
								<i class="fa fa-search" aria-hidden="true"></i>
							</button>
						</span>
					</div>
				</div>
			</div>
			<hr>
			<div class="row">
				<div class="col-md-6 col-sm-6 col-xs-12 offset-5">
					<button type="button" onclick="history.back()" class="btn btn-primary">Cancelar</button>
					<button type="submit" class="btn btn-primary">Guardar</button>
				</div>
			</div>
		</form>
	</div>

</div>
<div class="modal fade" id="cliente_select">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Clientes</h4>
				<div class="col-md-2 offset-7">
					<a href="<?php echo base_url()?>add_cliente" class="nav-link">
						<button type="button" id="Agregar" class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="Agregar Nuevo Cliente"><i class="fa fa-plus"></i>Agregar Clientes</button>
					</a>
				</div>
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
<div class="modal fade" id="empleado_select">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Lista de Empleados</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			</div>
			<div class="modal-body">
				<div class="table-responsive">
					<table id="tablaEmpleado" class="table table-bordered table-striped table-hover">
						<thead>
							<tr>
								<th>Codigo</th>
								<th>Nro. Cedula</th>
								<th>Nombre</th>
								<th>Opcion</th>
							</tr>
						</thead>
						<tbody>
							<?php
							if(!empty($empleados)):?>

								<?php foreach($empleados as $empleado):?>
									<tr>
										<td><?php echo $empleado->empl_id ?></td>
										<td><?php echo $empleado->empl_nro_doc;?></td>
										<td><?php echo $empleado->empl_nombre;?></td>
										<td>
											<button type = "button" class="btn btn-success select" value="<?php echo $empleado->empl_id;?>"><span class= "fa fa-check"></span></button>
										</td>
									</tr>
								<?php endforeach; ?>
							<?php endif; ?>
						</tbody>
					</table>
					
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-danger pull-left" data-dismiss="modal">Cerrar</button>
			</div>
		</div>
	</div>
</div>

<?php $this->stop()?>
<?php $this->push('scripts')?>
<script type="text/javascript">
	var tablaCliente = $("#tablaCliente").DataTable({
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

	$('#tablaCliente tbody').on('click', '.select', function (event) {
		registro = $(this).parents('tr');
		var data = tablaCliente.row(registro).data();
		$('#clie_id').val(data[0]);
		$('#cliente').val(data[1]);
		$('#cliente_select').modal('hide');
		tablaPaciente.ajax.reload();
	} );

	$("#frm_agendamiento").submit(function(event) {
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
			url: "<?php echo base_url()?>store_agendamiento",
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
	var tablaPaciente = $("#tablaPaciente").DataTable({
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
			"url":"<?php echo base_url()?>get_mascotas",
			"type":"POST",
			"data":function(data){
				data.clie_id=$('#clie_id').val();
			}
		},
		'columns':[
		{data:'MAS_ID'},
		{data:'MAS_NOMBRE'},
		{data: 'MAS_RAZA'},
		{data: 'EDAD'}


		],
		'language':{
			"sProcessing":     "Procesando...",
			"sLengthMenu":     "Mostrar _MENU_ registros",
			"sZeroRecords":    "No se encontraron resultados",
			"sEmptyTable":     "Ningún dato disponible en esta tabla",
			"sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
			"sInfoEmpty":      "Sin informacion",
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

	$('#tablaPaciente tbody').on( 'click', 'tr', function () {
		$(this).toggleClass('selected');

		var mas_id = '';
		var data = tablaPaciente.rows('.selected').data();
		var fila = 0;
		var ind = tablaPaciente.rows('.selected').data().length;
		if (ind>1) {
			Swal.fire({
				type:'error',
				title:'Error!',
				text:'No se puede seleccionar más de una mascota!',
			});
			$(this).removeClass('selected');
		}

	} );
	var tablaDisponibilidad = $("#tablaDisponibilidad").DataTable({
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
			"url":"<?php echo base_url()?>get_disponibilidad",
			"type":"POST",
			"data":function(data){
				data.fecha_consulta=$('#fecha_agendamiento').val();
				data.servicio_consulta=$('#servicio').val();
			}
		},
		"createdRow": function(row, data, index){
			if (data.ESTADO == 'OCUPADO'){
				$(row).addClass("Warning");
			}
		},
		'columns':[
		{data:'ITEM'},
		{data:'DIA'},
		{data: 'HORA'},
		{data: 'ESTADO'},
		],
		'language':{
			"sProcessing":     "Procesando...",
			"sLengthMenu":     "Mostrar _MENU_ registros",
			"sZeroRecords":    "No se encontraron resultados",
			"sEmptyTable":     "Ningún dato disponible en esta tabla",
			"sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
			"sInfoEmpty":      "Sin informacion",
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
	$('#tablaDisponibilidad tbody').on( 'click', 'tr', function () {
		var registro = $(this).toggleClass('selected');

		var mas_id = '';
		var data = tablaDisponibilidad.rows('.selected').data();
		var ind = tablaDisponibilidad.rows('.selected').data().length;
		console.log(registro);
		if (ind>1) {
			Swal.fire({
				type:'error',
				title:'Error!',
				text:'No se puede seleccionar más de dos turnos!',
			});
			$(this).removeClass('selected');
		}
		$registro = $(this);
		$.each(tablaDisponibilidad.rows('.selected').data(), function(index, val) {
			if (val.ESTADO == 'OCUPADO') {
				Swal.fire({
					type:'error',
					title:'Error!',
					text:'No se puede seleccionar un turno ocupado!',
				});
				registro.removeClass('selected');

			}

		});

	} );
	$('#consulta_disponibilidad').on( 'click', function () {
		var fecha = $('#fecha_agendamiento').val();
		var servicio = $('#servicio').val();
		$.ajax({
			url: "<?php echo base_url()?>get_disponibilidad",
			type: 'POST',
			data: {servicio_consulta:servicio, fecha_consulta:fecha}
		})
		.done(function(result) {
			if (result['error']!='') {
				Swal.fire({
					type:'error',
					title:'Error!',
					text:'No se puede seleccionar un turno ocupado!',
				});
			}
			if (result['data'] !='') {
				tablaDisponibilidad.ajax.reload();
			}
		}).fail(function() {
			alert("Se produjo un error, contacte con el soporte técnico");
		});
	});
	var tablaEmpleado = $("#tablaEmpleado").DataTable({
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

	$('#tablaEmpleado tbody').on('click', '.select', function (event) {
		registro = $(this).parents('tr');
		var data = tablaEmpleado.row(registro).data();
		$('#empl_id').val(data[0]);
		$('#empleado').val(data[2]);
		$('#empleado_select').modal('hide');
	} );
</script>
<?php $this->end()?>

<!-- /.modal -->
