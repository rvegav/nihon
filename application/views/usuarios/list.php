<!-- page content -->
<div class="right_col" role="main">
	<div class="page-title">
		<div class="title_left">
			<h3>
				Gestion de Usuarios
			</h3>
		</div>
	</div>
	<div class="clearfix">
	</div>
	<div class="row">
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="col-md-12" align="right">
				<a href="<?php echo base_url();?>Usuarios/usuario/add" class="btn btn-dark">
					Agregar Usuarios
				</a>
				<?php
				if($this->session->flashdata("success")): ?>
					<div class="alert alert-success" role="alert">
						<button type="button" class="close" data-dismiss="alert">
							&times;
						</button>
						<strong>
							¡Buen Trabajo!
						</strong>
						<p>
							<?php echo $this->session->flashdata("success")?>
						</p>
					</div>
				</div>
			<?php endif; ?>
			<?php
			if($this->session->flashdata("error")): ?>
				<div class="alert alert-success" role="alert">
					<button type="button" class="close" data-dismiss="alert">
						&times;
					</button>
					<strong>
						¡Buen Trabajo!
					</strong>
					<p>
						<?php echo $this->session->flashdata("error")?>
					</p>
				</div>
			<?php endif; ?>
			<div class="x_panel">
				<div class="x_title">
					<h2>
						Lista de Usuarios
					</h2>
					
					<div class="clearfix">
					</div>
				</div>
				<div class="row">
					<div class="col-md-12">
						<table id="example2" class="table table-striped table-bordered btn-hover">
							<thead>
								<tr>
									<th>#</th>
									<th>Empleado</th>
									<th>Usuario</th>
									<!-- <th>Rol</th> -->
									<th>Fecha de Grabacion</th>
									<th>Estado</th>
									<th>Opciones</th>
								</tr>
							</thead>
							<tbody>
								<?php
								if(!empty($usuarios)):?>
									<?php
									foreach($usuarios as $usuario):?>
										<tr>
											<td><?php echo $usuario->IDUSUARIO; ?></td>
											<td><?php echo $usuario->USERNAME; ?></td>
											<td><?php echo $usuario->NOMBRE;?></td>
											<td><?php echo $usuario->FECHA_GRABACION;?></td>
											<?php
											$estado = $usuario->ESTADO;
											if($estado == 1)
											{
												$estado2     = "Activo";$label_class = 'label-success';
											}
											else
											{
												if($estado == 2)
												{
													$estado2     = "Inactivo";$label_class = 'label-warning';
												}
												else
												{
													$estado2     = "Anulado";$label_class = 'label-danger';
												}
											}

											;?>
											<td>
												<span class="label <?php echo $label_class;?>">
													<?php echo $estado2; ?>
												</span>
											</td>

											<td>

												<button type="button" class="btn btn-primary btn-view" data-toggle="modal" data-target="#modal-view" value="<?php echo $usuario->IDUSUARIO;?>">
													<i class="fa fa-eye">
													</i>
												</button>
												<a href="<?php echo base_url();?>Usuarios/usuario/edit/<?php echo $usuario->IDUSUARIO;?>" class="btn btn-warning">
													<i class="fa fa-edit">
													</i>
												</a>
												<a href="<?php echo base_url();?>Usuarios/usuario/delete/<?php echo $usuario->IDUSUARIO;?>" id="<?=$usuario->IDUSUARIO;?>" class="btn btn-danger btn-delete eliminar">
													<i class="fa fa-trash">
													</i>
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
		</div>
	</div>
</div>
</div>


<!-- Modal -->
<div class="modal fade" id="modal-view">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel"><i class='fa fa-eye'></i> Ver Detalles Usuarios </h4>
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
<!--<?php // $this->load->view('template/footer');?>-->
<script type="text/javascript" src = " https://unpkg.com/sweetalert/dist/sweetalert.min.js "></script>
<script>
		$(".eliminar").click(function(e){
			e.preventDefault();
			var id = $(this).attr('id');
			swal({
				title: "Atención",
				text: "Esta seguro de eliminarlo de forma permanente",
				icon: "warning",
				buttons: true,
				dangerMode: true,
			})
			.then((willDelete) => {
				if (willDelete) {
					window.location.href = "" + id;
				}
			});
		});


	</script>