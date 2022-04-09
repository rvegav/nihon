<?php $this->layout('v_master')?>
<?php $this->start('contenido')?>
<?php $CI =& get_instance() ?>
<div class="row mt-4">
  <div class="col-12 col-sm-6 col-md-3">
    <div class="info-box">
      <span class="info-box-icon bg-info elevation-1"><i class="fas fa-user-friends"></i></span>

      <div class="info-box-content">
        <span class="info-box-text">Empleados</span>
        <span class="info-box-number" id="id_cantcontratado">
        </span>
      </div>
      <!-- /.info-box-content -->
    </div>
    <!-- /.info-box -->
  </div>
  <!-- fix for small devices only -->
  <div class="clearfix hidden-md-up"></div>
  <!-- /.col -->
  <div class="col-12 col-sm-6 col-md-3">
    <div class="info-box mb-3">
      <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-users"></i></span>

      <div class="info-box-content">
        <span class="info-box-text">Proveedores</span>
        <span class="info-box-number" id="id_contnombrados"></span>
      </div>
      <!-- /.info-box-content -->
    </div>
    <!-- /.info-box -->
  </div>
  <!-- /.col -->
  <div class="col-12 col-sm-6 col-md-3">
    <div class="info-box mb-3">
      <span class="info-box-icon bg-success elevation-1"><i class="fas fa-file-signature"></i></span>

      <div class="info-box-content">
        <span class="info-box-text">Productos</span>
        <span class="info-box-number" id="id_contarvacantes"></span>
      </div>
    </div>
  </div>
  <!-- /.col -->
  <div class="col-12 col-sm-6 col-md-3">
    <div class="info-box mb-3">
      <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-blind"></i></span>

      <div class="info-box-content">
        <span class="info-box-text">Atencion Pendiente</span>
        <span class="info-box-number" id="id_contjubilados"></span>
      </div>
    </div>
  </div>

  <?php $this->stop() ?>
  <?php $this->push('scripts') ?>
  <script type="text/javascript">
  $(document).ready(function(){
    consulcanticontra();
    consulcantinombra();
    consulcantivacante();
    consulcantijubilado();
  });

  function consulcanticontra() {
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
