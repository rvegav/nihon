<?php $this->layout('v_master')?>
<?php $this->start('contenido')?>
<?php $CI =& get_instance(); ?>
<div class="card">
	<h4>Listado de Ciudades</h4>
	<br>
	<div class="row">
		<div class="col-md-2 offset-10">
			<a href="<?php echo base_url()?>add_ciudad" class="nav-link">
				<button type="button" id="Agregar" class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="Agregar Nuevo Empleado">Agregar Ciudad</button>
			</a>
		</div>

	</div>
	<br>
	<div class="row">
		<div class="col-12">
			<table class="table table-bordered" id="tablaCiudad" width="100%">
				<thead>
					<tr>
						<th class="text-center">Codigo</th>
						<th class="text-center">Descripcion</th>
						<th class="text-center">Fecha de Creacion</th>
						<th class="text-center">Ultima Modificacion</th>
						<th class="text-center">Estado</th>
						<th class="text-center">Opciones</th>
					</tr>
				</thead>
				<tbody>
					<?php if(!empty($ciudades)):?>
						<?php
						foreach($ciudades as $ciudad):?>
							<tr>
								<td><?php echo $ciudad->ciu_id; ?></td>
								<td><?php echo $ciudad->ciu_descripcion;?></td>
								<td><?php echo $ciudad->ciu_fecha_creacion;?></td>
								<td><?php echo $ciudad->ciu_fecha_modificacion;?></td>

								<?php
								$estado = $ciudad->ciu_estado;
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
									<a href="<?php echo base_url();?>edit_ciudad/<?php echo $ciudad->ciu_id;?>" class="btn btn-warning"><i class="fa fa-edit"></i></a>
									<?php if ($estado!=2): ?>
										<a href="<?php echo base_url();?>delete_ciudad/<?php echo $ciudad->ciu_id;?>" class="btn btn-danger btn-delete eliminar"><i class="fa fa-trash"></i></a>
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
	var tabla = $("#tablaCiudad").DataTable({
		'lengthMenu':[[10, 15, 20], [10, 15, 20]],
		'paging':true,
		'info':true,
		'filter':true,
		'stateSave':true,
		'processing':true,
		'scrollX':true,
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
	$('#tablaCiudad tbody').on('click', '#btn_actualizar', function (event) {
		var cedula = $(this).val();
		$("#contratoEmpleado").modal('toggle');
		$.ajax({
			url:'busca_empleado',
			type:'POST',
			data:{valorbus:cedula,token:token},
			beforeSend:function(xhr){
				var y = '<td class="text-center" colspan="8"><img src="assets/img/loading.gif" style="height:150px;"><p><h4>Buscando...</h4></p></td>';
				$('#cuerpobuscaempleado').html(y);
			}
		}).done(function(res){
			var valorespuesta=JSON.parse(res);
			$('#func_name').val(valorespuesta[0].FUNC);
			$('#func_ci').val(cedula);
			$('#func_cod').val(valorespuesta[0].PERS_COD);
			$('#contr_cargo').val(valorespuesta[0].CARG_DESC)
			$('#contr_cate').val(valorespuesta[0].CATE_DESC)
		}).fail(function(){
			Swal.fire({
				type:'error',
				title:'Error!',
				text:'Se produjo un error a nivel del servidor!',
			});
		});
	} );
	$('#frm_carga').submit(function(event) {
		event.preventDefault();
		var formDato = $(this).serialize();
		console.log(formDato);
		$.ajax({
			url: 'registrar_contrato',
			type: 'POST',
			data: formDato,
		}).done(function(data) {
			var resp = JSON.parse(data);
			console.log(resp);
			if (resp['error']) {
				var html = resp['error'];
				Swal.fire({
					type:'error',
					title:'Error!',
					html:html,
				});
			}else{
				if (resp['correcto']=='correcto') {
					Swal.fire({
						type:'success',
						title:'Correcto!',
						text:'Se agrego correctamente',
					});
					$('#contratoEmpleado').modal('hide');
				}else if(resp['correcto']=='Existe'){
					Swal.fire({
						type:'error',
						title:'Error!',
						html:'<h3>Se detalla los posibles errores</h3><br><ul><li>Ya existe contrato para el periodo seleccionado</li><li>El empleado seleccionado es nombrado</li></ul>',
						
					});
				}else{
					Swal.fire({
						type:'error',
						title:'Error!',
						text:'Se produjo un error a nivel del servidor!',
					});
				}
			}
		}).fail(function() {
			Swal.fire({
				type:'error',
				title:'Error!',
				text:'Se produjo un error a nivel del servidor!',
			});
		});;
	});
</script>
<?php $this->end()?>
