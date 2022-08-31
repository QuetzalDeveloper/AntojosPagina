<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Registro confirmado</title>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300,400">        <!-- Google web font "Open Sans" -->
  <link rel="stylesheet" href="css/bootstrap.min.css">                                            <!-- https://getbootstrap.com/ -->
  <link rel="stylesheet" href="css/fontawesome-all.min.css">                                      <!-- Font awesome -->
  <link rel="stylesheet" href="css/tooplate-style.css">                                           <!-- Templatemo style -->
  <script>
    var renderPage = true;
    if (navigator.userAgent.indexOf('MSIE') !== -1
      || navigator.appVersion.indexOf('Trident/') > 0) {
      /* Microsoft Internet Explorer detected in. */
      alert("Please view this in a modern browser such as Chrome or Microsoft Edge.");
      renderPage = false;
    }
  </script>
</head>
<body>
  <!-- Loader -->
  <div id="loader-wrapper">
    <div id="loader"></div>
    <div class="loader-section section-left"></div>
    <div class="loader-section section-right"></div>
  </div>
  <div class="tm-main">
    <div class="tm-welcome-section">
      <div class="container tm-navbar-container">
        <div class="row">
          <div class="col-xl-12">
            <nav class="navbar navbar-expand-sm">
              <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                  <a href="index.php" class="nav-link tm-nav-link tm-text-white">Iniciar Sesión</a>
                </li>
              </ul>
            </nav>
          </div>
        </div>
      </div>
      <div class="container text-center tm-welcome-container">
        <div class="tm-welcome">
          <img src= "img/logo.png" width="200" class = "fas tm-fa-big tm-fa-mb-big img-fluid"> 
          <h1 class="text-uppercase mb-3 tm-site-name">Antojos</h1>
          <p class="tm-site-description">Activación de tu cuenta</p>
        </div>
      </div>
    </div>
    <div class="container">
      <div class="tm-search-form-container"> 
      </div>
      <div class="row tm-mt-big tm-about-row tm-mb-medium">
        <div class="col-xl-12 col-lg-12 col-md-12 col-xs-12 tm-contact-col">
          <div class="tm-contact-left tm-bg-wine tm-text-white text-right p-md-5 p-4">
            <i class="fas fa-3x fa-check mb-4"></i>
            <h2 class="tm-media-2-header">Activación de cuenta</h2>
          </div>
<?php
include('conexion.php');
session_start();
if(isset($_GET['mail'])){
	$email = $_GET['mail'];
	$estat = $_GET['estat'];
	$filas = 0;
	$query = mysqli_query($conexion,"SELECT correo,status FROM negocio WHERE correo = '".$email."' AND status = 0");
	if($query){
		$filas = $query -> num_rows;
	}
	if($filas > 0){ //Si existe un registro
		$query -> close();
		$hoy = date("Y-m-d");
		$sql = 'UPDATE negocio SET status = 1, fechareg="'.$hoy.'", idplan=1, iniplan="'.$hoy.'", finplan="9999-12-31" WHERE correo ="'.$email.'"';
		if($conexion -> query($sql)){	//Activacion correcta
			print('<div class="tm-bg-gray tm-contact-middle">
							<div>
							   <h1 class="tm-media-2-header tm-text-pink-dark mb-3">¡¡Activación exitosa!!</h2>
							   <p class="mb-0">Felicidades, ahora puedes iniciar sesión para ingresar a tu cuenta.</p>
								<br>
							   <p class="mb-0">Inicia sesión mediante el siguiente enlace:</p>
								<br>
								<a href="index.php" class="nav-link tm-nav-link tm-text-wine">Iniciar Sesión</a>
							  </br>
							 </div>
						  </div>
						  <div class="tm-bg-gray tm-contact-right">
							 <div>
							   <h2 class="tm-media-2-header tm-text-pink-dark mb-3">¿Ahora que sigue?</h2>
							   <p class="mb-0">1. Inicia tu sesión y completa los detalles de tu cuenta</p>
								  </br>
							   <p class="mb-0">2. Registra los platillos que ofresca tu establecimiento</p>
							   </br>
							   <p class="mb-0">3. Todos los datos registrados (excepto tu correo) podrás editarlos</p>
							 </br>
							 </div>
						  </div>
						</div>
					  </div>');
		}else{		//Activacion incorrecta
			print('<div class="tm-bg-gray tm-contact-middle">
							<div>
							   <h1 class="tm-media-2-header tm-text-pink-dark mb-3">Eror en la activación</h2>
							   <p class="mb-0">Lo sentimos, se ha detectado un problema en el servidor. Vuelve a intentarlo más tarde.</p>
								<br>
							 </div>
						  </div>
						</div>
					  </div>');
		}
	}else{	//No existe un registro
		print('<div class="tm-bg-gray tm-contact-middle">
						<div>
						   <h1 class="tm-media-2-header tm-text-pink-dark mb-3">Si aun no te registras</h2>
						   <p class="mb-0">Para poder enviarte un correo de confirmación, debes llenar el pre-registro.</p>
							<br>
							<h1 class="tm-media-2-header tm-text-pink-dark mb-3">Si ya te registraste</h2>
							<p class="mb-0">Si ya te registraste; el sistema ha detectado que tu cuenta ya esta activa. No es necesario acceder desde tu correo de confirmación.</p>
							<br>
						 </div>
					  </div>
					  <div class="tm-bg-gray tm-contact-right">
						 <div>
						   <h2 class="tm-media-2-header tm-text-pink-dark mb-3">Ayuda</h2>
						   <p class="mb-0">1. Puedes iniciar sesión en el siguiente enlace:</p>
						   </br>
						   <a href="index.php" class="nav-link tm-nav-link tm-text-wine">Iniciar Sesión</a>
							  </br>
						   <p class="mb-0">2. Puedes hacer tu preregistro con el siguiente enlace:</p>
						   </br>
						   <a href="registrarnegocio.php" class="nav-link tm-nav-link tm-text-wine">Registrar negocio</a>
							  </br>
						   </p>
						 </br>
						 </div>
					  </div>
					</div>
				  </div>');
	}
}
?>
			<footer class="row tm-about-row">
        <div class="col-xl-12">
          <p class="text-center p-4">Copyright &copy; <span class="tm-current-year">2018</span> Quetzal Software 
          
          // Diseño: Tooplate & Quetzal Software</p>
        </div>
      </footer>
    </div> <!-- .container -->

  </div> <!-- .main -->

  <!-- load JS -->
  <script src="js/jquery-3.2.1.slim.min.js"></script> <!-- https://jquery.com/ -->
  <script src="js/bootstrap.min.js"></script>         <!-- https://getbootstrap.com/ -->
  <script>

    /* DOM is ready
    ------------------------------------------------*/
    $(function () {

      if (renderPage) {
        $('body').addClass('loaded');
      }

      $('.tm-current-year').text(new Date().getFullYear());  // Update year in copyright
    });

  </script>
</body>
</html>