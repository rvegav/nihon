
<?php $this->layout('v_master')?>
<?php $this->start('contenido')?>
<?php $CI =& get_instance(); ?>
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
<div class="card">
	<div class="card-header">
		<h4>Agregar Usuarios</h4>
	</div>
	<div class="card-body">
		<div class="row">
			<div class="col-md-12">
				<form id="form-user" data-parsley-validate="" class="form-horizontal form-label-left" action="" method="POST" novalidate="">

					<div class="form-group">
						<div class="row">
							<div class="col-md-2" >
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
											<input type="hidden" name="empl_id" id="empl_id" >
											<input type="text" name="" id="empleado" placeholder="Buscar Empleado" class="form-control" disabled="disabled" />
											<span class="input-group-btn">
												<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-empleado">
													<i class="fa fa-search" aria-hidden="true"></i>
												</button>
											</span>
										</div>

									</div>
									<div class="col-md-6">
										<label class="control-label col-md-12">Nombre de Usuario:</label>
										<div class="input-group">
											<input class="form-control" type="text" name="username" placeholder="Usuario">
										</div>
									</div>
								</div>
								<br>
								<div class="row">
									<div class="col-md-6">
										<label class="control-label col-md-3">Roles:</label>
										<div class="input-group">
											<select name="" id="roles" class="form-control">
												<option>Seleccione un Rol</option>
												<?php foreach($roles as $rol):?>
													<option value="<?php echo $rol->rol_id;?>"><?php echo $rol->rol_descripcion;?></option>
												<?php endforeach;?>
											</select>
											<span class="input-group-btn">
												<button  type="button" id="btn-agregar" class="btn btn-block"><i class="fa fa-plus"></i></button>
											</span>
										</div>
										<br>
										<div class="row">
											<div class="col-md-12">
												<!-- <div class="table-wrapper-scroll-y my-custom-scrollbar"> -->
													<table class="table table-bordered" id="roles_seleccionados">
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

												<!-- </div> -->

											</div>
										</div>
									</div>
									<div class="col-md-6">

										<label class="control-label col-md-5 col-sm-5 col-xs-12">Contraseña Generada:</label>
										<div class="input-group">
											<input class="form-control" type="text" name="pass_inicial" id="pass_inicial">
										</div>

										<div class="col-md-6 mt-3">
											<button class="btn btn-success btn-block " type="button" id="generar_pass">Generar Contraseña</button>
										</div>

									</div>
								</div>
							</div>
						</div>
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

<div class="modal fade" id="modal-empleado">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Lista de Empleados</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			</div>
			<div class="modal-body">
				<div class="table-responsive">
					<table id="tablaEmpleado" class="table table-bordered table-striped table-hover">
						<thead>
							<tr>
								<th>Codigo</th>
								<th>Nro. Cedula</th>
								<th>Nombre</th>
								<th>Opcion</th>
							</tr>
						</thead>
						<tbody>
							<?php
							if(!empty($empleados)):?>

								<?php foreach($empleados as $empleado):?>
									<tr>
										<td><?php echo $empleado->empl_id ?></td>
										<td><?php echo $empleado->empl_nro_doc;?></td>
										<td><?php echo $empleado->empl_nombre;?></td>
										<td>
											<button type = "button" class="btn btn-success checkFuncionario" value="<?php echo $empleado->empl_id;?>"><span class= "fa fa-check"></span></button>
										</td>
									</tr>
								<?php endforeach; ?>
							<?php endif; ?>
						</tbody>
					</table>
					
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-danger pull-left" data-dismiss="modal">Cerrar</button>
			</div>
		</div>
	</div>
</div>

<?php $this->stop()?>
<?php $this->push('scripts')?>
<script type="text/javascript">
	var tablaEmpleado = $("#tablaEmpleado").DataTable({
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
	$(".btn-check2").on("click", function(){
		var empleado = $(this).val();
		infoEmpleado = empleado.split("*");

	});
	$('#tablaEmpleado tbody').on('click', 'tr', function (event) {
		var data = tablaEmpleado.row(this).data();
		console.log(data);

		$('#empl_id').val(data[0]);
		$('#empleado').val(data[2]);
		$('#modal-empleado').modal('hide');
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
			url: "<?php echo base_url()?>store_usuario",
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
				swal.fire({
					title: 'Atención!', 
					content: wrapper,
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
					content: wrapper,
				});
			}
			if (r['correcto']!="") {
				wrapper.innerHTML = r['error'];
				swal.fire({
					icon: "Correcto",
					columnClass: 'medium',
					theme: 'modern',
					title: 'Correcto!',
					content: wrapper,
				});

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

		})
		.done(function(result) {
			var r = JSON.parse(result);
			$('#pass_inicial').val(r);
		}).fail(function() {
			alert("Se produjo un error, contacte con el soporte técnico");
			$("#mdlAguarde").modal('hide');
		});
	});
	
</script>
<?php $this->end()?>
