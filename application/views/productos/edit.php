<?php $this->layout('v_master')?>
<?php $this->start('contenido')?>
<?php $CI =& get_instance(); ?>
<div class="card">
	<div class="card-header">
		<h4>Editar Productos</h4>
	</div>
	<div class="card-body">
		<form id="frm_producto" data-parsley-validate="" class="" action="" method="POST">
			<div class="row">
				<div class="col-md-4 offset-3">
					<label for="prod_id">Código Producto<span class="required">*</span></label>
					<div class="input-group">
						<input type="text" class="form-control" id="prod_id" name="prod_id" readonly value="<?php echo $producto->prod_id;?>">
					</div>	
				</div>
			</div>
			<div class="row">
				<div class="col-md-4 offset-3">
					<label class="" for="desCiudad">Descripcion <span class="required">*</span></label>
					<div class="input-group">
						<input type="text" id="desProducto" placeholder="Descripcion" font style="text-transform: uppercase;" onkeyup="javascript:this.value = this.value.toUpperCase ();"   name="desProducto" class="form-control" value="<?php echo $producto->prov_descripcion ?>">
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-4 offset-3">
					<label class="" for="desCiudad">Marca <span class="required">*</span></label>
					<div class="input-group">
						<input type="text" id="marcaProducto" placeholder="Marca" font style="text-transform: uppercase;" onkeyup="javascript:this.value = this.value.toUpperCase ();"   name="marcaProducto" class="form-control"  value="<?php echo $producto->prod_marca ?>">
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-4 offset-3">
					<label class="" for="desCiudad">Proveedor <span class="required">*</span></label>
					<div id="custom-search-input">
						<div class="input-group">
							<input type="hidden" name="prov_id" id="prov_id" value="<?php echo $producto->prov_id ?>">	
							<input type="text" name="proveedor" id="proveedor" class="form-control" placeholder="Buscar Proveedor" disabled="disabled" required="required" value="<?php echo $producto->prov_descripcion ?>">
							<span class="input-group-btn">
								<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#proveedor_select">
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
					<label class="" for="desCiudad">Tipo Producto<span class="required">*</span></label>
					<div id="custom-search-input">
						<div class="input-group">
							<input type="hidden" name="tipr_id" id="tipr_id" value="<?php echo $producto->tipr_id ?>">	
							<input type="text" name="tipo_producto" id="tipo_producto" class="form-control" placeholder="Buscar Tipo Producto" disabled="disabled" required="required" value="<?php echo $producto->tipr_descripcion ?>">
							<span class="input-group-btn">
								<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#tipo_producto_select">
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
					<?php
					$estado = $producto->prod_estado;
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
						<option value="<?php echo $producto->prod_estado ?>"><?php echo $estado2 ?></option>
						<optgroup label="Estado a Asignar"></optgroup>
						<option value="1">Activo</option>
						<option value="2">Inactivo</option>
					</select>
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
<div class="modal fade" id="proveedor_select">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Lista de Proveedores</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			</div>
			<div class="modal-body">
				<table class="table table-bordered" id="tablaProveedores" width="100%">
					<thead>
						<tr>
							<th class="text-center">Codigo</th>
							<th class="text-center">Descripcion</th>
							<th class="text-center">Opciones</th>
						</tr>
					</thead>
					<tbody>
						<?php if(!empty($proveedores)):?>
							<?php
							foreach($proveedores as $proveedor):?>
								<tr>
									<td><?php echo $proveedor->prov_id; ?></td>
									<td><?php echo $proveedor->prov_descripcion;?></td>
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
<div class="modal fade" id="tipo_producto_select">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Lista de Tipo de Producto</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			</div>
			<div class="modal-body">
				<table class="table table-bordered" id="tablaTipoProducto" width="100%">
					<thead>
						<tr>
							<th class="text-center">Codigo</th>
							<th class="text-center">Descripcion</th>
							<th class="text-center">Opciones</th>
						</tr>
					</thead>
					<tbody>
						<?php if(!empty($tipo_productos)):?>
							<?php
							foreach($tipo_productos as $tipo_producto):?>
								<tr>
									<td><?php echo $tipo_producto->tipr_id; ?></td>
									<td><?php echo $tipo_producto->tipr_descripcion;?></td>
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
	var tabla = $("#tablaProveedores").DataTable({
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

	$('#tablaProveedores tbody').on('click', 'tr', function (event) {
		var data = tabla.row(this).data();
		$('#prov_id').val(data[0]);
		$('#proveedor').val(data[1]);
		$('#proveedor_select').modal('hide');
	} );
	$("#frm_producto").submit(function(event) {
		event.preventDefault();		
		var formDato = $(this).serialize();
		$.ajax({
			url: "<?php echo base_url()?>update_producto",
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
				window.location = "<?php echo base_url()?>productos";
			}
		}).fail(function() {
			alert("Se produjo un error, contacte con el soporte técnico");
		});
	})

</script>
<?php $this->end()?>

<!-- /.modal -->
