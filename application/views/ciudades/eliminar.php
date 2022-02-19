<div class="modal fade" id="modal-view">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel"><i class='fa fa-eye'></i> Ver Detalles de la Ciudad </h4>
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

<?php
$estado = 1;
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
$date_added = $ciudad->FECGRABACION;
$date_added = date('d-M-Y H:i:s', strtotime($date_added));
$date_act = $ciudad->FECGRABACION;
if($date_act == "")
{
	$date_act = "Sin Datos";
}
else
{
//$date_act = date('d-M-Y H:i:s', strtotime($date_act));
$date_act = $ciudad->FECGRABACION;
}
?>
<p>
	<strong>
		Id Ciudad:
	</strong><?php echo $ciudad->IDCIUDAD;?>
</p>
<p>
	<strong>
		Nro. Ciudad:
	</strong><?php echo $ciudad->NUMCIUDAD;?>
</p>
<p>
	<strong>
		Descripcion:
	</strong><?php echo $ciudad->DESCIUDAD;?>
</p>
<p>
	<strong>
		Estado:
	</strong>
	<span class="label <?php echo $label_class;?>">
		<?php echo $estado2; ?>
	</span>
</p>