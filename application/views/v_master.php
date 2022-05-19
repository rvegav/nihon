<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8"/>
  <!-- <meta lang="es"> -->
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?= sistema ?></title>
  <meta name="description" content="">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <!-- Bootstrap CSS-->
  <link rel="stylesheet" href="<?= base_url() ?>assets/distribution/vendor/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/css/adminlte.min.css">
  <!-- Font Awesome CSS-->
  <link rel="stylesheet" href="<?= base_url() ?>assets/distribution/vendor/font-awesome/css/all.min.css">
  <!-- Fontastic Custom icon font-->
  <link rel="stylesheet" href="<?= base_url() ?>assets/distribution/css/fontastic.css">
  <!-- <link rel="stylesheet" href="<?= base_url() ?>assets/distribution/css/style.bordo.css" id="theme-stylesheet"> -->
  <!-- Custom stylesheet - for your changes-->
  <link rel="stylesheet" href="<?= base_url() ?>assets/distribution/css/custom.css">
  <!-- DataTables-->
  <link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/datatables/datatables.min.css">
  <link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/bootstrap-select/css/bootstrap-select.min.css">
  <link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/confirm/dist/jquery-confirm.min.css">
  <link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/css/sweetalert2.min.css">
 <link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/css/style_gallery.css">

  <!-- Bootstrap Table-->
  <link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/bootstrap-table/bootstrap-table.min.css">
  <!-- Favicon-->
  <!-- <link rel="shortcut icon" href="<?= base_url() ?>assets/img/logo.png"> -->
  <link href="<?= base_url() ?>assets/css/select2.min.css" rel="stylesheet" />
