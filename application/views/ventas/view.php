   

<html>
<head>
	<style type="text/css">
		* {
			font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
			margin: 0;
			padding: 0;
		}
		.container{
			font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
			/*width: 595.28px;*/
			width: 90%;
			margin:0 auto;
			z-index:1;
		}

		table{
			width: 100%;
		}

		.b-buttom {
			border-bottom: 1px solid; 
		}
		.b-top {
			border-top:1px solid;
		}

		.b-col {
			border-collapse: collapse;
		}
		.n-1{
			font-weight: 700;
		}
		.text{
			overflow: hidden;
			/*text-overflow: ellipsis;*/
			white-space: nowrap;
			display:block;
			width:100%;
			min-width:1px;
		}
		.f-10 {
			font-size: 10px !important;
		}
		.f-9 {
			font-size: 9px !important;
		}
		.f-11 {
			font-size: 11px !important;
		}
		.f-12 {
			font-size: 12px !important;
		}
		.c-text {
			text-align: center;
		}
		.cabecera {
		}
		.espacio-10 {
			margin-top: 20px;
		}
		#background{
			/*margin-top:100px;*/
			position:absolute;
			z-index:0;
			background:white;
			display:block;
			min-height:50%; 
			min-width:50%;
			color:yellow;
		}
		#bg-text
		{
			color:lightgrey;
			font-size:120px;
			transform:rotate(300deg);
			-webkit-transform:rotate(300deg);
		}
		.hidden {
			display: none;
		}
	</style>
	<body>
		<div id="background">
			<p id="bg-text" style="margin-top: 200px;">MundoPet</p>
		</div>  
		<div class="container espacio-10">
			<table>
				<tr>
					<td style="width: 25%;" class="c-text">

						<!-- <img src="{{asset (Storage::url($parametroFactura->imagen))}}" width="150"> -->

					</td>
					<td style="width: 35%; padding: 10px;" class="c-text f-9">
						<span class="f-10">Clinica Veterinaria MundoPet de Karen Riquelme</span><br>
						<span class="f-10">Actividades Veterinarias</span><br>
						<span class="f-10">Venta de productos veterinarios al por menor.</span><br>
						<span class="f-10">Cel (0976) 979 596.</span><br>
						<!-- E-mail: {{$parametroFactura->correo}}	<br> -->
					</td>
					<td style="width: 40%;">
						<div style="padding: 10px;">
							<div style="border:1px solid; text-align: center; padding: 10px;">
								<span class="n-1">Timbrado Nro:<span id="numTimbrado">timbrado</span></span><br>

							</div>
						</td>
					</tr>

				</table>
				<table style="margin-top: 10px;"  class="b-buttom b-top">
					<tr>
						<td class="f-10" style="padding: 0 0 0 20px;">
							<b>Direccion:</b> Cacique Lambaré esquina Augusto Roa Bastos 2939 - Lambaré - Paraguay <br>
						</td>
					</tr>
				</table>

				<table class="f-11"  style="border:1px solid">

					<colgroup>
						<col style="width: 10%"/>
						<col style="width: 10%"/>
						<col style="width: 10%"/>
						<col style="width: 10%"/>
						<col style="width: 10%"/>
						<col style="width: 10%"/>
						<col style="width: 10%"/>	
					</colgroup>
					<tr>
						<td colspan="6">
							<b>Nombre / Razon Social: </b> <?php echo $venta->ven_razon_social ?>
						</td>

						<td colspan="3">
							<b>RUC: </b> <?php echo $venta->ven_ruc ?>
						</td>

					</tr>


					<tr>
						<td colspan="7">
							<!-- <b>Dirección: {{$cliente->direccion}}</b> -->
						</td>

						<td colspan="3">
							<!-- <b>Telefono: {{$cliente->telefono}}</b> -->
						</td>

					</tr>

				</table>


				<table style="margin-top: 10px;">

					<colgroup>
						<col style="width: 50%"/>
						<col style="width: 50%"/>

					</colgroup>
					<tr>
						<td>
							Detalles
						</td>
						<td>
							Valor de Ventas
						</td>
					</tr>
				</table>

				<table class="c-text b-col" border="1">

					<colgroup>
						<col/>
						<col/>
						<col/>
						<col/>
						<col/>	
						<col/>	
					</colgroup>

					<tr>
						<td width="5%">
							Cod
						</td>

						<td width="5%">
							Cant
						</td>
						<td width="40%">
							Descripción Producto
						</td>

						<td width="10%">
							Precio Unitario	
						</td>

						<td width="10%">
							Iva 5%
						</td>

						<td width="10%">
							Iva 10%
						</td>
					</tr>

				</table>

				<table class=""  FRAME="vsides" RULES="cols" style="border-bottom: 1px solid; ">

					<colgroup>
						<col/>
						<col/>
						<col/>
						<col/>
						<col/>
						<col/>
					</colgroup>

					

					{{-- ===================================
					AGREGAR SERVICIOS Y ESPACIOS
					=================================== --}}

					{{-- AGREGAR ESPACIOS EN BLANCO PARA COMPLETAR 15 LINEAS EN TOTAL --}}
					<tr valign="top" class="f-11">


						<td class="c-text" width="5%">
							&nbsp; 
						</td>

						<td class="c-text" width="5%">
							
						</td>

						<td width="40%">
							
						</td>

						<td class="c-text" width="10%">
							
						</td>

						<td class="c-text" width="10%">
						</td>

						<td class="c-text" width="10%">
							
						</td>


					</tr>
					<?php 
					$contador_filas=0;

					foreach ($detalles as $detalle) {?>
						<?php $contador_filas++ ?>

						<tr valign="top" class="f-11">


							<td class="c-text" width="5%">
								&nbsp; <?php echo $detalle->prod_id ?>
							</td>

							<td class="c-text" width="5%">
								<?php echo $detalle->vede_cantidad ?>
							</td>

							<td width="40%">
								<?php echo $detalle->prod_descripcion ?>
							</td>

							<td class="c-text" width="10%">
								<?php echo number_format($detalle->prod_precio_venta, 0, '', '.'); ?>
							</td>

							<td class="c-text" width="10%">
							</td>

							<td class="c-text" width="10%">
								<?php echo number_format($detalle->prod_precio_venta * 0.1,0, '','.'); ?>
							</td>


						</tr>


					<?php }?>
					<?php if ($contador_filas < 30): ?>
						<?php for ($i=$contador_filas; $i <=30 ; $i++){?>
							<tr valign="top" class="f-11">


								<td class="c-text" width="5%">
									&nbsp; 
								</td>

								<td class="c-text" width="5%">
									
								</td>

								<td width="40%">
									
								</td>

								<td class="c-text" width="10%">
									
								</td>

								<td class="c-text" width="10%">
								</td>

								<td class="c-text" width="10%">
									
								</td>


							</tr>
						<?php } ?>
					<?php endif ?>


					<tr valign="top" class="f-12">
						<td class="c-text" colspan="6"></td>

					</tr>

					<tr valign="top" class="f-11">


						<td class="c-text" width="5%">
							&nbsp;
						</td>

						<td class="c-text" width="5%">

						</td>

						<td width="40%">

						</td>

						<td class="c-text" width="10%">

						</td>

						<td class="c-text" width="10%">
						</td>

						<td class="c-text" width="10%">

						</td>


					</tr>





				</table>


				<table style="border-bottom: 1px solid; margin-top: 10px;">

					<colgroup>
						<col/>
						<col/>
						<col/>
						<col/>
						<col/>
						<col/>
					</colgroup>


					<tr>

						<td style="width: 20%;" class="f-11" width="10%">
							<b>SUB-TOTALES: <?php echo number_format($venta->ven_total_venta - $venta->ven_total_venta*.1, 0,'','.') ?></b>
						</td>

						<td class="f-9" width="40%">

						</td>

						<td  style="width: 10%;" class="c-text f-10" width="13%">

						</td>

						<td  style="width: 10%;" class="c-text f-10" width="13%">

						</td>

						<td  style="width: 10%;" class="c-text f-10" width="13%">

						</td>

					</tr>


				</table>

				<table  style="border-bottom: 1px solid;">
					<tr>

						<td class="f-12">
							<b>TOTAL DE FACTURA:</b> &nbsp;&nbsp;&nbsp;&nbsp; <?php echo number_format($venta->ven_total_venta, 0,'','.') ?>
						</td>


					</tr>
				</table>

<!-- 		<table  style="border-bottom: 1px solid;">
			<tr>
				<td class="f-11">
					<b>SON:</b>
				</td>
			</tr>
		</table> -->

		<table   style="border-bottom: 1px solid;">
			<tr>
				<td class="f-12" >
					<b>LIQUIDACÍÓN IVA 10%: </b> <span> </span>
				</td>	

				<td class="f-12">
					<b>LIQUIDACÍÓN IVA 5%:</b> <span> 0,00</span>
				</td>


				<td class="f-12">
					<b>TOTAL IVA: <?php echo number_format($venta->ven_total_venta*.1, 0,'','.') ?></b> <span></span>
				</td>

			</tr>

		</table>

	</div>

</body>
<title></title>
</head>

</html>
