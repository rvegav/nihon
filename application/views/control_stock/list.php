<?php $this->layout('v_master')?>
<?php $this->start('contenido')?>
<?php $CI =& get_instance(); ?>
<div class="card">
	<h4>Inventario</h4>
	<br>
	<div class="row">
		<div class="col-md-3 offset-7">
		<?php if ($productos_revision>0): ?>
			<div class="p-2 mb-2 mt-2 bg-danger text-white"><?php echo $productos_revision ?> Productos requieren revision</div>
			
		<?php endif ?>
		</div>
		<div class="col-md-2">
			<a href="<?php echo base_url()?>add_producto_stock" class="nav-link">
				<button type="button" id="Agregar" class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="Agregar Nuevo Producto"><i class="fa fa-plus"></i>Agregar Producto</button>
			</a>
		</div>

	</div>
	<br>
	<div class="row">
		<div class="col-12">
			<table class="table table-bordered" id="tablaProducto" width="100%">
				<thead>
					<tr>
						<th class="text-center">Codigo</th>
						<th class="text-center">Producto</th>
						<th class="text-center">Marca</th>
						<th class="text-center">Tipo Producto</th>
						<th class="text-center">Proveedor</th>
						<th class="text-center">Cantidad</th>
						<th class="text-center">Precio Venta</th>
						<th class="text-center">Precio Compra</th>
						<th class="text-center">Ultima Modificacion</th>
						<th class="text-center">Opciones</th>
					</tr>
				</thead>
				<tbody>
					<?php if(!empty($inventarios)):?>
						<?php
						foreach($inventarios as $inventario):?>
							<tr>
								<td><?php echo $inventario->prod_id; ?></td>
								<td><?php echo $inventario->prod_descripcion;?></td>
								<td><?php echo $inventario->prod_marca;?></td>
								<td><?php echo $inventario->tipr_descripcion;?></td>
								<td><?php echo $inventario->prov_descripcion;?></td>
								<td><?php echo $inventario->inve_cantidad;?>/<?php echo $inventario->inve_cantidad_minima;?></td>
								<td><?php echo $inventario->inve_precio_venta;?> </td>
								<td><?php echo $inventario->inve_precio_compra;?> </td>
								<td><?php echo $inventario->inve_fecha_modificacion;?></td>
								<td>
									<a href="<?php echo base_url();?>edit_producto_stock/<?php echo $inventario->inve_id;?>" class="btn btn-warning"><i class="fa fa-edit"></i></a>
								</td>
							</tr>
						<?php endforeach; ?>
					<?php endif; ?>
				</tbody>
			</table>
		</div>

	</div>
</div>
<?php $this->stop()?>
<?php $this->push('scripts')?>
<script type="text/javascript">
	var tabla = $("#tablaProducto").DataTable({
		'lengthMenu':[[10, 15, 20], [10, 15, 20]],
		'paging':true,
		'info':true,
		'filter':true,
		'stateSave':true,
		'processing':true,
		////'scrollX':true,
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
</script>
<?php $this->end()?>
