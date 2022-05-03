<?php $this->layout('v_master')?>
<?php $this->start('contenido')?>
<?php $CI =& get_instance(); ?>
<div class="card">
	<div class="card-header">
		<h4>Editar Productos</h4>
	</div>
	<div class="card-body">
		<form id="frm_producto" data-parsley-validate="" class="" action="" method="POST">
			<input type="hidden" name="inve_id" id="inve_id" value="<?php echo $inventario->inve_id ?>">
			<div class="row">
				<div class="col-md-4 offset-3">
					<label class="" for="desCiudad">Producto <span class="required">*</span></label>
					<div id="custom-search-input">
						<div class="input-group">
							<input value="<?php echo $inventario->prod_id ?>" type="hidden" name="prod_id" id="prod_id">	
							<input value="<?php echo $inventario->prod_descripcion ?>" type="text" name="producto" id="producto" class="form-control" placeholder="Buscar Producto" disabled="disabled" required="required"/>
							<span class="input-group-btn">
								<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#producto_select">
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
					<label class="" for="desCiudad">Cantidad Inicial <span class="required">*</span></label>
					<div class="input-group">
						<input value="<?php echo $inventario->inve_cantidad ?>" type="text" id="desProducto" placeholder="Cantidad Inicial" font style="text-transform: uppercase;" onkeyup="javascript:this.value = this.value.toUpperCase ();"   name="cantidad_inicial" class="form-control">
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-4 offset-3">
					<label class="" for="desCiudad">Cantidad Minima <span class="required">*</span></label>
					<div class="input-group">
						<input value="<?php echo $inventario->inve_cantidad_minima ?>" type="text" id="marcaProducto" placeholder="Cantidad Minima" font style="text-transform: uppercase;" onkeyup="javascript:this.value = this.value.toUpperCase ();"   name="cantidad_minima" class="form-control">
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-4 offset-3">
					<label class="" for="desCiudad">Precio venta <span class="required">*</span></label>
					<div class="input-group">
						<input value="<?php echo $inventario->inve_precio_venta ?>" type="text" id="marcaProducto" placeholder="Precio Venta" font style="text-transform: uppercase;" onkeyup="javascript:this.value = this.value.toUpperCase ();"   name="precio_venta" class="form-control">
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-4 offset-3">
					<label class="" for="desCiudad">Precio compra <span class="required">*</span></label>
					<div class="input-group">
						<input value="<?php echo $inventario->inve_precio_compra ?>" type="text" id="marcaProducto" placeholder="Precio Compra" font style="text-transform: uppercase;" onkeyup="javascript:this.value = this.value.toUpperCase ();"   name="precio_compra" class="form-control">
					</div>
				</div>
			</div>
			<hr>
			<div class="row">

				<div class="col-md-6 col-sm-6 col-xs-12 offset-3">
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
				<h4 class="modal-title">Lista de Productos</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			</div>
			<div class="modal-body">
				<table class="table table-bordered" id="tablaProductos" width="100%">
					<thead>
						<tr>
							<th class="text-center">Codigo</th>
							<th class="text-center">Descripcion</th>
							<th class="text-center">Proveedor</th>
							<th class="text-center">Tipo Producto</th>
							<th class="text-center">Operaciones</th>
						</tr>
					</thead>
					<tbody>
						<?php if(!empty($productos)):?>
							<?php
							foreach($productos as $productos):?>
								<tr>
									<td><?php echo $productos->prod_id; ?></td>
									<td><?php echo $productos->prod_descripcion;?></td>
									<td><?php echo $productos->prov_descripcion;?></td>
									<td><?php echo $productos->tipr_descripcion;?></td>
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
	var tabla = $("#tablaProductos").DataTable({
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
	$('#tablaProductos tbody').on('click', 'tr', function (event) {
		var data = tabla.row(this).data();
		$('#prod_id').val(data[0]);
		$('#producto').val(data[1]);
		$('#producto_select').modal('hide');
	} );

	$("#frm_producto").submit(function(event) {
		event.preventDefault();		
		var formDato = $(this).serialize();
		$.ajax({
			url: "<?php echo base_url()?>update_producto_stock",
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
				window.location = "<?php echo base_url()?>stock";
			}
		}).fail(function() {
			alert("Se produjo un error, contacte con el soporte técnico");
		});
	})

</script>
<?php $this->end()?>

<!-- /.modal -->
