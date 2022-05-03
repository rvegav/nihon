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
	<h4>Atencion - Listado de Agendamientos</h4>
	<div class="row">
		<div class="col-12">
			<table class="table table-bordered" id="tablaCliente" width="100%">
				<thead>
					<tr>
						<th class="text-center">Codigo</th>
						<th class="text-center">Mascota</th>
						<th class="text-center">Dueño</th>
						<th class="text-center">Fecha de agendamiento</th>
						<th class="text-center">Motivo</th>
						<th class="text-center">Tipo Servicio</th>
						<th class="text-center">Estado</th>
						<th class="text-center">Operaciones</th>
					</tr>
				</thead>
				<tbody>
					<?php if(!empty($agendamientos)):?>
						<?php
						foreach($agendamientos as $agendamiento):?>
							<tr>
								<td class="text-center"><?php echo $agendamiento->age_id; ?></td>
								<td class="text-center"><?php echo $agendamiento->age_mascota;?></td>
								<td class="text-center"><?php echo $agendamiento->age_duenho;?></td>
								<td class="text-center"><?php echo $agendamiento->age_fecha_creacion;?></td>
								<td class="text-center"><?php echo $agendamiento->age_motivo_agendamiento;?></td>
								<td class="text-center"><?php echo $agendamiento->prod_descripcion;?></td>

								<?php
								$estado = $agendamiento->age_estado;
								if($estado == 1){
									$estado2     = "Pendiente";$label_class = 'label-success';
								}else{
									if($estado == 2){
										$estado2     = "Atendido";$label_class = 'label-warning';
									}else{
										$estado2     = "Anulado";$label_class = 'label-danger';
									}
								}
								;?>
								<td><span class="label <?php echo $label_class;?>"><?php echo $estado2; ?></span></td>
								<td>
									<a href="<?php echo base_url();?>atender_agendamiento/<?php echo $agendamiento->age_id;?>" class="btn btn-warning" data-toggle="tooltip" data-placement="top" title="Atender Expediente"><i class="fa fa-edit"></i></a>
									<?php if ($estado ==2): ?>
										<a href="<?php echo base_url();?>delete_agendamiento/<?php echo $agendamiento->age_id;?>" class="btn btn-danger btn-delete eliminar"><i class="fa fa-cash"></i></a>
									<?php else: ?>
										<a href="<?php echo base_url();?>delete_agendamiento/<?php echo $agendamiento->age_id;?>" class="btn btn-danger btn-delete eliminar"><i class="fa fa-trash"></i></a>

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
	var tabla = $("#tablaCliente").DataTable({
		'lengthMenu':[[10, 15, 20], [10, 15, 20]],
		'paging':true,
		'info':true,
		'filter':true,
		'stateSave':false,
		'processing':true,
		// 'scrollX':true,	
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
