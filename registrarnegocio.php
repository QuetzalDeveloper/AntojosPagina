<?php
include('conexion.php');
header('Content-Type: text/html; charset=utf8');
session_start();
if(isset($_POST['registrar'])){
	$email = $_POST['correo'];
	$nenom = strtoupper($_POST['negnombre']);
	$usnom = ucwords(strtolower($_POST['nombre']));
	$usape = ucwords(strtolower($_POST['apellidos']));
	$netel = $_POST['telefono'];
	$categ = $_POST['categorias'];
	$estad = $_POST['estado'];
	$contr = $_POST['pass'];
	$recon = $_POST['reppass'];
	$filas = 0;
	$estatus = 0;
	$plan =1;
	if($contr == $recon){
		$hash = password_hash($contr, PASSWORD_BCRYPT);
		$hoy = date("Y-m-d");
		$query = mysqli_query($conexion,"SELECT correo FROM negocio WHERE correo = '".$email."'");
		if($query){
			$filas = $query -> num_rows;
		}
		if($filas > 0){
			$query -> close();
			echo '<script language="javascript">window.location.href="correoconfirmacion.php?email='.$email.'&neg='.$nenom.'&est=0"</script>';
		}
		else{
			if($query = $conexion -> prepare("INSERT INTO negocio (correo, negnombre, categoria, usnombre, usapellidos, telfijo, estado, status, fechareg, idplan, password) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)")){
				$query->bind_Param('ssisssiisis', $email, $nenom, $categ, $usnom, $usape, $netel, $estad, $estatus, $hoy, $plan, $hash);
				$result = $query->execute();
mkdir('./logos/'.$email, 0777);
			}
			else{
				 $error = $conexion->errno . ' ' . $conexion->error;
				echo '<p class="error">Error: '.$error.'</p>'; // 1054 Unknown column 'foo' in 'field list'
			}

			if ($result) {
				echo '<script language="javascript">window.location.href="correoconfirmacion.php?email='.$email.'&neg='.$nenom.'&est=0"</script>';
			} else {
				echo '<p class="error">El servidor no está disponible</p>';
			}
		}
	}else{
		echo '<script language="javascript">alert("Las contraseñas no coinciden");</script>;';
	}
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Registrar negocio</title>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300,400">        <!-- Google web font "Open Sans" -->
  <link rel="stylesheet" href="css/bootstrap.min.css">                                            <!-- https://getbootstrap.com/ -->
  <link rel="stylesheet" href="css/fontawesome-all.min.css">                                      <!-- Font awesome -->
  <link rel="stylesheet" href="css/tooplate-style.css">
  <style type="text/css">
  body,td,th {
    font-family: "Open Sans", Helvetica, Arial, sans-serif;
}
  </style>                                           
  <!-- Templatemo style -->
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
          <i class="fas tm-fa-big fa-utensils tm-fa-mb-big"></i>
          <h1 class="text-uppercase mb-3 tm-site-name">Antojos</h1>
          <p class="tm-site-description">Registro de nuevo negocio</p>
        </div>
      </div>
    </div>
    <div class="container">
      <div class="tm-search-form-container"> 
      </div>
      <div class="row tm-mt-big tm-about-row tm-mb-medium">
        <div class="col-xl-12 col-lg-12 col-md-12 col-xs-12 tm-contact-col">
          <div class="tm-contact-left tm-bg-wine tm-text-white text-right p-md-5 p-4">
            <i class="fas fa-3x fa-edit mb-4"></i>
            <h2 class="tm-media-2-header">Guarda tus datos</h2>
          </div>
          <div class="tm-bg-gray tm-contact-middle">
<!-- Formulario -->
            <form action="" method="post" name="Registro">
              <div class="form-group mb-4">
                <input type="email" id="correo" name="correo" class="form-control" placeholder="Correo" required/>
              </div>
              <div class="form-group mb-4">
                <input type="text" id="negnombre" name="negnombre" class="form-control" placeholder="Nombre del negocio" required/>
              </div>
				<div class="form-group mb-4">
                <input type="text" id="nombre" name="nombre" class="form-control" placeholder="Nombre del usuario" required/>
              </div>
				<div class="form-group mb-4">
                <input type="text" id="apellidos" name="apellidos" class="form-control" placeholder="Apellidos del usuario" required/>
              </div>
				<div class="form-group mb-4">
                <input type="tel" id="telefono" name="telefono" class="form-control" placeholder="Telefono del negocio" required/>
              </div>
				
              <div class="form-group mb-4">
                <select name="categorias" class="tm-select" id="categorias" required>
					<option value="0">Tu categoría</option>
					<option value="1">Comida rápida</option>
					<option value="2">Gourmet</option>
					<option value="3">Temático</option>
					<option value="4">Buffet</option>
					<option value="5">Familiar</option>
					<option value="6">Bar restaurante</option>
					<option value="7">Cafetería</option>
                </select>
              </div>
				<div class="form-group mb-4">
                <select name="estado" class="tm-select" id="estado" required>
                    <option value="0">Estado</option>
                    <option value="1">Aguascalientes</option>
                    <option value="2">Baja California</option>
                    <option value="3">Baja California Sur</option>
                    <option value="4">Campeche</option>
				    <option value="5">Chiapas</option>
				    <option value="6">Chihuahua</option>
				    <option value="7">Ciudad de México</option>
					<option value="8">Coahuila</option>
					<option value="9">Colima</option>
					<option value="10">Durango</option>
					<option value="11">Estado de México</option>
					<option value="12">Guanajuato</option>
					<option value="13">Guerrero</option>
					<option value="14">Hidalgo</option>
					<option value="15">Jalisco</option>
					<option value="16">Michoacán/option>
					<option value="17">Morelos</option>
					<option value="18">Nayarit</option>
					<option value="19">Nuevo León</option>
					<option value="20">Oaxaca</option>
					<option value="21">Puebla</option>
					<option value="22">Querétaro</option>
					<option value="23">Quintana Roo	</option>
					<option value="24">San Luis Potosí	</option>
					<option value="25">Sinaloa</option>
					<option value="26">Sonora</option>
					<option value="27">Tabasco</option>
					<option value="28">Tamaulipas</option>
					<option value="29">Tlaxcala</option>
					<option value="30">Veracruz</option>
					<option value="31">Yucatán</option>
					<option value="32">Zacatecas</option>
                </select>
              </div>
				<div class="form-group mb-4">
                <input type="password" id="pass" name="pass" class="form-control" placeholder="Contraseña" required/>
              </div>
				<div class="form-group mb-4">
                <input type="password" id="reppass" name="reppass" class="form-control" placeholder="Repetir contraseña" required/>
              </div>
              <div class="form-group mb-0">
                <button type="submit" class="btn btn-secondary" name="registrar">Registrar</button>
              </div>
            </form>
<!--FIN de formulario-->
          </div>
          <div class="tm-bg-gray tm-contact-right">

             <div>
               <h2 class="tm-media-2-header tm-text-pink-dark mb-3">Preregistro</h2>
               <p class="mb-0">1. Cuando te registres, se te enviara un mensaje de verificación para autentificar tu correo electrónico</p>
				  </br>
               <p class="mb-0">2. Cuando verifiques tu correo, es importante que termines tu registro.</p>
			   </br>
			   <p class="mb-0">3. Todos los datos que almacenes (excepto tu correo) podrás editarlos despues de verificar tu correo electrónico </p>
			 </br>
             </div>
          </div>
        </div>
      </div>

      
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
