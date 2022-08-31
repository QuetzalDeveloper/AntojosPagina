<?php
include("conexion.php");
session_start();
if(isset($_SESSION['correo'])){
	$correo = $_SESSION['correo'];
	$filas = 0;
	$query = mysqli_query($conexion, 'SELECT * FROM negocio WHERE correo="'.$correo.'"');
	$filas = $query->num_rows;
	if($filas == 0){ //El correo no esta registrado
		echo '<p class="error">Error de conexion. Intente de nuevo mas tarde.</p>';
	}
	else{
		$result = mysqli_fetch_array($query);
		$negnom = $result['negnombre'];
		$slogan = $result['slogan'];
		$logone = $result['logo'];
		$query -> close();
	}
	if(isset($_POST['platillo'])){
		$nombre = trim($_POST['nombre']);
		$descri = trim($_POST['descripcion']);
		$catego = $_POST['categorias'];
		$precio = $_POST['precio'];
		$path = './logos/'.$correo.'/';
		$archivo = $_FILES['imagen']['name'];
		if(isset($archivo) && $archivo != ""){
			$tipo = $_FILES['imagen']['type'];
			$tamano = $_FILES['imagen']['size'];
			$temp = $_FILES['imagen']['tmp_name'];
			if (!((strpos($tipo, "gif") || strpos($tipo, "jpeg") || strpos($tipo, "jpg") || strpos($tipo, "png")) && ($tamano < 800000))) {
				echo '<p class="error">La extensión o el tamaño de los archivos no es correcta.<br/>
				- Se permiten archivos .gif, .jpg, .png. y de 800 kb como máximo.</b></p>';
			}else {
				if (move_uploaded_file($temp, './logos/'.$correo.'/'.$archivo)) {
					chmod('./logos/'.$correo.'/'.$archivo, 0777);
					$img = "./logos/".$correo."/".$archivo;
					$sql = 'INSERT INTO platillos(correo,nombre,descripcion,tipo,precio,foto) VALUES(?, ?, ?, ?, ?, ?)';
					if($query = $conexion -> prepare($sql)){
						$query->bind_Param('sssids', $correo, $nombre, $descri, $catego,$precio,$img);
						$result = $query->execute();
						echo '<p class="exito">El platillo se ha guardado</p>';
						header('Location: NuevoPlatillo.php');
					}else{
						echo '<p class="error">Lo sentimos, se ha detectado un problema en el servidor.</p>';
					}
				}
				else {
				   echo '<p class="error">Lo sentimos, se ha detectado un problema en el servidor. Vuelve a intentarlo más tarde.</p>';
				}
			  }
		}else if($archivo == ""){
			$sql = 'INSERT INTO platillos(correo,nombre,descripcion,tipo,precio) VALUES(?, ?, ?, ?, ?)';
			if($query = $conexion -> prepare($sql)){
				$query->bind_Param('sssid', $correo, $nombre, $descri, $catego,$precio);
				$result = $query->execute();
				echo '<p class="exito">El platillo se ha guardado!!!</p>';
				//header('Location: NuevoPlatillo.php');
			}else{
				echo '<p class="error">Lo sentimos, se ha detectado un problema en el servidor.</p>';
			}
		}
		
	}
	
}else{
	echo '<script language="javascript">window.location.href="index.php"</script>';
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>Nuevo platillo</title>

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
                  <a href="PrincipalNegocio.php" class="nav-link tm-nav-link tm-text-white">Mi negocio</a>
                </li>
                <li class="nav-item active">
                  <a href="NuevoPlatillo.php" class="nav-link tm-nav-link tm-text-white active">Platillos</a>
                </li>
                <li class="nav-item">
                  <a href="EditarNegocio.php" class="nav-link tm-nav-link tm-text-white">Cuenta</a>
                </li>
              </ul>
            </nav>
          </div>
        </div>
      </div>

      <div class="container text-center tm-welcome-container">
        <div class="tm-welcome">
          <?php
			if(empty($logone)){
				$logone = "img/logo.png";
				echo '<img src= "img/logo.png" width="200" class = "fas tm-fa-big tm-fa-mb-big img-fluid">'; 
			}else{
				echo '<img src= "'.$logone.'" width="200" class = "fas tm-fa-big tm-fa-mb-big img-fluid">'; 
			}	
          echo '<h1 class="text-uppercase mb-3 tm-site-name">'.$negnom.'</h1>';
          echo '<p class="tm-site-description">'.$slogan.'</p>';
			  ?>
        </div>
      </div>

    </div>


    <div class="container">
      <div class="tm-search-form-container">
        
      </div>

      <div class="row tm-mt-big tm-about-row tm-mb-medium">
        <div class="col-xl-12 col-lg-12 col-md-12 col-xs-12 tm-contact-col">
          <div class="tm-contact-left tm-bg-wine tm-text-white text-right p-md-5 p-4">
            <i class="fas fa-3x fa-utensils mb-4"></i>
            <h2 class="tm-media-2-header">Datos del platillo</h2>
          </div>
          <div class="tm-bg-gray tm-contact-middle">
<!-- Formulario -->
            <form action="#" method="post" enctype="multipart/form-data">
              <div class="form-group mb-4">
                <input type="text" id="nombre" name="nombre" class="form-control" placeholder="Nombre del platillo" required/>
              </div>
               <div class="form-group mb-4">
                <textarea rows="8" id="descripcion" name="descripcion" class="form-control" placeholder="Descripción del platillo" required></textarea>
              </div>
				<div class="form-group mb-4">
                <select name="categorias" class="tm-select" id="categorias" required>
                  <option value="0">Tipo de platillo</option>
                  <option value="1">Entrada</option>
                  <option value="2">Aperitivo</option>
                  <option value="3">Sopa, pasta o ensalada</option>
                  <option value="4">Plato principal</option>
				  <option value="5">Postre</option>
				  <option value="6">Bebida</option>
				  <option value="7">Bar</option>
				  <option value="8">Complemento</option>
				  <option value="9">Combo</option>
                </select>
              </div>
			<div class="form-group mb-4">
                <input type="text" pattern="[0-9.]+" id="precio" name="precio" class="form-control" placeholder="Precio" />
			</div>
			<div class="form-group mb-4">
				<p>Foto/imagen de tu platillo:</p>
                <input type="file" id="imagen" name="imagen" accept="image/*"class="form-control" onchange="validateFileType()" />
				<script type="text/javascript"> 
					function validateFileType(){ 
					 var fileName = document.getElementById("fileName").value; 
					 var idxDot = fileName.lastIndexOf(".") + 1; 
					 var extFile = fileName.substr(idxDot, fileName.length).toLowerCase(); 
					 if (extFile=="jpg" || extFile=="jpeg" || extFile=="png"){ 
					  //TO DO 
					 }else{ 
					  alert("Only jpg/jpeg and png files are allowed!"); 
					 } 
					} 
				</script> 				
			</div>			
              
              <div class="form-group mb-0">
                <button type="submit" class="btn btn-secondary" name="platillo">Guardar</button>
              </div>
            </form>
<!--FIN de formulario-->
          </div>
          <div class="tm-bg-gray tm-contact-right">
            <!-- GOOGLE MAP -->
             <div id="google-map" class="text-center mb-5">
                  <img src="img/platillo.jpg" width="350" height="300" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>
             </div>

             <div>
               <h2 class="tm-media-2-header tm-text-pink-dark mb-3">¡¡Sube correctamente tu imagen!!</h2>
               <p class="mb-0">1. Debe ser menor de 1Mb</p>
			   </br>
			   <p class="mb-0">2. Los tipos de imagen aceptados son: JPG, PNG y GIF </p>
			 </br>
				<h2 class="tm-media-2-header tm-text-pink-dark mb-3">¿Por que subir una imagen?</h2>
				 <p class="mb-0">Una imagen real de tu platillo, permite al visitante el conocer tu producto. ¡¡Recuerda que el antojo entra por los ojos!!</p>
		  </br>
				<h2 class="tm-media-2-header tm-text-pink-dark mb-3">¿Que hago si no tengo una imagen?</h2>
				 <p class="mb-0">Sabemos que al inicio puedes no tener imagenes; puedes subir el logo de tu negocio.!La imagen puedes modificarla despues!</p>
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
