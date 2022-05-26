<?php $this->layout('v_master')?>
<?php $this->start('contenido')?>
<?php $CI =& get_instance(); ?>
<div class="card">
	<div class="card-header">
		<h4>Agregar Rol</h4>
	</div>
	<div class="card-body">
		<form id="frm_rol" data-parsley-validate="" class="form-horizontal form-label-left" action="<?php echo base_url()?>store_rol" method="POST" novalidate="">
			<div class="row">
				<div class="col-md-4 offset-3">
					<label for="NumRol">Código Rol<span class="required">*</span></label>
					<div class="input-group">
						<input type="text" class="form-control" id="NumRol" name="NumRol" readonly value="<?php echo $maximo->MAXIMO;?>">
					</div>	
				</div>
			</div>
			<div class="row">
				<div class="col-md-4 offset-3">
					<label class="" for="desCiudad">Rol <span class="required">*</span></label>
					<div class="input-group">
						<input type="text" id="desRol" placeholder="Descripcion" font style="text-transform: uppercase;" onkeyup="javascript:this.value = this.value.toUpperCase ();"   name="desRol" class="form-control">
					</div>
				</div>
			</div>
			<br>
			<div class="row">
				<div class="col-md-6 offset-3">
					<button type="button" onclick="history.back()" class="btn btn-primary">Cancelar</button>
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
						<input type="checkbox" class="flat" id="Insert" value="">
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
		
		pantalla = $("SELECT#pantalla option:selected").text().replaceAll(" ", "");
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
		html += '<input type="checkbox" class="permisos" disabled id="insert_detalle" name="modulo['+pantalla+'][insert]"';
		if ($('#Insert').is(':checked')) {
			html += "checked > Insertar";
		}else{
			html += "> Insertar";
		};
		html += '</td>';
		html += '<td>';
		html += '<input type="checkbox" class="permisos" disabled id="update_detalle" name="modulo['+pantalla+'][update]"';
		// html += '<input type="checkbox" class="permisos" disabled id="update_detalle" name="permiso['+$("#pantalla option:selected").val()+']["update"]"';
		if ($('#Update').is(':checked')) {
			html += " checked > Actualizar";
		}else{	
			html += "> Actualizar";
		};
		html += '</td>';
		html += '<td>';
		html += '<input type="checkbox" class="permisos" disabled id="delete_detalle" name="modulo['+pantalla+'][delete]"';
		if ($('#Delete').is(':checked')) {
			html += " checked > Eliminar";
		}else{
			html += "> Eliminar";
		};
		html += '</td>';
		html += '<td>';
		html += '<input type="checkbox" class="permisos" disabled id="select_detalle" name="modulo['+pantalla+'][select]"';
		if ($('#select').is(':checked')) {
			html += " checked > Visualizar";
		}else{
			html += "> Visualizar";
		};
		html += '</td>';
		html += '</thead></table>';
		html += '<td>';
		html += '<button type="button" class="btn btn-danger eliminar" ><i class="fa fa-trash"></i></button>';
		html += '</td>';

		html += '</tr>';
		$("#table tbody").append(html);
		// $('input.flat').iCheck({
		// 	checkboxClass: 'icheckbox_flat-green',
		// 	radioClass: 'iradio_flat-green'
		// });
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

		$("#frm_rol").submit(function(event) {
			event.preventDefault();		
			$('.permisos').prop('disabled', false);
			var formDato = $(this).serialize();
			$('.permisos').prop('disabled', 'disabled');
			$.ajax({
				url: "<?php echo base_url()?>store_rol",
				type: 'POST',
				data: formDato
			})
			.done(function(result) {
				var r = JSON.parse(result);
				const wrapper = document.createElement('div');
				if (r['alerta']!="") {
					var mensaje = r['alerta'];
					wrapper.innerHTML = mensaje;
					swal.fire({
						title: 'Atención!', 
						html: wrapper,
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
						html: wrapper,
					});
				}
				if (r['correcto']!="") {
					window.location = "<?php echo base_url()?>roles";
				}

			}).fail(function() {
				alert("Se produjo un error, contacte con el soporte técnico");
			});
		});

	});
	$('#table tbody').on('click', '.eliminar', function(){
		$(this).parents('tr').remove();
	})

</script>
<?php $this->end()?>

<!-- /.modal -->