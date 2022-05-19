<?php $this->layout('v_master')?>
<?php $this->start('contenido')?>
<?php $CI =& get_instance() ?>
<h4><?= $fecha ?></h4>
<div class="row mt-4">
  <!-- fix for small devices only -->
  <div class="clearfix hidden-md-up"></div>
  <!-- /.col -->
  <?php foreach ($turnos as $turno): ?>
    <div class="col-12 col-sm-6 col-md-4">

      <div class="info-box mb-4">
        <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-calendar-plus"></i></span>

        <div class="info-box-content">
          <span class="info-box-text"><?php echo $turno['servicio'] ?></span>
          <span class="info-box-number" id="id_consultorio"><?php echo $turno['ocupado'] ?>/<?php echo $turno['disponible'] ?></span>
        </div>
        <!-- /.info-box-content -->
      </div>
      <!-- /.info-box -->
    </div>
  <?php endforeach ?>

  <?php $this->stop() ?>
  <?php $this->push('scripts') ?>
  <script type="text/javascript">
    $(document).ready(function(){
      consulcanticontra();
      consulcantinombra();
      consulcantivacante();
      consulcantijubilado();
    });

    function consulcantPendiente() {
      $.get("conta_contra",function(data){
        var val = JSON.parse(data);

        if (val!='no_data') {
          $('#id_cantcontratado').append(val[0]["CANTCONTRATADOS"]);
        }else if (val=='no_data') {
          $('#id_cantcontratado').append(0);
        }
      });
    }

    function consulcantinombra() {
      $.get("conta_nombra",function(data){
        var valor = JSON.parse(data);

        if (valor!='no_data') {
          $('#id_contnombrados').append(valor[0]["CANTNOMBRADOS"]);
        }else if (valor=='no_data') {
          $('#id_contnombrados').append(0);
        }
      });
    }

    function consulcantivacante() {
      $.get("conta_vacante",function(data){
        var valor = JSON.parse(data);

        if (valor!='no_data') {
          $('#id_contarvacantes').append(valor[0]["CANTVACANTES"]);
        }else if (valor=='no_data') {
          $('#id_contarvacantes').append(0);
        }
      });
    }

    function consulcantijubilado() {
      $.get("conta_jubilado",function(data){
        var valor = JSON.parse(data);

        if (valor!='no_data') {
          $('#id_contjubilados').append(valor[0]["CANTJUBILADOS"]);
        }else if (valor=='no_data') {
          $('#id_contjubilados').append(0);
        }
      });
    }
  	// $("").click(function(event) {
  		//window.location.href="";
  	// });
  </script>
  <?php $this->end() ?>
