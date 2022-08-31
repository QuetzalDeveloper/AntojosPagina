<?php
/*include("conexion.php");
session_start();
if(isset($_SESSION['correo'])){
	$correo = $_SESSION['correo'];
	$idplat = $_GET['ip'];
	$filas = 0;
	$query = mysqli_query($conexion, 'SELECT * FROM platillos WHERE correo="'.$correo.'" AND idplatillo='.$idplat);
	$filas = $query->num_rows;
	if($filas == 0){ //El correo no esta registrado
		echo '<p class="error">Error de conexion. Intente de nuevo mas tarde.</p>';
	}
	else{
		$result = mysqli_fetch_array($query);
		$nombre = $result['nombre'];
		$descri = $result['descripcion'];
		$tipo = $result['tipo'];
		$precio = $result['precio'];
		$foto = $result['foto'];
		$query -> close();
	}
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
	if(isset($_POST["cambio"])){
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
				if(!empty($foto)){
					unlink($foto);
				}
				if (move_uploaded_file($temp, './logos/'.$correo.'/'.$archivo)) {
					chmod('./logos/'.$correo.'/'.$archivo, 0777);
					$img = "./logos/".$correo."/".$archivo;
					$sql = 'UPDATE platillos SET nombre="'.$nombre.'", descripcion="'.$descri.'", tipo='.$catego.', precio='.$precio.', foto="'.$img.'" WHERE idplatillo='.$idplat.' AND correo="'.$correo.'"';
					if($conexion -> query($sql)){
						echo '<p class="exito">El platillo se ha guardado</p>';
						header('Location: PrincipalNegocio.php');
					}else{
						echo '<p class="error">Lo sentimos, se ha detectado un problema en el servidor.</p>';
					}
				}
				else {
				   echo '<p class="error">Lo sentimos, se ha detectado un problema en el servidor. Vuelve a intentarlo más tarde.</p>';
				}
			  }
		}else if($archivo == ""){
			$sql = 'UPDATE platillos SET nombre="'.$nombre.'", descripcion="'.$descri.'", tipo='.$catego.', precio='.$precio.', foto="'.$foto.'" WHERE idplatillo='.$idplat.' AND correo="'.$correo.'"';
			if($conexion -> query($sql)){
				echo '<p class="exito">El platillo se ha guardado</p>';
				header('Location: PrincipalNegocio.php');
			}else{
				echo '<p class="error">Lo sentimos, se ha detectado un problema en el servidor.</p>';
			}
		}
	}
	if(isset($_POST["eliminar"])){
		$sql = 'DELETE FROM platillos WHERE idplatillo='.$idplat.' AND correo="'.$correo.'"';
		if($conexion -> query($sql)){
			echo '<p class="exito">El platillo se ha eliminado</p>';
			header('Location: PrincipalNegocio.php');
		}else{
			echo '<p class="error">Lo sentimos, se ha detectado un problema en el servidor.</p>';
		}
	}
}else{
	echo '<script language="javascript">window.location.href="index.php"</script>';
}*/
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>Editar platillo</title>

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
            <h2 class="tm-media-2-header">Cambiar datos del platillo</h2>
          </div>
          <div class="tm-bg-gray tm-contact-middle">
<!-- Formulario -->
            <form action="#" method="post" enctype="multipart/form-data">
              <div class="form-group mb-4">
				  <?php
				  echo '<input type="text" id="nombre" name="nombre" class="form-control" value="'.$nombre.'" required/>';
				  ?>    
              </div>
               <div class="form-group mb-4">
				   <?php
                echo '<textarea rows="8" id="descripcion" name="descripcion" class="form-control" required>'.$descri.'</textarea>';
					?>
              </div>
				<div class="form-group mb-4">
                <select name="categorias" class="tm-select" id="categorias" required>
					<?php
					if($tipo == 0){
						echo '<option value="0" selected>Tipo de platillo</option>';
					}else{
						echo '<option value="0">Tipo de platillo</option>';
					}
					if($tipo == 1){
						echo '<option value="1" selected>Entrada</option>';
					}else{
						echo '<option value="1">Entrada</option>';
					}
					if($tipo == 2){
						echo '<option value="2" selected>Aperitivo</option>';
					}else{
						echo '<option value="2">Aperitivo</option>';
					}
					if($tipo == 3){
						echo '<option value="3" selected>Sopa, pasta o ensalada</option>';
					}else{
						echo '<option value="3">Sopa, pasta o ensalada</option>';
					}
					if($tipo == 4){
						echo '<option value="4" selected>Plato principal</option>';
					}else{
						echo '<option value="4">Plato principal</option>';
					}
					if($tipo == 5){
						echo '<option value="5" selected>Postre</option>';
					}else{
						echo '<option value="5">Postre</option>';
					}
					if($tipo == 6){
						echo '<option value="6" selected>Bebida</option>';
					}else{
						echo '<option value="6">Bebida</option>';
					}
					if($tipo == 7){
						echo '<option value="7" selected>Complemento</option>';
					}else{
						echo '<option value="7">Complemento</option>';
					}
					?> 
                </select>
              </div>
			<div class="form-group mb-4">
				<?php
                echo '<input type="text" pattern="[0-9.]+" id="precio" name="precio" class="form-control" value="'.$precio.'"/>';
				?>
			</div>
			<div class="form-group mb-4">
				<p>Foto/imagen actual de tu platillo:</p>
				<?php
				if(empty($foto)){
					echo '<img src= "'.$logone.'" width="140" class = "fas tm-fa-big tm-fa-mb-big img-fluid">';
				}else{
					echo '<img src= "'.$foto.'" width="140" class = "fas tm-fa-big tm-fa-mb-big img-fluid">';
				}
				?>
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
                <button name="cambio" type="submit" class="btn btn-secondary">Guardar cambios</button>
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
				 <p class="mb-0">Sabemos que al inicio puedes no tener imagenes, para esos casos se colocara por defecto el logo de tu negocio.!La imagen puedes modificarla despues!</p>
             </div>
          </div>
        </div>
      </div>
<!-- Eliminar platillo-->
<div class="row tm-mt-big tm-about-row tm-mb-medium">
        <div class="col-xl-12 col-lg-12 col-md-12 col-xs-12 tm-contact-col">
          <div class="tm-contact-left tm-bg-wine tm-text-white text-right p-md-5 p-4">
            <i class="fas fa-3x fa-trash-alt mb-4"></i>
            <h2 class="tm-media-2-header">Eliminar platillo</h2>
          </div>
          <div class="tm-bg-gray tm-contact-middle">
<!-- Formulario -->
            <form action="#" method="post" enctype="multipart/form-data">
              <div class="form-group mb-0">
                <button type="submit" name="eliminar" class="btn btn-secondary">Eliminar platillo</button>
              </div>
            </form>
<!--FIN de formulario-->
          </div>
          <div class="tm-bg-gray tm-contact-right">

             <div>
               <h2 class="tm-media-2-header tm-text-pink-dark mb-3">¿Seguro que quieres eliminarlo?</h2>
               <p class="mb-0">El platillo será eliminado y no podras recuperarlo. Simpre podrás darlo de alta de nuevo.</p>
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
