<!doctype html>
<html lang="es">
  <head>
  	<title><?= sistema ?></title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<link href="https://fonts.googleapis.com/css?family=Lato:300,400,700&display=swap" rel="stylesheet">

	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	
	<link rel="stylesheet" href="<?= base_url()?>assets/css/style.css">

	</head>
	<body class="img js-fullheight" style="background-image:url('assets/img/login.jpg');">
	<section class="ftco-section">
		<div class="container">
			<div class="row justify-content-center">
				<div class="col-md-6 text-center mb-5">
					<h2 class="heading-section"><?= sistema ?></h2>
				</div>
			</div>
			<div class="row justify-content-center">
				<div class="col-md-6 col-lg-4">
					<div class="login-wrap p-0">
		      	<h3 class="mb-4 text-center"><?= nombre ?></h3>
		      	<form action="#" id="formu_login" class="signin-form">
		      		<div class="form-group">
		      			<input type="text" class="form-control" placeholder="Nombre Usuario" name="usuario" required>
		      		</div>
	            <div class="form-group">
	              <input id="password-field" type="password" class="form-control" placeholder="Contraseña" name="password" required>
	              <span toggle="#password-field" class="fa fa-fw fa-eye field-icon toggle-password"></span>
	            </div>
	            <div class="form-group">
	            	<button type="submit" class="form-control btn btn-primary submit px-3">Iniciar Sesion</button>
	            </div>
	          </form>
		      </div>
				</div>
			</div>
		</div>
	</section>

<!-- 	<script src="js/jquery.min.js"></script>
  <script src="js/popper.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/main.js"></script> -->
      <script src="<?= base_url() ?>assets/js/jquery-3.3.1.min.js"></script>
    <script src="<?= base_url() ?>assets/js/popper.js"></script>
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

