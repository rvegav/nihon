<style type="text/css">
	.my-custom-scrollbar {
		position: relative;
		height: 100px;
		overflow: auto;
	}
	.table-wrapper-scroll-y {
		display: block;
	}
</style>
<div class="right_col" role="main">
	<div class="page-title">
		<div class="title_left">
			<h3>
				Usuarios
			</h3>
		</div>
	</div>
	<div class="clearfix"></div>
	<div class="row">
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="x_panel">
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
			<?php if($this->session->flashdata("error")): ?>
				<div class="alert alert-danger" role="alert">
					<button type="button" class="close" data-dismiss="alert">
						&times;
					</button>
					<strong>
						¡Error!
					</strong>
					<p>
						<?php echo $this->session->flashdata("error")?>
					</p>
				</div>
			<?php endif; ?>

			<div class="x_title">
				<h2>
					Usuarios  | Agregar 
				</h2>
				<ul class="nav navbar-right panel_toolbox">
					<li>
						<a class="collapse-link">
							<i class="fa fa-chevron-up">
							</i>
						</a>
					</li>
					<li>
						<a class="close-link">
							<i class="fa fa-close">
							</i>
						</a>
					</li>
				</ul>
				<div class="clearfix"></div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<form id="form-user" data-parsley-validate="" class="form-horizontal form-label-left" action="" method="POST" novalidate="">

						<div class="form-group">
							<div class="row">
								<div class="col-md-3" >
									<div class="col-md-10 col-md-offset-1">
										
										<h3>Perfil de Usuario</h3>
									</div>

									<div class="profile_img">
										<div id="crop-avatar">
											<!-- Current avatar -->
											<img class="card-img-top imagenredonda" id="imgSalida" src="<?php echo base_url();?>assets/perfil.png">
										</div>
									</div>
								</div>
								<div class="col-md-9">
									<div class="row">
										<div class="col-md-6">
											<label class="control-label col-md-3 col-sm-3 col-xs-12">Empleado:</label>
											<div class="input-group">
												<input type="hidden" name="idempleado" id="idempleado" >
												<input type="text" name="" id="empleado" placeholder="Buscar Empleado" class="form-control" disabled="disabled" />
												<span class="input-group-btn">
													<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-empleado">
														<i class="fa fa-search" aria-hidden="true">
															
														</i>
													</button>
												</span>
											</div>

										</div>
										<div class="col-md-6">
											<label class="control-label col-md-5 col-sm-5 col-xs-12">Nombre de Usuario:</label>
											<div class="input-group">
												<input class="form-control" type="text" name="username" placeholder="Usuario">
											</div>
										</div>
									</div>
									<br>
									<div class="row">
										<div class="col-md-6">
											<div class="row">
												<div class="form-group col-md-6">
													<div class="input-group">
														<span class="input-group-addon">Roles:</span>
														<select name="EMPLEADO1_detalle" id="roles" class="form-control select2">
															<option>Seleccione un Rol</option>
															<?php foreach($roles as $rol):?>
																<option value="<?php echo $rol->IDROL;?>"><?php echo $rol->DESCRIPCION;?></option>
															<?php endforeach;?>
														</select>
													</div>
												</div>
												<div class="col-md-6">
													<button  type="button" id="btn-agregar" class="btn btn-block"><i class="fa fa-plus"></i></button>
												</div>
											</div>
											<div class="row">
												<div class="col-md-12">
													<div class="table-wrapper-scroll-y my-custom-scrollbar">
														<table class="table table-responsive table-bordered" id="roles_seleccionados">
															<thead>
																<tr>
																	<th>Item</th>
																	<th>Rol</th>
																	<th>Accion</th>
																</tr>
															</thead>
															<tbody>

															</tbody>
														</table>
														
													</div>
													
												</div>
											</div>
										</div>
										<div class="col-md-6">
											<div class="row">
												
												<label class="control-label col-md-5 col-sm-5 col-xs-12">Contraseña Generada:</label>
												<div class="input-group">
													<input class="form-control" type="text" name="pass_inicial" id="pass_inicial">
												</div>
												<div class="row">
													<div class="col-md-5 col-md-offset-5">
														<button class="btn btn-success btn-block " type="button" id="generar_pass">Generar Contraseña</button>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>



							<div class="ln_solid"></div>
							<div class="form-group">
								<div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
									<button type="reset" class="btn btn-primary">Resetear</button>
									<button type="submit" class="btn btn-success">Guardar Usuario</button>
								</div>
							</div>

						</form>

					</div> <!-- /COL  12-->
				</div><!-- /ROW -->
			</div><!-- / content -->
		</div>
	</div>
