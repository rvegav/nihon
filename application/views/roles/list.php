
<?php $this->layout('v_master')?>
<?php $this->start('contenido')?>
<?php $CI =& get_instance(); ?>
<div class="card">
	<h4>Listado de Roles</h4>
	<br>
	<div class="row">
		<div class="col-md-12 offset-10">
			<a href="<?php echo base_url();?>add_roles" class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="Agregar Nuevo Rol">
				<i class="fa fa-plus"></i> Agregar Roles
			</a>
		</div>
		<?php
		if($CI->session->flashdata("success")): ?>
			<div class="alert alert-success" role="alert">
				<button type="button" class="close" data-dismiss="alert">
					&times;
				</button>
				<strong>
					¡Buen Trabajo!
				</strong>
				<p>
					<?php echo $CI->session->flashdata("success")?>
				</p>
			</div>
		<?php endif; ?>
		<?php
		if($CI->session->flashdata("error")): ?>
			<div class="alert alert-success" role="alert">
				<button type="button" class="close" data-dismiss="alert">
					&times;
				</button>
				<strong>
					¡Buen Trabajo!
				</strong>
				<p>
					<?php echo $CI->session->flashdata("error")?>
				</p>
			</div>
		<?php endif; ?>
	</div>
	<br>
	<div class="row">
		<div class="col-md-12">
			<table id="example2" class="table table-striped table-bordered btn-hover">
				<thead>
					<tr>
						<th class="text-center">#</th>
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
								<td><?php echo $rol->IDROL; ?></td>
								<td><?php echo $rol->NUMROL	;?></td>
								<td><?php echo $rol->DESCRIPCION;?></td>
								<td><?php echo $rol->FECGRA;?></td>
								<?php
								$estado = $rol->estadoEmpleado;
								$estado = 1;
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
									<button type="button" class="btn btn-primary btn-view" data-toggle="modal" data-target="#modal-view" value="<?php echo $rol->IDROL;?>">
										<i class="fa fa-eye"></i>
									</button>
									<a href="<?php echo base_url();?>roles/roles/edit/<?php echo $rol->IDROL;?>" class="btn btn-warning">
										<i class="fa fa-edit"></i>
									</a>
									<a href="<?php echo base_url();?>roles/roles/delete/<?php echo $rol->IDROL;?>" id="<?=$rol->IDROL;?>" class="btn btn-danger btn-delete eliminar">
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
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel"><i class='fa fa-eye'></i> Ver Detalles del Cargo </h4>
			</div>
			<div class="modal-body">
				<!--en esta parte se carga los datos de la vista view-->
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
			</div>
		</div>
	</div>
</div>
<?php $this->stop()?>
<?php $this->push('scripts')?>
<!--<?php // $this->load->view('template/footer');?>-->
<script type="text/javascript" src = " https://unpkg.com/sweetalert/dist/sweetalert.min.js "></script>
<script>
	$(document).ready(function(){
		var base_url= "<?php echo base_url();?>";
       // alert (base_url);
       $(".btn-view").on("click", function(){
       	var id= $(this).val();
       	$.ajax({
       		url: base_url + "cargos/cargos/view/" + id,
       		type: "POST",
       		success:function(resp){
       			$("#modal-view .modal-body").html(resp);
       		}
       	});
       })
        	//esto lee el boton eliminar y envia via ajax
        	$(".btn-delete").on("click", function(e){
        		e.preventDefault();
        		var ruta= $(this).attr("href");
        		$.ajax({
        			url: ruta,
        			type: "POST",
        			success:function(resp){
					//se redirige a base url con la respuesta
					window.location.href= base_url + resp;	
				}
			});
        	})
        })    	


	function eliminar__(id){
		if(confirm("Esta seguro que desea eliminar este registro?")){

			window.location.href = "<?php echo base_url(); ?>/cargos/cargos/delete/" + id;

		}
	}

	$(".eliminar").click(function(e){
		e.preventDefault();
		var id = $(this).attr('href');
		swal({
			title: "Atención",
			text: "Esta seguro de eliminarlo de forma permanente",
			icon: "warning",
			buttons: true,
			dangerMode: true,
		})
		.then((willDelete) => {
			if (willDelete) {
				window.location.href = id;
			}
		});
	});
</script>|
<?php $this->end()?>
