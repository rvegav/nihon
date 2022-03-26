<?php $this->layout('v_master')?>
<?php $this->start('contenido')?>
<?php $CI =& get_instance(); ?>
<div class="card">
	<h4>Listado de Personas</h4>
	<br>
	<div class="row">
		<div class="col-md-2 offset-10">
			<a href="<?php echo base_url()?>add_persona" class="nav-link">
				<button type="button" id="Agregar" class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="Agregar Nueva Persona"><i class="fa fa-plus"></i>Agregar Persona</button>
			</a>
		</div>

	</div>
	<br>
	<div class="row">
		<div class="col-12">
			<table class="table table-bordered table-responsive" id="tablaPersona" width="100%">
				<thead>
					<tr>
						<th class="text-center">Codigo</th>
						<th class="text-center">Documento</th>
						<th class="text-center">Tipo Documento</th>
						<th class="text-center">Nombre</th>
						<th class="text-center">Apellido</th>
						<th class="text-center">Fecha de Nacimiento</th>
						<th class="text-center">Direccion</th>
						<th class="text-center">Telefono</th>
						<th class="text-center">Correo</th>
						<th class="text-center">Fecha de Creacion</th>
						<th class="text-center">Ultima Modificacion</th>
						<th class="text-center">Estado</th>
						<th class="text-center">Opciones</th>
					</tr>
				</thead>
				<tbody>
					<?php if(!empty($personas)):?>
						<?php
						foreach($personas as $persona):?>
							<tr>
								<td><?php echo $persona->per_id; ?></td>
								<td><?php echo $persona->per_nro_doc;?></td>
								<td><?php echo $persona->per_tipo_doc;?></td>
								<td><?php echo $persona->per_nombre;?></td>
								<td><?php echo $persona->per_apellido;?></td>
								<td><?php echo $persona->per_fecha_nacimiento;?></td>
								<td><?php echo $persona->per_direccion.'-'.$persona->ciu_descripcion;?></td>
								<td><?php echo $persona->per_telefono;?></td>
								<td><?php echo $persona->per_correo;?></td>
								<td><?php echo $persona->per_fecha_creacion;?></td>
								<td><?php echo $persona->per_fecha_modificacion;?></td>

								<?php
								$estado = $persona->per_estado;
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
									<a href="<?php echo base_url();?>edit_persona/<?php echo $persona->per_id;?>" class="btn btn-warning"><i class="fa fa-edit"></i></a>
									<?php if ($estado!=2): ?>
										<a href="<?php echo base_url();?>delete_persona/<?php echo $persona->per_id;?>" class="btn btn-danger btn-delete eliminar"><i class="fa fa-trash"></i></a>
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
	var tabla = $("#tablaPersona").DataTable({
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
		// 'ajax':{
		// 	"url":"getPersonas",
		// 	"type":"POST",
		// 	"datasrc": function(json){
		// 		console.log(json);
		// 	}
		// },
		// 'columns':[
		// {data:'CODIGO','sClass':'text-center'},
		// {data:'CEDULA','sClass':'text-center'},
		// {data:'TIPO_DOC','sClass':'text-center'},
		// {data:'NOMBRE','sClass':'text-center'},
		// {data:'APELLIDO','sClass':'text-center'},
		// {data:'FECHA_NAC','sClass':'text-center'}, 
		// {data:'DIRECCION','sClass':'text-center'},
		// {data:'TELEFONO','sClass':'text-center'},
		// {data:'CORREO','sClass':'text-center'},
		// {data:'FECHA_CREA','sClass':'text-center'}
		// {data:'FECHA_MODIF','sClass':'text-center'}
		// ],
		// "columnDefs":[
  //         {
  //           "targets":[12],
  //           render:function(data, type, row){
  //           	var html ='<a href="<?php echo base_url();?>edit_proveedor/'+row.CODIGO+'" class="btn btn-warning"><i class="fa fa-edit"></i></a>';
  //           	if (roW.ESTADO !='2') {
  //           		html+='<a href="<?php echo base_url();?>delete_proveedor/'+row.CODIGO+'" class="btn btn-danger btn-delete eliminar"><i class="fa fa-trash"></i></a>';
  //           	}
  //             return html;
  //           }
  //         }
  //         ]
		
	});
</script>
<?php $this->end()?>