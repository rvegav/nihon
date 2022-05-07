<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?= sistema ?></title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="robots" content="all,follow">
    <!-- Bootstrap CSS-->
    <link rel="stylesheet" href="<?= base_url() ?>assets/distribution/vendor/bootstrap/css/bootstrap.min.css">
    <!-- Font Awesome CSS-->
    <link rel="stylesheet" href="<?= base_url() ?>assets/distribution/vendor/font-awesome/css/all.min.css">
    <!-- Fontastic Custom icon font-->
    <link rel="stylesheet" href="<?= base_url() ?>assets/distribution/css/fontastic.css">
    <!-- theme stylesheet-->
    <link rel="stylesheet" href="<?= base_url() ?>assets/distribution/css/style.bordo.css" id="theme-stylesheet">
    <!-- Custom stylesheet - for your changes-->
    <link rel="stylesheet" href="<?= base_url() ?>assets/distribution/css/custom.css">
    <!-- Favicon-->
    <!-- <link rel="shortcut icon" href="<?= base_url() ?>assets/img/logo.png"> -->
  </head>
  <body>
    <div class="page login-page">
      <div class="container d-flex align-items-center">
        <div class="form-holder has-shadow">
          <div class="row">
            <!-- Logo & Information Panel-->
            <div class="col-lg-6">
              <div class="info d-flex align-items-center">
                <div class="content">
                  <div class="logo">
                    <h1><?= sistema ?></h1>
                  </div>
                  <p><?= nombre ?></p>
                </div>
              </div>
            </div>
            <!-- Form Panel    -->
            <div class="col-lg-6 bg-white">
              <div class="form d-flex align-items-center">
                <div class="content">
                  <form method="post" class="form-validate" id="formu_login">
                    <div class="form-group">
                      <input id="login-username" type="text" name="usuario" required data-msg="Por favor ingrese su usuario" class="input-material">
                      <label for="login-username" class="label-material">Usuario</label>
                    </div>
                    <div class="form-group">
                      <input id="login-password" type="password" name="password" required data-msg="Por favor ingrese su contraseña" class="input-material">
                      <label for="login-password" class="label-material">Contraseña</label>
                    </div>
                    <input type="hidden" name="token" id="token" value="<?= $this->security->get_csrf_hash();?>">
                    <button type="submit" class="btn btn-primary">Ingresar</button>
                  </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="copyrights text-center">
          <p style="color:gray">NIHON SOFTWARE
          </p>
        </div>
      </div>
      <!-- JavaScript files-->
      <script src="<?= base_url() ?>assets/distribution/vendor/jquery/jquery.min.js"></script>
      <script src="<?= base_url() ?>assets/distribution/vendor/popper.js/umd/popper.min.js"> </script>
      <script src="<?= base_url() ?>assets/distribution/vendor/bootstrap/js/bootstrap.min.js"></script>
      <script src="<?= base_url() ?>assets/distribution/vendor/jquery.cookie/jquery.cookie.js"> </script>
      <script src="<?= base_url() ?>assets/distribution/vendor/chart.js/Chart.min.js"></script>
      <script src="<?= base_url() ?>assets/distribution/vendor/jquery-validation/jquery.validate.min.js"></script>
      <!-- Main File-->
      <script src="<?= base_url() ?>assets/distribution/js/front.js"></script>
      <script src="<?= base_url() ?>assets/sweetalert/sweetalert.min.js"></script>
      <script type="text/javascript">
        setInterval(function() {
          window.location.reload();
        },3600000);
        var token = '<?= $this->security->get_csrf_hash(); ?>';
        $('#formu_login').submit(function(event){
          event.preventDefault();
          var datosformu = $('#formu_login').serialize();
          $.ajax({
            url:'procesar_login',
            type:'POST',
            data:datosformu,
            processData:false,
            cache:false,
          })
          .done(function(res){
            var r = JSON.parse(res);
            if (r=="correcto") {
              window.location.reload();
            }else if (r=="incorrecto") {
              Swal.fire({
                type:'error',
                title:'Error!',
                text:'Las credenciales ingresadas no son correctas!',
              });
            }
          })
          .fail(function(){
            Swal.fire({
              type:'error',
              title:'Error!',
              text:'Se produjo un error a nivel del servidor pongase en contacto con el servicio técnico',
            });
          })
        });
      </script>
  </body>
</html>
