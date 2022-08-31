<!DOCTYPE html>
<html lang="en">
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
          <p class="tm-site-description">Correo de confirmación</p>
        </div>
      </div>
    </div>
    <div class="container">
      <div class="tm-search-form-container"> 
      </div>
      <div class="row tm-mt-big tm-about-row tm-mb-medium">
        <div class="col-xl-12 col-lg-12 col-md-12 col-xs-12 tm-contact-col">
          <div class="tm-contact-left tm-bg-wine tm-text-white text-right p-md-5 p-4">
            <i class="far fa-3x fa-envelope mb-4"></i>
            <h2 class="tm-media-2-header">Correo de confirmación</h2>
          </div>
<?php
include('conexion.php');
session_start();
if(isset($_GET['email'])){
	$email = $_GET['email'];
	$nenom = $_GET['neg'];
	$estat = $_GET['est'];
	$query = mysqli_query($conexion,"SELECT correo,status FROM negocio WHERE correo = '".$email."' AND status = 0");
	if($query){
		$filas = $query -> num_rows;
	}
	if($filas > 0){
		if($estat == 0){
			$query -> close();
			$subject = "Antojos. Correo de confirmación";
			$mensaje = '<html>'.
				'<head><title>Antojos. Activación de cuenta</title></head>'.
				'<body><h1 style="color:DarkRed;">'.$nenom.'</h1>'.
				'<br><br><p style="color:Black;">Para activar su cuenta en Antojos de su negocio '.$nenom.', acceda por favor al siguiente enlace:</p>'.
				'<br><br><p style="color:DarkBlue;"><a>http://127.0.0.1/Antojos/correoactivacion.php?mail='.$email.'&estat=1</a></p>'.
				'<br><br><p style="color:Black;">Si tu no hiciste el registro, te invitamos a no acceder al enlace.</p>'.
				'</body>'.
				'</html>';
			$cabeceras = 'MIME-Version: 1.0' . "\r\n";
			$cabeceras .= 'Content-type: text/html; charset=utf-8' . "\r\n";
			$cabeceras .= 'From: Antojos';
			$enviado = mail($email, $subject, $mensaje, $cabeceras);
			if ($enviado){
				print('<div class="tm-bg-gray tm-contact-middle">
							<div>
							   <h1 class="tm-media-2-header tm-text-pink-dark mb-3">¡¡Registro exitoso!!</h2>
							   <p class="mb-0">Se ha enviado un mensaje de confirmación a tu cuenta de correo electrónico.</p>
								<br>
							   <p class="mb-0">Debes activar tu cuenta para finalizar tu registro.</p>
								<br>
							 </div>
						  </div>
						  <div class="tm-bg-gray tm-contact-right">
							 <div>
							   <h2 class="tm-media-2-header tm-text-pink-dark mb-3">Preregistro</h2>
							   <p class="mb-0">1. El mensaje de confirmación puede tardar algunos minutos en llegar.</p>
								  </br>
							   <p class="mb-0">2. Si el correo no esta en la bandeja de entrada, debes buscarlo en tu carpeta de SPAM</p>
							   </br>
							   <p class="mb-0">3. Todos los datos registrados (excepto tu correo) podrás editarlos despues de verificar tu correo electrónico </p>
							 </br>
							 </div>
						  </div>
						</div>
					  </div>');
			}else{
			print('<div class="tm-bg-gray tm-contact-middle">
						<div>
						   <h1 class="tm-media-2-header tm-text-pink-dark mb-3">¡¡Cuenta ya activada!!</h2>
						   <p class="mb-0">Al parecer tu cuenta ya fue activada anteriormente.</p>
							<br>
						   <p class="mb-0">Ya no es necesario que accedas al envío de confirmación.</p>
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
      }else{
		print('<div class="tm-bg-gray tm-contact-middle">
						<div>
						   <h1 class="tm-media-2-header tm-text-pink-dark mb-3">¡¡Registrate!!</h2>
						   <p class="mb-0">Lo sentimos; al parecer aun no tenemos un negocio registrado a tu cuenta de correo electrónico.</p>
							<br>
						   <p class="mb-0">Para poder enviarte un correo de confirmación, debes llenar el pre-registro</p>
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
}else{
		print('<div class="tm-bg-gray tm-contact-middle">
						<div>
						   <h1 class="tm-media-2-header tm-text-pink-dark mb-3">¡¡Registrate!!</h2>
						   <p class="mb-0">Para poder enviarte un correo de confirmación, debes llenar el pre-registro</p>
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