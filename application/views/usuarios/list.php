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
	<h4>Listado de Usuarios</h4>
	<br>
	<div class="row">
		<div class="col-md-2 offset-10">
			<a href="<?php echo base_url()?>add_usuario" class="nav-link">
				<button type="button" id="Agregar" class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="Agregar Nueva Usuario"><i class="fa fa-plus"></i>Agregar Usuario</button>
			</a>
		</div>

	</div>
	<br>
	<div class="row">
		<div class="col-md-12">
			<div class="table-responsive">
				<table class="table table-bordered" id="tablausuario" width="100%">
					<thead>
						<tr>
							<th class="text-center">Codigo</th>
							<th class="text-center">Nombre de usuario</th>
							<th class="text-center">Nombre del empleado</th>
							<th class="text-center">Fecha Creacion</th>
							<th class="text-center">Ultima Modificacion</th>
							<th class="text-center">Estado</th>
							<th class="text-center">Opciones</th>
						</tr>
					</thead>
					<tbody>
						<?php if(!empty($usuarios)):?>
							<?php
							foreach($usuarios as $usuario):?>
								<tr>
									<td><?php echo $usuario->usua_id; ?></td>
									<td><?php echo $usuario->usua_name;?></td>
									<td><?php echo $usuario->usua_empleado;?></td>
									<td><?php echo $usuario->usua_fecha_creacion;?></td>
									<td><?php echo $usuario->usua_fecha_modificacion;?></td>

									<?php
									$estado = $usuario->usua_estado;
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
										<button type="button" class="btn btn-primary btn-view" data-toggle="modal" data-target="#modal-view" value="<?php echo $usuario->usua_id;?>">
											<i class="fa fa-eye"></i>
										</button>
										<a href="<?php echo base_url();?>edit_usuario/<?php echo $usuario->usua_id;?>" class="btn btn-warning"><i class="fa fa-edit"></i></a>
										<?php if ($estado!=2): ?>
											<a href="<?php echo base_url();?>delete_usuario/<?php echo $usuario->usua_id;?>" class="btn btn-danger btn-delete eliminar"><i class="fa fa-trash"></i></a>
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
</div>

<!-- Modal -->
<div class="modal fade" id="modal-view">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="myModalLabel"><i class='fa fa-eye'></i> Ver Detalles Usuarios </h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			</div>
			<div class="modal-body">
				<div class="table-responsive">
					<table class="table" id="tabla_roles" width="100%">
						<thead>
							<tr>
								<th>Codigo Rol</th>
								<th>Descripcion</th>
							</tr>
						</thead>
					</table>
					
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-danger" data-dismiss="modal" id="cerrar">Cerrar</button>
			</div>
		</div>
	</div>
</div>
<?php $this->stop()?>
<?php $this->push('scripts')?>
<!--<?php // $this->load->view('template/footer');?>-->
<!-- <script type="text/javascript" src = " https://unpkg.com/sweetalert/dist/sweetalert.min.js "></script> -->
<script >
	var tabla = $("#tablausuario").DataTable({
		'lengthMenu':[[10, 15, 20], [10, 15, 20]],
		'paging':true,
		'info':true,
		'filter':true,
		'stateSave':true,
		'processing':true,
		//'scrollX':true,
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
	$(".btn-view").on("click", function(){
		var id= $(this).val();
		var objetoDataTable_detalle = $('#tabla_roles').DataTable({
			'lengthMenu':[[5, 10, 15], [5, 10, 15]],
			'paging':true,
			'info':true,
			'filter':true,
			'stateSave':true,
			'processing':true,
			'deferRender':true,
			'searching':false,
			'ajax':{
				"url":"<?php echo base_url()?>view_rol_usuario",
				"type":"POST",
				"data":function(data){
					data.id=id;
				}
			},
			'language':lenguaje,
			'columns':[
			{data:'ID'},
			{data:'DESCRIPCION','sClass':'text-center'},
			],
		});
	});
	$('#cerrar').on('click', function(){
		$('#tabla_roles').DataTable().destroy();
	});
</script>
<?php $this->end()?>