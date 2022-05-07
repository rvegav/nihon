<!doctype html>
  <html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?= sistema ?></title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="robots" content="all,follow">

    <link rel="stylesheet" href="<?= base_url() ?>assets/style.css">

    <link rel="stylesheet" href="<?= base_url() ?>assets/css/owl.carousel.min.css">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="<?= base_url() ?>assets/css/bootstrap.min.css">
    
    <!-- Style -->
    <link rel="stylesheet" href="<?= base_url() ?>assets/css/style.css">

    <title>Login #2</title>
  </head>
  <body>


    <div class="d-lg-flex half">

      <div class="bg order-1 order-md-2" style="background-image:url('assets/img/login.jpg');"></div>
      <div class="contents order-2 order-md-1">

        <div class="container">
          <div class="row align-items-center justify-content-center">
            <div class="col-md-7">
              <form action="#" method="post" id="formu_login">
                <div class="form-group first">
                  <div class="logo">
                    <h1><?= sistema ?></h1>
                  </div>
                  <p><?= nombre ?></p>
                  <label for="username">Usuario</label>
                  <input type="text" class="form-control" name="usuario" placeholder="Nombre de usuario" id="username">
                </div>
                <div class="form-group last mb-3">
                  <label for="password">Contraseña</label>
                  <input type="password" class="form-control" name="password" placeholder="Contraseña" id="password">
                </div>
                <input type="submit" value="Ingresar" class="btn btn-block btn-success">

              </form>
            </div>
          </div>
        </div>
      </div>


    </div>
    
    

    <script src="<?= base_url() ?>assets/js/jquery-3.3.1.min.js"></script>
    <script src="<?= base_url() ?>assets/js/popper.min.js"></script>
    <script src="<?= base_url() ?>assets/js/bootstrap.min.js"></script>
    <script src="<?= base_url() ?>assets/js/main.js"></script>
    <script src="<?= base_url() ?>assets/sweetalert/sweetalert.min.js"></script>
    <script src="<?= base_url() ?>assets/distribution/vendor/jquery/jquery.min.js"></script>

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