</div>
</div>
<div class="modal fade" id="modal-empleado">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title">Lista de Empleados</h4>
				</div>
				<div class="modal-body">
					<table id="example2" class="table table-responsive table-bordered table-striped table-hover">
						<thead>
							<tr>
								<th>Nro. Cedula</th>
								<th>Nombre</th>
								<th>Opcion</th>
							</tr>
						</thead>
						<tbody>
							<!--  <?php print_r($empleados);?>-->
							<?php

                                //echo "Esta es mi quinta frase hecha con Php!" ;
							if(!empty($empleados)):?>

								<?php
								foreach($empleados as $empleado):?>
									<tr>
										<td>
											<?php echo $empleado->CEDULAIDENTIDAD;?>
										</td>
										<td>
											<?php echo $empleado->NOMBRE;?>

										</td>
										<?php $dataEmpleado = $empleado->CEDULAIDENTIDAD.'*'.$empleado->NOMBRE?>

										<td>
											<button type = "button" class="btn btn-success checkFuncionario" value="<?php echo $empleado->IDEMPLEADO;?>"><span class= "fa fa-check"></span></button>
										</td>
									</tr>
								<?php endforeach; ?>
							<?php endif; ?>
						</tbody>
					</table>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-danger pull-left" data-dismiss="modal">Cerrar</button>
				</div>
			</div>
			<!-- /.modal-content -->
		</div>
		<!-- /.modal-dialog -->
	</div>
	<script type="text/javascript">
		$(".btn-check2").on("click", function(){
			var empleado = $(this).val();
			infoEmpleado = empleado.split("*");
			
		});
		$(".checkFuncionario").on("click", function(){
			funcionario = $(this).val();
			console.log(funcionario);
			$.ajax({
				type:'POST',
				url:'<?php echo base_url()?>getEmpleado',
				data: {funcionario:funcionario},
			})
			.done(function (data){
				var r = JSON.parse(data);
				console.log(r);
				$('#empleado').val(r.EMPLEADO);
				$('#idempleado').val(r.IDEMPLEADO);
				$("#modal-empleado").modal("hide");
			})
			.fail(function(){
				alert('ocurrio un error interno, contacte con Rolo');
			});

		});
		var item = 0;
		$("#btn-agregar").on("click", function(){
			item++;
			html = '<tr>';
			html += '<td>';
			html += item;
			html += '</td>';
			html += '<td>';
			html += '<input type="hidden" id="modulo" name="roles[]" value="'+ $("SELECT#roles option:selected").val() + '" >';
			html += $("SELECT#roles option:selected").text();
			html += '</td>';
			html += '<td>';
			html += '<button type="button" class="btn btn-danger"><i class="fa fa-trash"></i></button>';
			html += '</td>';
			html += '<tr>'
			$("#roles_seleccionados tbody").append(html);
		});
		$('#form-user').submit(function(event) {
			event.preventDefault();
			var formDato = $(this).serialize();
			$.ajax({
				url: "<?php echo base_url()?>store_user",
				type: 'POST',
				data: formDato,
			})
			.done(function(result) {
				var r = JSON.parse(result);
				$("#mdlAguarde").modal('hide');
				console.log(r);
				const wrapper = document.createElement('div');
				if (r['alerta']!="") {
					var mensaje = r['alerta'];
					wrapper.innerHTML = mensaje;
					swal({
						title: 'Atención!', 
						content: wrapper,
						icon: "warning",
						columnClass: 'medium',

					});
				}
				if (r['error']!="") {
					wrapper.innerHTML = r['error'];
					swal({
						icon: "error",
						columnClass: 'medium',
						theme: 'modern',
						title: 'Error!',
						content: wrapper,
					});
				}
				if (r['correcto']!="") {
					wrapper.innerHTML = r['error'];
					swal({
						icon: "Correcto",
						columnClass: 'medium',
						theme: 'modern',
						title: 'Correcto!',
						content: wrapper,
					});
					// window.location = "<?php echo base_url()?>empleados/add";
				}
			}).fail(function() {
				alert("Se produjo un error, contacte con el soporte técnico");
				$("#mdlAguarde").modal('hide');
			});
		});
		$("#generar_pass").on("click", function(){
			$.ajax({
				url: "<?php echo base_url()?>generar_pass",
				type: 'POST',
				// data: formDato,
			})
			.done(function(result) {
				var r = JSON.parse(result);
				console.log(r);
				$('#pass_inicial').val(r);
			}).fail(function() {
				alert("Se produjo un error, contacte con el soporte técnico");
				$("#mdlAguarde").modal('hide');
			});
		});
	</script>