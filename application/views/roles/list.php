
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
	<h4>Listado de Roles</h4>
	<br>
	<div class="row">
		<div class="col-md-12 offset-10">
			<a href="<?php echo base_url();?>add_rol" class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="Agregar Nuevo Rol">
				<i class="fa fa-plus"></i> Agregar Roles
			</a>
		</div>
	</div>
	<br>
	<div class="row">
		<div class="col-md-12">
			<table id="example2" class="table table-striped table-bordered btn-hover">
				<thead>
					<tr>
						<th class="text-center">Código Rol</th>
						<th class="text-center">Descripcion</th>
						<th class="text-center">Fecha de Grabacion</th>
						<th class="text-center">Estado</th>
						<th class="text-center">Opciones</th>
					</tr>
				</thead>
				<tbody>
					<?php
					if(!empty($roles)):?>
						<?php
						foreach($roles as $rol):?>
							<tr>
								<td><?php echo $rol->rol_id; ?></td>
								<td><?php echo $rol->rol_descripcion;?></td>
								<td><?php echo $rol->rol_fecha_creacion;?></td>
								<td><?php echo $rol->rol_fecha_modificacion;?></td>
								<td>
									<button type="button" class="btn btn-primary btn-view" data-toggle="modal" data-target="#modal-view" value="<?php echo $rol->rol_id;?>">
										<i class="fa fa-eye"></i>
									</button>
									<a href="<?php echo base_url();?>edit_rol/<?php echo $rol->rol_id;?>" class="btn btn-warning">
										<i class="fa fa-edit"></i>
									</a>
									<a href="<?php echo base_url();?>delete_rol/<?php echo $rol->rol_id;?>" id="" class="btn btn-danger btn-delete eliminar">
										<i class="fa fa-trash"></i>
									</a>

								</td>
							</tr>
						<?php endforeach; ?>
					<?php endif; ?>
				</tbody>
			</table>
		</div> <!-- /COL  12-->
	</div><!-- /ROW -->
</div><!-- / content -->

<!-- Modal -->
<div class="modal fade" id="modal-view">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="myModalLabel"><i class='fa fa-eye'></i> Ver Detalles del Rol </h4>
				<!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button> -->
			</div>
			<div class="modal-body">
				<div class="table-responsive">
					<table class="table" id="table_detalle">
						<thead>
							<th>Modulo</th>
							<th>Pantalla</th>
							<th>Insercion</th>
							<th>Actualizacion</th>
							<th>Borrado</th>
							<th>Visualizacion</th>
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
<script type="text/javascript" src = " https://unpkg.com/sweetalert/dist/sweetalert.min.js "></script>
<script>

	$(".btn-view").on("click", function(){
		var id= $(this).val();
		var objetoDataTable_detalle = $('#table_detalle').DataTable({
			'lengthMenu':[[5, 10, 15], [5, 10, 15]],
			'paging':true,
			'info':true,
			'filter':true,
			'stateSave':true,
			'processing':true,
			'deferRender':true,
			'searching':false,
			'ajax':{
				"url":"<?php echo base_url()?>view_detalle_rol",
				"type":"POST",
				"data":function(data){
					data.id=id;
				}
			},
			'language':lenguaje,
			'columns':[
			{data:'MODULO'},
			{data:'PANTALLA'},
			{data:'INSERCION','sClass':'text-center'},
			{data:'ACTUALIZACION','sClass':'text-center'},
			{data:'BORRADO','sClass':'text-center'},
			{data:'VISUALIZACION','sClass':'text-center'},
			],
		});
	});
	$('#cerrar').on('click', function(){
		$('#table_detalle').DataTable().destroy();
	});

</script>|
<?php $this->end()?>
