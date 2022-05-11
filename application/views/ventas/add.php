<?php $this->layout('v_master')?>
<?php $this->start('contenido')?>
<?php $CI =& get_instance(); ?>
<div class="card">
	<div class="card-header">
		<h4>Facturacion</h4>
	</div>
	<div class="card-body">
		<form id="frm_venta" data-parsley-validate="" class="" action="" method="POST">
			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						
						<button class="btn btn-success btn-block" type="button" data-toggle="modal" data-target="#agendamiento_select" data-placement="top" title="Consultar por Expedientes Finalizados"><i class="fa fa-search fa-1x"></i><strong> Expedientes Finalizados</strong></button>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<button class="btn btn-success btn-block" type="button" data-toggle="modal" data-target="#cliente_select" data-placement="top" title="Buscar datos de Clientes "><i class="fa fa-search fa-1x"></i><strong> Clientes</strong></button>
					</div>
				</div>
			</div>
			<div class="form-group row">
				<input type="hidden" name="clie_id" id="clie_id">
				<label for="cliente" class="col-md-3 col-form-label">Cliente:</label>
				<div class="col-md-9">
					<input type="text" class="form-control" id="cliente" readonly disabled value="">
				</div>
			</div>
			<div class="form-group row">
				<label for="ruc" class="col-md-3 col-form-label">Ruc:</label>
				<div class="col-md-9">
					<input type="text" class="form-control" name="ruc" id="ruc" value="">
				</div>
			</div>
			<div class="form-group row">
				<label for="nombre_razon_social" class="col-md-3 col-form-label">Nombre o Razon Social:</label>
				<div class="col-md-9">
					<input type="text" class="form-control" name="nombre_razon_social" id="nombre_razon_social" value="">
				</div>
			</div>
			<hr>
			<div class="row">
				<div class="col-md-5 offset-5">
					<h6>Detalles de Ventas</h6>
				</div>
				<div class="col-md-1">
					<button class="btn btn-primary" type="button" data-toggle="modal" data-target="#producto_select" id="agregar_producto">Agregar Productos</button>
				</div>
			</div>
			<br>
			<div class="row">
				<div class="col-md-12">
					<div class="table-responsive">
						<table class="table table-striped table-bordered" id="tablaProductos">
							<thead>
								<tr>
									<th  style="text-align: center; width: 3%;">Item</th>
									<th  style="text-align: center; width: 10%;">Cod. Prod.</th>
									<th  style="text-align: center; width: 40%;">Descripcion</th>
									<th  style="text-align: center; width: 10%;">Cantidad</th>
									<th  style="text-align: center; width: 8%;">Precio</th>
									<th  style="text-align: center; width: 10%;">Operaciones</th>
								</tr>
							</thead>
							<tbody></tbody>
							<tfoot>
								<tr>
									<th colspan="3"></th>
									<th >IVA: </th>
									<th colspan="2">Total: <span id="total"></span></th>
								</tr>
							</tfoot>
						</table>
					</div>
				</div>
			</div>
			<hr>
			<div class="row">
				<div class="col-md-6 col-sm-6 col-xs-12 offset-3">
					<button type="submit" class="btn btn-primary btn-block">Guardar</button>
				</div>
			</div>
			<input type="hidden" id="precio_total">
		</form>
	</div>

