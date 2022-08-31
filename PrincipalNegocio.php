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
		$maps = $result['maps'];
		$entreg = $result['entrega'];
		$telefo = $result['telfijo'];
		$telcel = $result['telcel'];
		$direcc = $result['calle']." ".$result['numero'].". ".$result['colonia'].". ".$result['cp'];
		$query -> close();
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

  <title>Mi negocio</title>
<!--

Template 2101 Insertion

http://www.tooplate.com/view/2101-insertion

-->
  <!-- load CSS -->
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
                <li class="nav-item active">
                  <a href="PrincipalNegocio.php" class="nav-link tm-nav-link tm-text-white active">Mi negocio</a>
                </li>
                <li class="nav-item">
                  <a href="NuevoPlatillo.php" class="nav-link tm-nav-link tm-text-white">Platillos</a>
                </li>
                <li class="nav-item">
					<a href="EditarNegocio.php" class="nav-link tm-nav-link tm-text-white ">Cuenta</a>
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

      <div class="row tm-albums-container grid">      
      </div>
       <div class="row mb-5">
        <div class="col-xl-12">
          <div class="media-boxes">
			  
			  <?php
			$query = mysqli_query($conexion, 'SELECT * FROM platillos WHERE correo="'.$correo.'" ORDER BY tipo');
			  if($query){
				  $filas = $query -> num_rows;
			  }else{
				  $filas = 0;
			  }
			  $flag = 0;
			  if($filas > 0){
				  for($x = 0; $x < $filas; $x++){
					  $registro = $query -> fetch_object();
					  if($registro->tipo == 1 && $flag != 1){
						  print('<div align="center">
							<p class="tm-site-description" style="color: black; font-size: 300%" >Entrada</p>
							</div>');
						  $flag = 1;
					  }
					  elseif($registro->tipo == 2 && $flag != 2){
						  print('<div align="center">
							<p class="tm-site-description" style="color: black; font-size: 300%" >Aperitivo</p>
							</div>');
						  $flag = 2;
					  }
					  elseif($registro->tipo == 3 && $flag != 3){
						  print('<div align="center">
							<p class="tm-site-description" style="color: black; font-size: 300%" >Sopa, pasta y ensalada</p>
							</div>');
						  $flag = 3;
					  }
					  elseif($registro->tipo == 4 && $flag != 4){
						  print('<div align="center">
							<p class="tm-site-description" style="color: black; font-size: 300%" >Plato principal</p>
							</div>');
						  $flag = 4;
					  }
					  elseif($registro->tipo == 5 && $flag != 5){
						  print('<div align="center">
							<p class="tm-site-description" style="color: black; font-size: 300%" >Postre</p>
							</div>');
						  $flag = 5;
					  }
					  elseif($registro->tipo == 6 && $flag != 6){
						  print('<div align="center">
							<p class="tm-site-description" style="color: black; font-size: 300%" >Bebida</p>
							</div>');
						  $flag = 6;
					  }
					  elseif($registro->tipo == 7 && $flag != 7){
						  print('<div align="center">
							<p class="tm-site-description" style="color: black; font-size: 300%" >Bar y cocteleria</p>
							</div>');
						  $flag = 7;
					  }
					  elseif($registro->tipo == 8 && $flag != 8){
						  print('<div align="center">
							<p class="tm-site-description" style="color: black; font-size: 300%" >Complemento</p>
							</div>');
						  $flag = 8;
					  }
					  elseif($registro->tipo == 9 && $flag != 9){
						  print('<div align="center">
							<p class="tm-site-description" style="color: black; font-size: 300%" >Combo</p>
							</div>');
						  $flag = 9;
					  }
					  
					  if(empty($registro->foto)){
						  print('<div class="media">
						  <img src="'.$logone.'" width="140" height="115" alt="Image" class="mr-3">
						  <div class="media-body  tm-bg-pink-light">
							<div class="tm-description-box">
							  <h5 class="tm-text-wine">'.$registro->nombre.'</h5>
							  <p class="mb-0">'.$registro->descripcion.'</p>
							  <p class="mb-0"></p>
							</div>
							</div>
							<div class="tm-buy-box ">
							  <a href="EditarPlatillo.php?ip='.$registro->idplatillo.'" class="tm-bg-wine tm-text-white tm-buy">Editar</a>
							  <span class="tm-text-wine  tm-price-tag ">$ '.$registro->precio.'</span>
							</div>
						</div>');
					  }else{
						  print('<div class="media">
						  <img src="'.$registro->foto.'" width="140" height="115" alt="Image" class="mr-3">
						  <div class="media-body tm-bg-pink-light">
							<div class="tm-description-box">
							  <h5 class="tm-text-wine">'.$registro->nombre.'</h5>
							  <p class="mb-0">'.$registro->descripcion.'</p>
							  <p class="mb-0"></p>
							</div>
							</div>
							<div class="tm-buy-box ">
							  <a href="EditarPlatillo.php?ip='.$registro->idplatillo.'" class="tm-bg-wine tm-text-white tm-buy">Editar</a>
							  <span class="tm-text-wine  tm-price-tag ">$ '.$registro->precio.'</span>
							</div>
						</div>');
					  }
						
			  }
			  }
			  ?>

          
          </div> <!-- media-boxes -->
        </div>
      </div>

		
	<div class="login-wrapper" align="center">
		<form method="post" action="NuevoPlatillo.php" name="registro-form">
			<div class="submit-row">
				<input type="submit" class="btn btn-secondary" name="registrar" value="Nuevo platillo"/>
			</div>
		</form>
		</br></br>
	</div>
		
		
      <div class="row tm-mb-big tm-subscribe-row">
        <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 tm-bg-gray tm-subscribe-form">
			<?php
			if($entreg == 0){
				echo '<h3 class="tm-text-wine tm-mb-30">Entrega no definida</h3>';
			}elseif($entreg == 1){
				echo '<h3 class="tm-text-wine tm-mb-30">Entrega presencial</h3>';
			}
			elseif($entreg == 2){
				echo '<h3 class="tm-text-wine tm-mb-30">Envío gratuito en tu municipio</h3>';
			}
			elseif($entreg == 3){
				echo '<h3 class="tm-text-wine tm-mb-30">Envío con costo adicional en tu municipio</h3>';
			}
			elseif($entreg == 4){
				echo '<h3 class="tm-text-wine tm-mb-30">Recoger en mostrador</h3>';
			}
			elseif($entreg == 5){
				echo '<h3 class="tm-text-wine tm-mb-30">Entrega presencial y en mostrador</h3>';
			}
			elseif($entreg == 6){
				echo '<h3 class="tm-text-wine tm-mb-30">Entrega presencial y envío gratuito en tu municipio</h3>';
			}
			elseif($entreg == 7){
				echo '<h3 class="tm-text-wine tm-mb-30">Entrega presencial y envío con costo adicional en tu municipio</h3>';
			}
			?>
		  
          <h3 class="tm-text-wine tm-mb-30">Haz tu pedido</h3>
			<?php
			echo ' <p class="tm-mb-30">Teléfono: '.$telefo.'</p>
			<p class="tm-mb-30">Movil/WhatssApp: '.$telcel.'</p>
			<p class="tm-mb-30">Correo: '.$correo.'</p>
			<p class="tm-mb-30">Dirección: '.$direcc.'</p>';
			?>
        </div>
        <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 img-fluid pl-0">
			<?php
			echo '<a href="'.$maps.'" target="_blank" class="nav-link tm-nav-link tm-text-white"><img src= "img/gmaps.png" class = "fas tm-fa-big tm-fa-mb-big img-fluid"></a>';
				?>
		  </div>
      </div>

      
      <footer class="row">
        <div class="col-xl-12">
          <p class="text-center p-4">Copyright &copy; <span class="tm-current-year">2018</span> Quetzal Software 
          
          // Design:  Quetzal Software & Tooplate</p>
        </div>
      </footer>
    </div> <!-- .container -->

  </div> <!-- .main -->

  <!-- load JS -->
  <script src="js/jquery-3.2.1.slim.min.js"></script> <!-- https://jquery.com/ -->
  <script>

    /* DOM is ready
    ---------------------------------------/---------*/
    $(function () {

      if (renderPage) {
        $('body').addClass('loaded');
      }

      $('.tm-current-year').text(new Date().getFullYear());  // Update year in copyright
    });

  </script>
</body>
</html>