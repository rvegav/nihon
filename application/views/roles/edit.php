<?php $this->layout('v_master')?>
<?php $this->start('contenido')?>
<?php $CI =& get_instance(); ?>
<div class="card">
	<div class="card-header">
		<h4>Agregar Rol</h4>
	</div>
	<div class="card-body">
		<form id="rol" data-parsley-validate="" class="form-horizontal form-label-left" action="<?php echo base_url()?>update_rol" method="POST" novalidate="">
			<div class="row">
				<div class="col-md-4 offset-3">
					<label for="NumRol">Código Rol<span class="required">*</span></label>
					<div class="input-group">
						<input type="text" class="form-control" id="NumRol" name="NumRol" readonly value="<?php echo $rol->rol_id;?>">
					</div>	
				</div>
			</div>
			<div class="row">
				<div class="col-md-4 offset-3">
					<label class="" for="desCiudad">Rol <span class="required">*</span></label>
					<div class="input-group">
						<input type="text" id="desRol" placeholder="Descripcion" font style="text-transform: uppercase;" onkeyup="javascript:this.value = this.value.toUpperCase ();"   name="desRol" class="form-control" value="<?php echo $rol->rol_descripcion ?>">
					</div>
				</div>
			</div>
			<br>
			<div class="row">
				<div class="col-md-6 offset-3">
					<button type="reset" class="btn btn-primary">Resetear</button>
					<button id="send" type="submit" class="btn btn-success">Guardar</button>
				</div>
			</div>
			<div class="row">
				<div class="form-group col-md-3">
					<div class="input-group">
						<span class="input-group-addon">Modulo:</span>
						<select id="modulo" class="form-control select2">
							<option value="">Seleccione el Modulo</option>
							<?php foreach($modulos as $modulo):?>
								<option value="<?php echo $modulo->mod_id;?>"><?php echo $modulo->mod_descripcion;?></option>
							<?php endforeach;?>
						</select>
					</div>
				</div>
				<div class="form-group col-md-3">
					<div class="input-group">
						<span class="input-group-addon">Pantalla:</span>
						<select id="pantalla" class="form-control select2">
							<option value="">Seleccione primero el modulo</option>
						</select>
					</div>
				</div>

				<div class="form-group col-md-1">
					<div class="">
						<label for="insert">Insertar</label>
						<input type="checkbox" class="flat" id="Insert" value="" name="insert_detalle[]">
					</div>
				</div>
				<div class="form-group col-md-1">
					<div class="">
						<label for="Update">Actualizar</label>
						<input type="checkbox" class="flat" id="Update">
					</div>
				</div>
				<div class="form-group col-md-1">
					<div class="">
						<label for="Delete">Eliminar</label>
						<input type="checkbox" class="flat" id="Delete" value="">
					</div>
				</div>
				<div class="form-group col-md-1">
					<div class="">
						<label for="Select">Visualizar</label>
						<input type="checkbox" class="flat" id="select">
					</div>
				</div>
				<div class="col-md-2">
					<button id="btn-agregar" type="button" class="btn btn-success btn-flat"><span class="fa fa-plus"></span>Agregar</button>
				</div>
			</div>
			<div class="row">
				<div class="table-responsive">
					<table id="table" class="table ">
						<thead>
							<tr>
								<th>Modulo</th>
								<th>Pantalla</th>
								<th>Permisos</th>
							</tr>
						</thead>
						<tbody>
							<?php if ($detalles): ?>
								<?php foreach ($detalles as $detalle): ?>
									<td><?php echo $detalle->mod_descripcion ?></td>
									<td><?php echo $detalle->pant_descripcion?></td>
									<td><table class="table table-responsive">
											<thead>
												<input type="hidden" name="modulo[<?php echo str_replace(" ","",$detalle->pant_descripcion)?>][pantalla]" value="<?php echo $detalle->pant_id ?>">
												<td><input type="checkbox" class="flat" disabled id="insert_detalle" name="modulo[<?php echo str_replace(' ','',$detalle->pant_descripcion);?>][insert]" <?php if ($detalle->insercion =='SI'): ?> checked <?php endif ?>>Insert</td>
												<td><input type="checkbox" class="flat" disabled id="delete_detalle" name="modulo[<?php echo str_replace(' ','',$detalle->pant_descripcion)?>][update]" <?php if ($detalle->actualizacion =='SI'): ?> checked <?php endif ?>>Update</td>
												<td><input type="checkbox" class="flat" disabled id="delete_detalle" name="modulo[<?php echo str_replace(' ','',$detalle->pant_descripcion)?>][delete]" <?php if ($detalle->borrado =='SI'): ?> checked <?php endif ?>>Delete</td>
												<td><input type="checkbox" class="flat" disabled id="delete_detalle" name="modulo[<?php echo str_replace(' ','',$detalle->pant_descripcion)?>][select]" <?php if ($detalle->visualizacion =='SI'): ?> checked <?php endif ?>>Visualizar</td>
											</thead>
										</table>
								<?php endforeach ?>
							<?php endif ?>
						</tbody>
					</table>
				</div>
			</div>
		</form>
	</div>