</head>
<body class="hold-transition sidebar-mini">
  <?php $CI =& get_instance();?>
  <!-- Site wrapper -->
  <div class="wrapper">
    <!-- Navbar -->

    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
      </ul>
      <!-- Right navbar links -->
      <ul class="navbar-nav ml-auto">
        <li class="nav-item">
          <a class="nav-link" href="<?= base_url() ?>cerrar_sesion" role="button">Cerrar Sesión
            <i class="fas fa-sign-out-alt"></i>
          </a>
        </li>
      </ul>
    </nav>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
      <!-- Brand Logo -->
      <a href="<?php echo base_url()?>" class="brand-link">
       <!-- <span class="brand-text font-weight-light">MundoPET</span> -->
       <img src="<?= base_url() ?>assets/img/logo.png"
       class="img-rounded"
       style="opacity: 1; width: 60%; height: 60%;">
     </a>

     <!-- Sidebar -->

     <div class="sidebar">
      <!-- Sidebar user (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="info">
          <a href="#" class="d-block"><?= $CI->session->userdata('sist_funnom'); ?></a>
          <p class="d-block" style="color:white;font-size:9px"><?= $CI->session->userdata('sist_cargo'); ?></p>
          <p class="d-block" style="color:white;font-size:9px">ÚLTIMA CONEXIÓN:<?= $CI->session->userdata('sist_ultconx'); ?></p>
        </div>
      </div>

      <?php $modulos = $CI->session->userdata('sist_modulos'); ?>
      <?php $pantallas = $CI->session->userdata('sist_pantallas'); ?>
      <?php foreach ($modulos as $modulo): ?>
        <!-- Sidebar Menu -->
        <nav class="mt-2">
          <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
           with font-awesome or any other icon font library -->
           <?php if ($modulo == 1): ?>

             <li class="nav-item has-treeview">
              <a href="#" class="nav-link">
                <i class="fas fa-user"></i>
                <p>
                  Empleado
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <?php foreach ($pantallas as $pantalla): ?>
                  <?php if ($pantalla == 1): ?>

                    <li class="nav-item">
                      <a href="<?= base_url()?>empleados" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Nomina de Empleados</p>
                      </a>
                    </li>
                  <?php endif ?>
                <?php endforeach ?>
              </ul>
            </li>
          <?php endif ?>
          <?php if ($modulo == 2): ?>

            <li class="nav-item has-treeview">
              <a href="#" class="nav-link">
                <i class="fas fa-users"></i>
                <p>
                  Mantenimiento
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <?php foreach ($pantallas as $pantalla): ?>

                  <?php if ($pantalla ==2): ?>

                    <li class="nav-item">
                      <a href="<?= base_url()?>ciudades" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Ciudad</p>
                      </a>
                    </li>
                  <?php endif ?>
                  <?php if ($pantalla ==3): ?>

                    <li class="nav-item">
                      <a href="<?= base_url()?>proveedores" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Proveedores</p>
                      </a>
                    </li>
                  <?php endif ?>
                  <?php if ($pantalla ==4): ?>

                    <li class="nav-item">
                      <a href="<?= base_url()?>tipo_productos" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Tipo Producto</p>
                      </a>
                    </li>
                  <?php endif ?>
                  <?php if ($pantalla ==5): ?>

                    <li class="nav-item">
                      <a href="<?= base_url()?>productos" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Producto</p>
                      </a>
                    </li>
                  <?php endif ?>
                  <?php if ($pantalla ==6): ?>

                    <li class="nav-item">
                      <a href="<?= base_url()?>personas" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Personas</p>
                      </a>
                    </li>
                  <?php endif ?>
                  <?php if ($pantalla ==7): ?>

                    <li class="nav-item">
                      <a href="<?= base_url()?>especies" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Especies</p>
                      </a>
                    </li>
                  <?php endif ?>
                  <?php if ($pantalla ==8): ?>

                    <li class="nav-item">
                      <a href="<?= base_url()?>razas" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Razas</p>
                      </a>
                    </li>
                  <?php endif ?>
                  <?php if ($pantalla ==9): ?>

                    <li class="nav-item">
                      <a href="<?= base_url()?>ocupaciones" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Ocupaciones</p>
                      </a>
                    </li>
                  <?php endif ?>
                  <?php if ($pantalla ==16): ?>

                    <li class="nav-item">
                      <a href="<?= base_url()?>turnos" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Turnos</p>
                      </a>
                    </li>
                  <?php endif ?>
                <?php endforeach ?>
              </ul>
            </li>
          <?php endif ?>
          <?php if ($modulo == 3): ?>

            <li class="nav-item has-treeview">
              <a href="#" class="nav-link">
                <i class="far fa-address-card"></i>
                <p>
                  Seguridad
                  <i class="fas fa-angle-left right"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <?php foreach ($pantallas as $pantalla): ?>

                  <?php if ($pantalla == 10): ?>

                    <li class="nav-item">
                      <a href="<?php echo base_url()?>usuarios" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Usuarios</p>
                      </a>
                    </li>
                  <?php endif ?>
                  <?php if ($pantalla == 11): ?>

                    <li class="nav-item">
                      <a href="<?php echo base_url()?>roles" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Roles</p>
                      </a>
                    </li>
                  <?php endif ?>
                <?php endforeach ?>
              </ul>
            </li>
          <?php endif ?>
          <?php if ($modulo == 4): ?>

            <li class="nav-item has-treeview">
              <a href="#" class="nav-link">
                <i class="fas fa-gavel"></i>
                <p>
                  Control de Stock
                  <i class="fas fa-angle-left right"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <?php foreach ($pantallas as $pantalla): ?>

     <!--              <?php if ($pantalla ==12): ?>

                    <li class="nav-item">
                      <a href="<?php echo base_url()?>load_regemb" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Cargar Remisiones</p>
                      </a>
                    </li>
                  <?php endif ?> -->
                  <?php if ($pantalla ==13): ?>

                    <li class="nav-item">
                      <a href="<?php echo base_url()?>stock" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Stock de Productos</p>
                      </a>
                    </li>
                  <?php endif ?>
                <?php endforeach ?>
              </ul>
            </li>
          <?php endif ?>
          <?php if ($modulo == 5): ?>

            <li class="nav-item has-treeview">
              <a href="#" class="nav-link">
                <i class="far fa-money-bill-alt"></i>
                <p>
                  Clientes
                  <i class="fas fa-angle-left right"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <?php foreach ($pantallas as $pantalla): ?>

                  <?php if ($pantalla ==14): ?>

                    <li class="nav-item">
                      <a href="<?php echo base_url()?>clientes" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Cargar Clientes</p>
                      </a>
                    </li>
                  <?php endif ?>
                  <?php if ($pantalla ==15): ?>

                    <li class="nav-item">
                      <a href="<?php echo base_url()?>mascotas" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Cargar Mascotas</p>
                      </a>
                    </li>
                  <?php endif ?>
                <?php endforeach ?>
              </ul>
            </li>
          <?php endif ?>
          <?php if ($modulo == 6): ?>

            <li class="nav-item has-treeview">
              <a href="#" class="nav-link">
                <i class="fas fa-building"></i>
                <p>
                  Reportes
                  <i class="fas fa-angle-left right"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <?php foreach ($pantallas as $pantalla): ?>

                  <?php if ($pantalla ==16): ?>

                    <li class="nav-item">
                      <a href="<?php echo base_url()?>load_listentibenef" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Listado de Productos</p>
                      </a>
                    </li>
                  <?php endif ?>
                  <?php if ($pantalla ==17): ?>

                    <li class="nav-item">
                      <a href="<?php echo base_url()?>load_upfileentibenef" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Listar Stock</p>
                      </a>
                    </li>
                  <?php endif ?>
                  <?php if ($pantalla ==18): ?>

                    <li class="nav-item">
                      <a href="<?php echo base_url()?>load_desconsoli_entibenf" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Listar Turnos</p>
                      </a>
                    </li>
                  <?php endif ?>
                  <?php if ($pantalla ==19): ?>

                    <li class="nav-item">
                      <a href="<?php echo base_url()?>histodesc_entben" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Listar Ventas</p>
                      </a>
                    </li>
                  <?php endif ?>
                <?php endforeach ?>
              </ul>
            </li>
          <?php endif ?>
          <?php if ($modulo == 7): ?>

            <li class="nav-item has-treeview">
              <a href="#" class="nav-link">
                <i class="fas fa-calculator"></i>
                <p>
                  Servicios
                  <i class="fas fa-angle-left right"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <?php foreach ($pantallas as $pantalla): ?>

                  <?php if ($pantalla ==17): ?>

                    <li class="nav-item">
                      <a href="<?php echo base_url()?>recepcion" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Recepcion</p>
                      </a>
                    </li>
                  <?php endif ?>
                  <?php if ($pantalla ==18): ?>

                    <li class="nav-item">
                      <a href="<?php echo base_url()?>atencion" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Atenciones</p>
                      </a>
                    </li>
                  <?php endif ?>
                  <?php if ($pantalla ==19): ?>

                    <li class="nav-item">
                      <a href="<?php echo base_url()?>ventas" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Ventas</p>
                      </a>
                    </li>
                  <?php endif ?>
                <?php endforeach ?>
              </ul>
            </li>
          <?php endif ?>
        </nav>
      <?php endforeach ?>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <div class="contenido">
      <section>
        <div class="col-md-12">
          <?= $this->section('contenido')?>
        </div>
      </section>
    </div>
  </div>
  <!-- /.content-wrapper -->

  <footer class="main-footer">
    <strong>Copyright &copy; <?php echo date('Y')?>.</strong> Desarrollado por CGdev.
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->

<!-- jQuery -->
<script src="<?= base_url() ?>assets/distribution/vendor/jquery/jquery.min.js"></script>
<script src="<?= base_url() ?>assets/js/adminlte.min.js"></script>
<script src="<?= base_url() ?>assets/datatables/datatables.min.js"></script>
<script src="<?= base_url() ?>assets/distribution/vendor/popper.js/umd/popper.min.js"></script>
<script src="<?= base_url() ?>assets/distribution/vendor/bootstrap/js/bootstrap.min.js"></script>
<script src="<?= base_url() ?>assets/distribution/vendor/jquery.cookie/jquery.cookie.js"> </script>
<script src="<?= base_url() ?>assets/bootstrap-select/js/bootstrap-select.min.js"></script>
<script src="<?= base_url() ?>assets/bootstrap-select/js/i18n/defaults-es_ES.min.js"></script>
<!-- Main File-->
<script src="<?= base_url() ?>assets/distribution/js/front.js"></script>
<script src="<?= base_url() ?>assets/sweetalert/sweetalert.min.js"></script>
<script src="<?= base_url() ?>assets/confirm/dist/jquery-confirm.min.js"></script>
<script src="<?= base_url() ?>assets/js/sistema.js"></script>
<!-- Boostrap Table-->
<script src="<?= base_url() ?>assets/bootstrap-table/bootstrap-table.min.js"></script>
<!-- <script src="<?= base_url() ?>assets/bootstrap-table/bootstrap-table-es-AR.min"></script> -->
<script src="<?= base_url() ?>assets/js/bootstrap.bundle.min.js"></script>
<script src="<?= base_url() ?>assets/js/select2.min.js"></script>
<!-- <script src="</?= base_url() ?>assets/datatables/Editor-1.9.2/js/dataTables.editor.js"></script> -->
<script type="text/javascript">
  var token = '<?= $CI->security->get_csrf_hash(); ?>';
  $("ul>li.li_menu").click(function(event) {
    sessionStorage.clear();
  });


  var formatNumber = {
       separador: ".", // separador para los miles
       sepDecimal: ',', // separador para los decimales
       formatear:function (num){
         num +='';
         var splitStr = num.split('.');
         var splitLeft = splitStr[0];
         var splitRight = splitStr.length > 1 ? this.sepDecimal + splitStr[1] : '';
         var regx = /(\d+)(\d{3})/;
         while (regx.test(splitLeft)) {
           splitLeft = splitLeft.replace(regx, '$1' + this.separador + '$2');
         }
         return this.simbol + splitLeft +splitRight;
       },
       new:function(num, simbol){
         this.simbol = simbol ||'';
         return this.formatear(num);
       }
     }

     var lenguaje = {
      "sProcessing":     "Procesando...",
      "sLengthMenu":     "Mostrar _MENU_ registros",
      "sZeroRecords":    "No se encontraron resultados",
      "sEmptyTable":     "Ningún dato disponible en esta tabla",
      "sInfo":           "_START_ al _END_ de _TOTAL_ registros",
      "sInfoEmpty":      "del 0 al 0 de un total de 0 registros",
      "sInfoFiltered":   "(_MAX_ registros)",
      "sInfoPostFix":    "",
      "sSearch":         "Buscar:",
      "sUrl":            "",
      "sInfoThousands":  ",",
      "sLoadingRecords": "Cargando...",
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
    }
  </script>
  <?= $this->section('scripts') ?>
</body>
</html>
