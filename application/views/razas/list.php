<?php $this->layout('v_master')?>
<?php $this->start('contenido')?>
<?php $CI =& get_instance(); ?>
<div class="card">
	<div class="col-md-12" align="right">
		<?php
		if($CI->session->flashdata("success")): ?>
			<div class="alert alert-success" role="alert">
				<button type="button" class="close" data-dismiss="alert">
					&times;
				</button>
				<strong>
					¡Buen Trabajo!
				</strong>
				<p><?php echo $CI->session->flashdata("success")?></p>
			</div>
		<?php endif; ?>
		<?php 
		if($CI->session->flashdata("error")): ?>
			<div class="alert alert-danger" role="alert">
				<button type="button" class="close" data-dismiss="alert">
					&times;
				</button>
				<strong>
					¡Ha Ocurrido un error!
				</strong>
				<p>
					<?php echo $this->session->flashdata("error")?>
				</p>
			</div>
		<?php endif; ?>
	</div>
	<h4>Listado de Razas</h4>
	<br>
	<div class="row">
		<div class="col-md-2 offset-10">
			<a href="<?php echo base_url()?>add_raza" class="nav-link">
				<button type="button" id="Agregar" class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="Agregar Nueva Raza"><i class="fa fa-plus"></i>Agregar Razas</button>
			</a>
		</div>

	</div>
	<br>
	<div class="row">
		<div class="col-12">
			<table class="table table-bordered" id="tablaRaza" width="100%">
				<thead>
					<tr>
						<th class="text-center">Codigo</th>
						<th class="text-center">Descripcion</th>
						<th class="text-center">Especie</th>
						<th class="text-center">Fecha de Creacion</th>
						<th class="text-center">Ultima Modificacion</th>
						<th class="text-center">Estado</th>
						<th class="text-center">Opciones</th>
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
								<td><?php echo $raza->raz_fecha_creacion;?></td>
								<td><?php echo $raza->raz_fecha_modificacion;?></td>

								<?php
								$estado = $raza->raz_estado;
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
								<td><span class="label <?php echo $label_class;?>"><?php echo $estado2; ?></span></td>
								<td>
									<a href="<?php echo base_url();?>edit_raza/<?php echo $raza->raz_id;?>" class="btn btn-warning"><i class="fa fa-edit"></i></a>
									<?php if ($estado!=2): ?>
										<a href="<?php echo base_url();?>delete_raza/<?php echo $raza->raz_id;?>" class="btn btn-danger btn-delete eliminar"><i class="fa fa-trash"></i></a>
									<?php endif ?>
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
	var tabla = $("#tablaRaza").DataTable({
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
