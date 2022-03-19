
<div class="right_col" role="main">
	<div class="page-title">
		<div class="title_left">
			<h3>
				Roles
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
					Roles  | Editar 
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
					<form id="demo-form2" data-parsley-validate="" class="form-horizontal form-label-left" action="<?php echo base_url()?>roles/roles/update" method="POST" novalidate="">

						<div class="form-group <?php echo !empty(form_error("Descripcion"))? 'has-error':'';?>">
							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="Descripcion">Rol <span class="required">*</span>
							</label>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<input type="text" id="Descripcion" placeholder="Descripcion" font style="text-transform: uppercase;" onkeyup="javascript:this.value = this.value.toUpperCase ();" required="required" value="<?php echo $rol->DESCRIPCION;?>" name="Descripcion" class="form-control col-md-7 col-xs-12">
								<?php echo form_error("Descripcion","<span class='help-block'>","</span>" );?>
							</div>
						</div>



						<div class="ln_solid"></div>
						<div class="form-group">
							<div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
								<button type="reset" class="btn btn-primary">Resetear</button>
								<button id="send" type="submit" class="btn btn-success" name="idrol" value="<?php echo $rol->IDROL ?>">Guardar</button>
							</div>
						</div>
						<div class="col-md-12">
							<div class="form-group col-md-3">
								<div class="input-group">
									<span class="input-group-addon">Modulo:</span>
									<select id="modulo" class="form-control select2">
										<option value="">Seleccione el Modulo</option>
										<?php foreach($modulos as $modulo):?>
											<option value="<?php echo $modulo->IDMODULO;?>"><?php echo $modulo->DESMODULO;?></option>
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
									<input type="checkbox" class="flat" id="Insert">
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
									<input type="checkbox" class="flat" id="Delete">
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
						<table id="table" class="table table-responsive table-bordered">
							<thead>
								<tr>
									<th>Modulo</th>
									<th>Pantalla</th>
									<th>Permisos</th>
								</tr>
							</thead>
							<tbody>
								<?php
								foreach($permisos as $permiso):?>
									<tr>
										<td><?php echo $permiso->DESMODULO ?></td>
										<td><?php echo $permiso->DESPANTALLA ?></td>
										<td><table class="table table-responsive">
											<thead>
												<input type="hidden" name="modulo[<?php echo str_replace(" ","",$permiso->DESPANTALLA)?>][IDPERMISO]" value="<?php echo $permiso->IDPERMISO ?>">
												<input type="hidden" name="modulo[<?php echo str_replace(" ","",$permiso->DESPANTALLA)?>][pantalla]" value="<?php echo $permiso->IDPANTALLA ?>">
												<td><input type="checkbox" class="flat" disabled id="insert_detalle" name="modulo[<?php echo str_replace(' ','',$permiso->DESPANTALLA);?>][insert]" <?php if ($permiso->PERINSERT =='1'): ?> checked <?php endif ?>>Insert</td>
												<td><input type="checkbox" class="flat" disabled id="delete_detalle" name="modulo[<?php echo str_replace(' ','',$permiso->DESPANTALLA)?>][update]" <?php if ($permiso->PERUPDATE =='1'): ?> checked <?php endif ?>>Update</td>
												<td><input type="checkbox" class="flat" disabled id="delete_detalle" name="modulo[<?php echo str_replace(' ','',$permiso->DESPANTALLA)?>][delete]" <?php if ($permiso->PERDELETE =='1'): ?> checked <?php endif ?>>Delete</td>
												<td><input type="checkbox" class="flat" disabled id="delete_detalle" name="modulo[<?php echo str_replace(' ','',$permiso->DESPANTALLA)?>][select]" <?php if ($permiso->PERSELECT =='1'): ?> checked <?php endif ?>>Visualizar</td>
											</thead>
										</table></td>
										<td><button type="button" class="btn btn-danger"><i class="fa fa-trash"></i></button></td>
									</tr>
								<?php endforeach; ?>
							</tbody>
						</table>

					</form>

				</div> <!-- /COL  12-->
			</div><!-- /ROW -->
		</div><!-- / content -->
	</div>
</div>
</div>
<script type="text/javascript">
	// console.log($('#Insert'));
	$(document).ready(function(){
		$('#Insert').on('ifChecked', function(event){
  			// alert(event.type + ' callback');
  			$('#select').iCheck("check");
  			$('#select').iCheck("disable");
  		});
		$('#Insert').on('ifUnchecked', function(event){
  			// alert(event.type + ' callback');
  			if ($('#Insert').prop("checked") == true || $('#Update').prop("checked") == true || $('#Delete').prop("checked") == true)
  			{
  				$('#select').iCheck("check");
  				$('#select').iCheck("disable");
  			}else{
  				$('#select').iCheck("uncheck");
  				$('#select').iCheck("enable");
  			}
  		});
		$('#Delete').on('ifChecked', function(event){
  			// alert(event.type + ' callback');
  			$('#select').iCheck("check");
  			$('#select').iCheck("disable");

  		});
		$('#Delete').on('ifUnchecked', function(event){
  			// alert(event.type + ' callback');
  			$('#select').iCheck("uncheck");
  			$('#select').iCheck("enable");
  			if ($('#Insert').prop("checked") == true || $('#Update').prop("checked") == true || $('#Delete').prop("checked") == true)
  			{
  				$('#select').iCheck("check");
  				$('#select').iCheck("disable");
  			}else{
  				$('#select').iCheck("uncheck");
  				$('#select').iCheck("enable");
  			}
  		});
		$('#Update').on('ifChecked', function(event){
  			// alert(event.type + ' callback');
  			$('#select').iCheck("check");
  			$('#select').iCheck("disable");
  		});
		$('#Update').on('ifUnchecked', function(event){
  			// alert(event.type + ' callback');
  			if ($('#Insert').prop("checked") == true || $('#Update').prop("checked") == true || $('#Delete').prop("checked") == true)
  			{
  				$('#select').iCheck("check");
  				$('#select').iCheck("disable");
  			}else{
  				$('#select').iCheck("uncheck");
  				$('#select').iCheck("enable");
  			}
  		});
	});
	$("#btn-agregar").on("click", function(){

		if ($('#modulo').val().length < 1) 
		{
			swal ( "Debe seleccionar un modulo!" ) ;
			return false;
		}

		if ($('#pantalla').val().length < 1)
		{
			swal ( "Debe seleccionar una pantalla!" ) ;
			return false;
		}

		if ($('#Insert').prop("checked") == false && $('#Update').prop("checked") == false && $('#Delete').prop("checked") == false && $('#select').prop("checked") == false)
		{
			swal ( "Debe marcar algunas de de las acciones!.") ;
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
	$('#pantalla').change(function(){
		$('#pantalla option').hide();
		$('#pantalla option[value="'+$(this).val()+'"]').show()
	});

	$('#modulo').change(function(){
		$('#modulo option').hide();
		$('#modulo option[value="'+$(this).val()+'"]').show()
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
			
			var inputValue = $('#Descripcion').val();        

			$('.flat').prop('disabled', false);		
			// $('#update_detalle').prop('disabled', false);		
			// $('#delete_detalle').prop('disabled', false);		
			// $('#select_detalle').prop('disabled', false);		
			if ($.trim(inputValue).length < 1) 
			{
				swal ( "Debe introducir descripcion del Rol" ) ;
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