</div>
<div class="modal fade" id="agendamiento_select">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Lista de Agendamientos</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			</div>
			<div class="modal-body">
				<table class="table table-bordered" id="tablaAgendamiento" width="100%">
					<thead>
						<tr>
							<th class="text-center">Codigo</th>
							<th class="text-center">Cliente</th>
							<th class="text-center">RUC</th>
							<th class="text-center">Mascota</th>
							<th class="text-center">Motivo Visita</th>
							<th class="text-center">Accion</th>
						</tr>
					</thead>
					<tbody>
						<?php if(!empty($agendamientos)):?>
							<?php
							foreach($agendamientos as $agendamiento):?>
								<tr>
									<td><?php echo $agendamiento->age_id; ?></td>
									<td><?php echo $agendamiento->age_duenho;?></td>
									<td><?php echo $agendamiento->clie_ruc;?></td>
									<td><?php echo $agendamiento->age_mascota;?></td>
									<td><?php echo $agendamiento->age_motivo_agendamiento;?></td>
									<td><button class="btn btn-success btn-block select" value="<?php echo $agendamiento->clie_id ?>" data-toggle="tooltip" data-placement="top" title="Seleccionar Agendamiento"><i class="fa fa-check"></i></button></td>
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
							<th class="text-center">CI</th>
							<th class="text-center">RUC</th>
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
									<td><?php echo $cliente->clie_cedula;?></td>
									<td><?php echo $cliente->clie_ruc;?></td>
									<td><button class="btn btn-success btn-block select" data-toggle="tooltip" data-placement="top" title="Seleccionar Cliente"><i class="fa fa-check"></i></button></td>
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
<?php $this->stop()?>
<?php $this->push('scripts')?>
<script type="text/javascript">
	$('#total').html('0');

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
		var registro = $(this).parents('tr');
		var data = tablaCliente.row(registro).data();
		$('#clie_id').val(data[0]);
		$('#cliente').val(data[1]);
		$('#nombre_razon_social').val(data[1]);
		$('#ruc').val(data[3]);
		$('#cliente_select').modal('hide');
		precio_total = 0;
		$('#total').html(precio_total);
		tablaProductos.clear().draw();

	} );
	var tablaAgendamiento = $("#tablaAgendamiento").DataTable({
		'lengthChange':false,
		'lengthMenu':[10],
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
	var complete = false;
	$('#tablaAgendamiento tbody').on('click', '.select', function (event) {
		registro = $(this).parents('tr');

		$('#total').html('');
		precio_total =0;
		var data = tablaAgendamiento.row(registro).data();
		$('#cliente').val(data[1]);	
		$('#clie_id').val($(this).val());
		$('#nombre_razon_social').val(data[1]);
		$('#ruc').val(data[2]);
		$.ajax({
			url: "<?php echo base_url()?>get_detalle_agendamientos",
			type: 'POST',
			data: {age_id: data[0]}
		})
		.done(function(result) {
			var resultado = JSON.parse(result);
			tablaProductos.clear().draw();
			var item = 0;
			$.each(resultado, function(index, val) {
				item++;
				tablaProductos.row.add( [
					item,
					val.ID,
					val.DESCRIPCION,
					val.CANTIDAD,
					val.PRECIO,
					''
					] ).draw( false );

				precio_total = precio_total + (val.PRECIO * val.CANTIDAD);
			});
			// alert(precio_total);
			// $('#total').html('');
			$('#total').html(precio_total);
			complete= true;
			

		}).fail(function() {
			alert("Se produjo un error, contacte con el soporte técnico");
		});
		$('#agendamiento_select').modal('hide');
	} );
	
	// (function runOnComplete(){
	// 	if( complete ){
	// 		$.each(tablaProductos.rows().data(), function(index, val) {
	// 			console.log(val);
	// 			precio_total = parseInt(val[4]) * parseInt(val[3]);
	// 		});
	// 		var total = 'Total: '+ precio_total;
	// 		alert(total);
	// 		$('#tablaProductos tfoot').children('tr').get(0).cells[2].innerHTML = total;
	// 		tablaProductos.draw();
	// 		console.log('imprime después');
	// 	}else{
	// 		console.log('imprime muchas veces');
	// 		setTimeout(runOnComplete,25);
	// 	}
	// })()
	var tablaProductos = $("#tablaProductos").DataTable({
		'lengthChange':false,
		'lengthMenu':[10],
		'paging':true,
		'info':false,
		'filter':true,
		'stateSave':false,
		'processing':true,
		'scrollX':false,
		'searching':false,
		'ordering':false,
		
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
		'fixedHeader': {
			header: true,
			footer: true
		},
	});
	$("#frm_venta").submit(function(event) {
		event.preventDefault();
		html='';
		$.each(tablaProductos.rows().data(), function(index, val) {
			console.log(val[5]);
			if (val[5]=='') {
				html += '<input type="hidden" name="productos['+index+'][prod_id]" value="'+val[1]+'">';
				html += '<input type="hidden" name="productos['+index+'][cantidad]" value="'+val[3]+'">';
			}else{
				html += '<input type="hidden" name="productos['+index+'][prod_id_nuevo]" value="'+val[1]+'">';
				html += '<input type="hidden" name="productos['+index+'][cantidad_nuevo]" value="'+val[3]+'">';
			}
			$("#frm_venta").append(html);
		});		
		var formDato = $(this).serialize();
		$.ajax({
			url: "<?php echo base_url()?>store_venta",
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
				let prevUrl = document.referrer;
				// window.location = "<?php echo base_url()?>clientes";
				window.location = prevUrl;
			}
		}).fail(function() {
			alert("Se produjo un error, contacte con el soporte técnico");
		});
	})
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
		var item = tablaProductos.data().length;
		item++;
		tablaProductos.row.add( [
			item,
			data.ID,
			data.DESCRIPCION,
			0,
			data.PRECIO,
			'<button type="button" class="btn btn-default mas" style="font-size: 11px;"><i class="fa fa-plus "></i></button><button type="button" style="font-size: 11px;" class="btn btn-default menos"><i class="fa fa-minus"></i></button><button type="button" style="font-size: 11px;" class="btn btn-danger eliminar"><i class="fa fa-trash"></i></button>'
			] ).draw( false );
		$('#producto_select').modal('hide');

	} );
	var precio_total = 0;
	$('#tablaProductos tbody').on('click', '.mas', function (event) {
		registro = $(this).parents('tr');
		var data = tablaProductos.row(registro).data();
		var cantidad = data[3]++;
		cantidad = cantidad + 1
		registro.get(0).cells[3].innerHTML = cantidad;
		precio_total = parseInt(data[4]) + precio_total;
		var total = 'Total: ' + precio_total;

		tablaProductos.draw();
		$("#total").html(precio_total);

		console.log(precio_total);
	} );
	$('#tablaProductos tbody').on('click', '.menos', function (event) {
		registro = $(this).parents('tr');
		var data = tablaProductos.row(registro).data();
		var cantidad = data[3]--;;
		if ((cantidad - 1)< 0) {
			alert('no puede ser menor que 0 (cero)');
			data[3]++;
		}else{
			cantidad = cantidad -1;
			registro.get(0).cells[3].innerHTML = cantidad;
			precio_total = precio_total - parseInt(data[4]);

		}
		var total = 'Total: ' + precio_total;
		tablaProductos.draw();
		$("#total").html(precio_total);
		// console.log(cantidad);
	} );
	$('#tablaProductos tbody').on('click', '.eliminar', function () {
		registro = $(this).parents('tr');
		var data = tablaProductos.row(registro).data();
		precio_total = precio_total - (parseInt(data[3])*parseInt(data[4]));

		var total = 'Total: ' + precio_total;
		$('#tablaProductos tfoot').children('tr').get(0).cells[2].innerHTML = total;

		tablaProductos
		.row( $(this).parents('tr') )
		.remove()
		.draw();
	} );

</script>
<?php $this->end()?>

<!-- /.modal -->