</div>
<?php $this->stop()?>
<?php $this->push('scripts')?>
<script type="text/javascript">
	console.log($('#Insert'));
	$(document).ready(function(){
		$('#Insert').on('change', function(event){
  			// alert(event.type + ' callback');
  			if ($('#Insert').prop("checked") == true || $('#Update').prop("checked") == true || $('#Delete').prop("checked") == true)
  			{
  				$('#select').prop("checked", true);
  				$('#select').prop("disable", true);
  			}else{
  				$('#select').prop("checked", false);
  				$('#select').prop("disabled", false);
  			}
  		});

		$('#Delete').on('change', function(event){
  			// alert(event.type + ' callback');
  			$('#select').prop("checked", false);
  			$('#select').prop("disabled", false);
  			if ($('#Insert').prop("checked") == true || $('#Update').prop("checked") == true || $('#Delete').prop("checked") == true)
  			{
  				$('#select').prop("checked", true);
  				$('#select').prop("disable");
  			}else{
  				$('#select').prop("checked", false);
  				$('#select').prop("disabled", false);
  			}
  		});

		$('#Update').on('change', function(event){
  			// alert(event.type + ' callback');
  			if ($('#Insert').prop("checked") == true || $('#Update').prop("checked") == true || $('#Delete').prop("checked") == true)
  			{
  				$('#select').prop("checked", true);
  				$('#select').prop("disable");
  			}else{
  				$('#select').prop("checked", false);
  				$('#select').prop("disabled", false);
  			}
  		});
	});
	$("#btn-agregar").on("click", function(){

		if ($('#modulo').val().length < 1) 
		{
			swal.fire ( "Debe seleccionar un modulo!" ) ;
			return false;
		}

		if ($('#pantalla').val().length < 1)
		{
			swal.fire ( "Debe seleccionar una pantalla!" ) ;
			return false;
		}

		if ($('#Insert').prop("checked") == false && $('#Update').prop("checked") == false && $('#Delete').prop("checked") == false && $('#select').prop("checked") == false)
		{
			swal.fire ( "Debe marcar algunas de de las acciones!.") ;
			return false;
		}
		
		pantalla = $("SELECT#modulo option:selected").text().replaceAll(" ", "");
		html = '<tr>';
		html += '<td>';
		html += '<input type="hidden" id="modulo" name="modulo['+pantalla+'][modulo]" value="'+ $("SELECT#modulo option:selected").val() + '" >';
		html += $("SELECT#modulo option:selected").text();
		html += '</td>';
		html += '<td>';

		html += '<input type="hidden" id="pantalla" name="modulo['+pantalla+'][pantalla]" value="'+ $("SELECT#pantalla option:selected").val() + '" >';
		html += $("SELECT#pantalla option:selected").text();
		html += '</td>';
		html += '<td>';
		html += '<table class="table table-responsive"> <thead>';
		html += '<td>';
		html += '<input type="checkbox" class="flat" disabled id="insert_detalle" name="modulo['+pantalla+'][insert]"';
		if ($('#Insert').is(':checked')) {
			html += "checked > Insertar";
		}else{
			html += "> Insertar";
		};
		html += '</td>';
		html += '<td>';
		html += '<input type="checkbox" class="flat" disabled id="update_detalle" name="modulo['+pantalla+'][update]"';
		// html += '<input type="checkbox" class="flat" disabled id="update_detalle" name="permiso['+$("#pantalla option:selected").val()+']["update"]"';
		if ($('#Update').is(':checked')) {
			html += " checked > Actualizar";
		}else{	
			html += "> Actualizar";
		};
		html += '</td>';
		html += '<td>';
		html += '<input type="checkbox" class="flat" disabled id="delete_detalle" name="modulo['+pantalla+'][delete]"';
		if ($('#Delete').is(':checked')) {
			html += " checked > Eliminar";
		}else{
			html += "> Eliminar";
		};
		html += '</td>';
		html += '<td>';
		html += '<input type="checkbox" class="flat" disabled id="select_detalle" name="modulo['+pantalla+'][select]"';
		if ($('#select').is(':checked')) {
			html += " checked > Visualizar";
		}else{
			html += "> Visualizar";
		};
		html += '</td>';
		html += '</thead></table>';
		html += '<td>';
		html += '<button type="button" class="btn btn-danger"><i class="fa fa-trash"></i></button>';
		html += '</td>';

		html += '</tr>';
		$("#table tbody").append(html);
		$('input.flat').iCheck({
			checkboxClass: 'icheckbox_flat-green',
			radioClass: 'iradio_flat-green'
		});
		// $('#moduloDef').prop('selected',true);
		$("#modulo").val('');
		console.log(pantalla);
		$("#modulo").select2().trigger('change');
	});

	$(document).ready(function(){
		$('#modulo').on('change', function(){
			var moduloID = $(this).val();
			if(moduloID){
				$.ajax({
					type:'POST',
					url:'<?php echo base_url()?>roles/roles/GetPantalla/'+moduloID,
					// data:'modulo_id='+moduloID,
				})
				.done(function (html){
					console.log(html);
					$('#pantalla').html(html);
				})
				.fail(function(){
					alert('ocurrio un error interno, contacte con Rolo');
				});
			}else{
				$('#pantalla').html('<option value="">Seleccione primero el modulo</option>');
			}
		});

		$('#send').click(function(){    	
			
			var inputValue = $('#desRol').val();        
			$('.flat').prop('disabled', false);		
			// $('#update_detalle').prop('disabled', false);		
			// $('#delete_detalle').prop('disabled', false);		
			// $('#select_detalle').prop('disabled', false);		
			if ($.trim(inputValue).length < 1) 
			{
				swal.fire( "Debe introducir descripcion del Rol" ) ;
				return false;
			}

			if ($.trim('#table').length < 1) 
			{
				swal ( "Debe introducir pantalla" ) ;
				return false;
			}

		});

	});

</script>
<?php $this->end()?>

<!-- /.modal -->