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
		Departamento:
	</strong><?php echo $ciudad->DESDEPARTAMENTO;?>
</p>
<p>
	<strong>
		Estado:
	</strong>
	<span class="label <?php echo $label_class;?>">
		<?php echo $estado2; ?>
	</span>
</p>