<?php
include("conexion.php");
session_start();
if(isset($_SESSION['correo'])){
	$correo = $_SESSION['correo'];
	$filas = 0;
	$edohorarios=0;
	$query = mysqli_query($conexion, 'SELECT * FROM negocio WHERE correo="'.$correo.'"');
	$filas = $query->num_rows;
	if($filas == 0){ //El correo no esta registrado
		echo '<p class="error">Error de conexion. Intente de nuevo mas tarde.</p>';
	}
	else{
		$result = mysqli_fetch_array($query);
		$negnom = $result['negnombre'];
		$slogan = $result['slogan'];
		$catego = $result['categoria'];
		$usnomb = $result['usnombre'];
		$usapel = $result['usapellidos'];
	    $telfij = $result['telfijo'];
		$telcel = $result['telcel'];
		$logone = $result['logo'];
		$callen = $result['calle'];
		$numero = $result['numero'];
		$codpos = $result['cp'];
		$coloni = $result['colonia'];
		$munici = $result['municipio'];
		$estado = $result['estado'];
		$gomaps = $result['maps'];
		$entreg = $result['entrega'];
		$status = $result['status'];
		$fecreg = $result['fechareg'];
		$idplan = $result['idplan'];
		$inipla = $result['iniplan'];
		$finpla = $result['finplan'];
		$contra = $result['password'];
		$query -> close();
	}
	if(isset($_POST['negocio'])){
		$n= strtoupper(trim($_POST['negnombre']));
		$s = trim($_POST['lema']);
		$c = $_POST['categorias'];
		if(empty($n)){
			echo '<p class="error">El nombre del negocio no puede estar vacío</p>';
		}else if($c == 0){
			echo '<p class="error">Debes definir una categoría</p>';
		}else{
			$sql = 'UPDATE negocio SET negnombre = "'.$n.'", slogan="'.$s.'", categoria='.$c.' WHERE correo="'.$correo.'"';
			if($conexion -> query($sql)){
				$negnom = $n;
				$slogan = $s;
				$catego = $c;
				echo '<p class="exito">Actualizacion de negocio exitosa</p>';
			}else{
				echo '<p class="error">Lo sentimos, se ha detectado un problema en el servidor. Vuelve a intentarlo más tarde.</p>';
			}
		}
	}
	if(isset($_POST['contacto'])){
		$u = ucwords(strtolower(trim($_POST["nombre"])));
		$a = ucwords(strtolower(trim($_POST["apellidos"])));
		$t = $_POST["telfijo"];
		$c = $_POST["telcel"];
		if(empty($u)){
			echo '<p class="error">El nombre del contacto no puede ir vacío</p>';
		}else if(empty($t)){
			echo '<p class="error">Debes de tener un número teléfonico</p>';
		}else{
			$sql = 'UPDATE negocio SET usnombre="'.$u.'", usapellidos="'.$a.'", telfijo="'.$t.'", telcel="'.$c.'" WHERE correo="'.$correo.'"';
			if($conexion -> query($sql)){
				$usnomb = $u;
				$usapel = $a;
				$telfij = $t;
				$telcel = $c;
				echo '<p class="exito">Actualizacion de contacto exitosa</p>';
			}else{
				echo '<p class="error">Lo sentimos, se ha detectado un problema en el servidor. Vuelve a intentarlo más tarde.</p>';
			}
		}
	}
	if(isset($_POST['direccion'])){
		$c = ucwords(strtolower(trim($_POST["calle"])));
		$n = $_POST["numero"];
		$p = $_POST["cp"];
		$o = ucwords(strtolower(trim($_POST["colonia"])));
		$m = ucwords(strtolower(trim($_POST["municipio"])));
		$e = $_POST["estado"];
		$a = $_POST["maps"];
		if(empty($c)){
			echo '<p class="error">Debes colocar el nombre de la calle</p>';
		}else if(empty($o)){
			echo '<p class="error">Debes colocar la colonia</p>';
		}else if(empty($m)){
			echo '<p class="error">Debes colocar el municipio/delegación</p>';
		}else{
			$sql = 'UPDATE negocio SET calle="'.$c.'", numero="'.$n.'", cp="'.$p.'", colonia="'.$o.'", municipio="'.$m.'", estado="'.$e.'", maps="'.$a.'" WHERE correo="'.$correo.'"';
			if($conexion -> query($sql)){
				$callen = $c;
				$numero = $n;
				$codpos = $p;
				$coloni = $o;
				$munici = $m;
				$estado = $e;
				$gomaps = $a;
				echo '<p class="exito">Actualizacion de la dirección exitosa</p>';
			}else{
				echo '<p class="error">Lo sentimos, se ha detectado un problema en el servidor. Vuelve a intentarlo más tarde.</p>';
			}
		}
	}
	if(isset($_POST['horarios'])){
		$abre = [$_POST["luna"], $_POST["mara"], $_POST["miea"], $_POST["juea"], $_POST["viea"], $_POST["saba"], $_POST["doma"]];
		$cierra = [$_POST["lunc"], $_POST["marc"], $_POST["miec"], $_POST["juec"], $_POST["viec"], $_POST["sabc"], $_POST["domc"]];
		$filas = 0;
		$query = mysqli_query($conexion, 'SELECT * FROM horario WHERE correo="'.$correo.'"');
		$filas = $query->num_rows;
		if($filas == 0){
			$sql = 'INSERT INTO horario (correo,dia,abre,cierra) VALUES(?, ?, ?, ?)';
			for($i = 0; $i<7; $i++){
				$sem = $i +1;
				if($query = $conexion -> prepare($sql)){
					$query->bind_Param('siii', $correo, $sem, $abre[$i], $cierra[$i]);
					$result = $query->execute();
				}
				else{
					$error = $conexion->errno . ' ' . $conexion->error;
					echo '<p class="error">Error: '.$error.'</p>'; // 1054 Unknown column 'foo' in 'field list'
				}
			}
		}else{
			for($i = 0; $i<7; $i++){
				$sql = 'UPDATE horario SET abre="'.$abre[$i].'", cierra="'.$cierra[$i].'" WHERE correo="'.$correo.'" AND dia='.($i+1);
				if($conexion -> query($sql)){
				}else{
					echo '<p class="error">Lo sentimos, se ha detectado un problema en el servidor. Vuelve a intentarlo más tarde.</p>';
				}
			}
			echo '<p class="exito">Actualizacion de la dirección exitosa</p>';
		}
	}
	if(isset($_POST['envio'])){
		$e = $_POST['entrega'];
		$sql = 'UPDATE negocio SET entrega='.$e.' WHERE correo="'.$correo.'"';
		if($conexion -> query($sql)){
			$entreg = $e; 
			echo '<p class="exito">Actualizacion de la dirección exitosa</p>';
		}else{
			echo '<p class="error">Lo sentimos, se ha detectado un problema en el servidor. Vuelve a intentarlo más tarde.</p>';
		}
	}
	if(isset($_POST['logo'])){
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
				if(!empty($logone)){
					unlink($logone);
				}
				if (move_uploaded_file($temp, './logos/'.$correo.'/'.$archivo)) {
					chmod('./logos/'.$correo.'/'.$archivo, 0777);
					$sql = 'UPDATE negocio SET logo="./logos/'.$correo.'/'.$archivo.'" WHERE correo="'.$correo.'"';
					if($conexion -> query($sql)){
						$logone = $archivo; 
						echo '<p class="exito">El logo se ha actualizado</p>';
					}else{
						echo '<p class="error">Lo sentimos, se ha detectado un problema en el servidor.</p>';
					}
				}
				else {
				   echo '<p class="error">Lo sentimos, se ha detectado un problema en el servidor. Vuelve a intentarlo más tarde.</p>';
				}
			  }
		}
	}
	if(isset($_POST['cambio'])){
		$old = $_POST["old"];
		$new = $_POST["new"];
		$rep = $_POST["rep"];
		if(password_verify($old,$contra)){
			if(strcmp($new, $rep) == 0){
				$hash = password_hash($new, PASSWORD_BCRYPT);
				$sql = 'UPDATE negocio SET password = "'.$hash.'" WHERE correo="'.$correo.'"';
				if($conexion -> query($sql)){
					$contra = $hash; 
					echo '<p class="exito">Actualizacion de la contraseña exitosa.</p>';
				}else{
					echo '<p class="error">Lo sentimos, se ha detectado un problema en el servidor. Vuelve a intentarlo más tarde.</p>';
				}
			}else{
				echo '<p class="error">La nueva contraseña no coincide.</p>';
			}
		}else{
			echo '<p class="error">Tu contraseña actual no coincide.</p>';
		}
	}
}else{
	echo '<script language="javascript">window.location.href="index.php"</script>';
}
function Horario($valor){
	if($valor==24){
		echo '<option value="24" selected>Cerrado</option>';
	}else{
		echo '<option value="24">Cerrado</option>';
	}
	for($i=0; $i<24; $i++){
		if($valor==$i){
			echo '<option value="'.$i.'" selected>'.$i.':00</option>';
		}else{
			echo '<option value="'.$i.'">'.$i.':00</option>';
		}
	}
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>Cuenta</title>
<!--

Template 2101 Insertion

http://www.tooplate.com/view/2101-insertion

-->
  <!-- load CSS -->
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
<!--Menu de la pagina-->
            <nav class="navbar navbar-expand-sm">
              <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                  <a href="PrincipalNegocio.php" class="nav-link tm-nav-link tm-text-white">Mi negocio</a>
                </li>
                <li class="nav-item active">
                  <a href="NuevoPlatillo.php" class="nav-link tm-nav-link tm-text-white ">Platillo</a>
                </li>
                <li class="nav-item">
					<a href="EditarNegocio.php" class="nav-link tm-nav-link tm-text-white active">Cuenta</a>
                </li>
              </ul>
            </nav>
<!--FIN de Menu de la pagina-->
          </div>
        </div>
      </div>
<!--Logo y titulo de la pagina-->
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
<!--FIN de Logo y titulo de la pagina-->
    </div>

    <div class="container">
      <div class="tm-search-form-container">
      </div>

      <div class="row tm-about-row tm-mt-big tm-mb-medium">
      </div>
		
<!--Paneles con menu lateral-->
      <div class="row tm-about-row tm-mb-medium">
	<!--Menu lateral-->
        <div class="tm-tab-links-container">

          <ul class="nav nav-tabs" id="tmTab" role="tablist">
            <li class="nav-item">
              <a class="nav-link tm-bg-gray tm-media-v-center tm-tab-link active" id="home-tab" data-toggle="tab" href="#tab1" role="tab" aria-controls="home" aria-selected="true">
                <i class="fas fa-2x fa-utensils pr-4"></i>
                <p class="media-body mb-0 tm-media-link">Negocio</p>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link tm-bg-gray tm-media-v-center tm-tab-link" id="profile-tab" data-toggle="tab" href="#tab2" role="tab" aria-controls="profile" aria-selected="false">
                <i class="fas fa-2x fa-id-card pr-4"></i>
                <p class="media-body mb-0 tm-media-link">Contacto</p>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link tm-bg-gray tm-media-v-center tm-tab-link" id="contact-tab" data-toggle="tab" href="#tab3" role="tab" aria-controls="contact" aria-selected="false">
                <i class="fas fa-2x fa-map-marker-alt pr-4"></i>
                <p class="media-body mb-0 tm-media-link">Direcci&oacute;n</p>
              </a>
            </li>
			<li class="nav-item">
              <a class="nav-link tm-bg-gray tm-media-v-center tm-tab-link" id="contact-tab" data-toggle="tab" href="#tab4" role="tab" aria-controls="contact" aria-selected="false">
                <i class="fas fa-2x fa-clock pr-4"></i>
                <p class="media-body mb-0 tm-media-link">Horarios</p>
              </a>
            </li>
			 <li class="nav-item">
              <a class="nav-link tm-bg-gray tm-media-v-center tm-tab-link" id="contact-tab" data-toggle="tab" href="#tab5" role="tab" aria-controls="contact" aria-selected="false">
                <i class="fas fa-2x fa-truck pr-4"></i>
                <p class="media-body mb-0 tm-media-link">Entrega</p>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link tm-bg-gray tm-media-v-center tm-tab-link" id="contact-tab" data-toggle="tab" href="#tab6" role="tab" aria-controls="contact" aria-selected="false">
                <i class="fas fa-2x fa-image pr-4"></i>
                <p class="media-body mb-0 tm-media-link">Imagen del negocio</p>
              </a>
            </li>
			  <li class="nav-item">
              <a class="nav-link tm-bg-gray tm-media-v-center tm-tab-link" id="contact-tab" data-toggle="tab" href="#tab7" role="tab" aria-controls="contact" aria-selected="false">
                <i class="fas fa-2x fa-key pr-4"></i>
                <p class="media-body mb-0 tm-media-link">Cambio de contrase&ntilde;a</p>
              </a>
            </li>
          </ul>
        </div>
	<!--FIN de menu lateral-->
	<!--Paneles de informacion-->
        <div class="tm-tab-content-container">
          <div class="tab-content h-100 tm-bg-gray" id="myTabContent">
			 <!--Panel de negocio-->
            <div class="tab-pane fade show active" id="tab1" role="tabpanel" aria-labelledby="tab1-tab">
              <div class="media tm-media-2">
                <i class="fas fa-5x fa-utensils mb-3 tm-text-wine tm-media-2-icon"></i>
                <div class="media-body tm-media-body-2">
					 <p>Informaci&oacute;n del negocio. Verifica tus datos antes de guardar.</p>
            <form action="#" method="post">
              <div class="form-group mb-4">
					<?php
                echo '<input type="text" id="negnombre" name="negnombre" class="form-control" placeholder="Nombre del negocio" value="'.$negnom.'" required/>';
					?>
              </div>
			<div class="form-group mb-4">
					<?php
                echo '<input type="text" id="lema" name="lema" class="form-control" placeholder="Slogan del negocio" value="'.$slogan.'"/>';
					?>
              </div>

              <div class="form-group mb-4">
				  <?php
                echo '<select name="categorias" class="tm-select" id="categorias" required>';
				  if($catego == 0){
					  echo '<option value="0" selected>Tu categoría</option>';
				  }else{
					  echo '<option value="0">Tu categoría</option>';
				  }
				  if($catego == 1){
					  echo '<option value="1" selected>Comida rápida</option>';
				  }else{
					  echo '<option value="1">Comida rápida</option>';
				  }
				  if($catego == 2){
					  echo '<option value="2" selected>Gourmet</option>';
				  }else{
					  echo '<option value="2">Gourmet</option>';
				  }
				  if($catego == 3){
					  echo '<option value="3" selected>Temático</option>';
				  }else{
					  echo '<option value="3">Temático</option>';
				  }
				  if($catego == 4){
					  echo '<option value="4" selected>Buffet</option>';
				  }else{
					  echo '<option value="4">Buffet</option>';
				  }
				  if($catego == 5){
					  echo '<option value="5" selected>Familiar</option>';
				  }else{
					  echo '<option value="5">Familiar</option>';
				  }
				  if($catego == 6){
					  echo '<option value="6" selected>Bar restaurante</option>';
				  }else{
					  echo '<option value="6">Bar restaurante</option>';
				  }
				  if($catego == 7){
					  echo '<option value="7" selected>Cafetería</option>';
				  }else{
					  echo '<option value="7">Cafetería</option>';
				  }
				  echo '</select>';
					?>
              </div>
				<div class="form-group mb-0">
                <button type="submit" class="btn btn-secondary" name="negocio">Cambiar</button>
              </div>
            </form>	
                </div>
              </div>
            </div>
			<!--Panel de contacto-->
            <div class="tab-pane fade" id="tab2" role="tabpanel" aria-labelledby="tab2-tab">
              <div class="media tm-media-2">
                <i class="fas fa-5x fa-id-card mb-3 tm-text-wine tm-media-2-icon"></i>
                <div class="media-body tm-media-body-2">
                 <p>Informaci&oacute;n de cont&aacute;cto. Verifica tus datos antes de guardar. El correo no puede ser cambiado.</p>
			<form action="#" method="post">
              <div class="form-group mb-4">
				  <?php
                echo '<input type="email" id="correo" name="correo" class="form-control" value="'.$correo.'" disabled/>';
					?>
              </div>
				<div class="form-group mb-4">
					<?php
                echo '<input type="text" id="nombre" name="nombre" class="form-control" placeholder="Nombre del usuario" value="'.$usnomb.'" required/>';
					?>
              </div>
				<div class="form-group mb-4">
					<?php
                echo '<input type="text" id="apellidos" name="apellidos" class="form-control" placeholder="Apellidos del usuario" value="'.$usapel.'" required/>';
					?>
              </div>
				<div class="form-group mb-4">
					<?php
                echo '<input type="tel" id="telfijo" name="telfijo" class="form-control" placeholder="Telefono fijo del negocio" value="'.$telfij.'" required/>';
					?>
              </div>
				<div class="form-group mb-4">
				<p>Enlazaremos el n&uacute;mero del tel&eacute;fono m&oacute;vil con el whatssApp del usuario.</p>
					<?php
                echo '<input type="tel" id="telcel" name="telcel" class="form-control" placeholder="Telefono móvil del negocio" value="'.$telcel.'" required/>';
					?>
              </div>
              <div class="form-group mb-0">
                <button type="submit" class="btn btn-secondary" name="contacto">Cambiar</button>
              </div>
            </form>					
					
                </div>
              </div>
            </div>
			<!--Panel de direccion-->
            <div class="tab-pane fade" id="tab3" role="tabpanel" aria-labelledby="tab3-tab">
              <div class="media tm-media-2">
                <i class="fas fa-5x fa-map-marker-alt mb-3 tm-text-wine tm-media-2-icon"></i>
                <div class="media-body tm-media-body-2">
					<p>Con tu direcci&oacute;n, el cliente podr&aacute; localizar tu negocio. Con tu enlace de Google maps, el cliente podr&aacute; tener indicaciones de como llegar a tu restaurante.</p>
                  <form action="#" method="post">
				<div class="form-group mb-4">
					<?php
                echo '<input type="text" id="calle" name="calle" class="form-control" placeholder="Calle" value="'.$callen.'" required/>';
					?>
              </div>
				<div class="form-group mb-4">
					<?php
                echo '<input type="number" id="numero" name="numero" class="form-control" placeholder="Número" value="'.$numero.'" required/>';
					?>
              </div>
				<div class="form-group mb-4">
					<?php
                echo '<input type="number" id="cp" name="cp" class="form-control" placeholder="Código postal" value="'.$codpos.'" required/>';
					?>
              </div>
				<div class="form-group mb-4">
					<?php
                echo '<input type="text" id="colonia" name="colonia" class="form-control" placeholder="Colonia" value="'.$coloni.'" required/>';
					?>
              </div>
				<div class="form-group mb-4">
					<?php
                echo '<input type="text" id="municipio" name="municipio" class="form-control" placeholder="Municipio/delegacion" value="'.$munici.'" required/>';
					?>
              </div>
				<div class="form-group mb-4">
					<?php
                echo '<select name="estado" class="tm-select" id="estado" required>';
					if($estado==0){
						echo '<option value="0" selected>Estado</option>';
					}else{
						echo '<option value="0">Estado</option>';
					}
					if($estado==1){
						echo '<option value="1" selected>Aguascalientes</option>';
					}else{
						echo '<option value="1">Aguascalientes</option>';
					}
					if($estado==2){
						echo '<option value="2" selected>Baja California</option>';
					}else{
						echo '<option value="2">Baja California</option>';
					}
					if($estado==3){
						echo '<option value="3" selected>Baja California Sur</option>';
					}else{
						echo '<option value="3">Baja California Sur</option>';
					}
                    if($estado==4){
						echo '<option value="4" selected>Campeche</option>';
					}else{
						echo '<option value="4">Campeche</option>';
					}
                    if($estado==5){
						echo '<option value="5" selected>Chiapas</option>';
					}else{
						echo '<option value="5">Chiapas</option>';
					}
				    if($estado==6){
						echo '<option value="6" selected>Chihuahua</option>';
					}else{
						echo '<option value="6">Chihuahua</option>';
					}
					if($estado==7){
						echo '<option value="7" selected>Ciudad de México</option>';
					}else{
						echo '<option value="7">Ciudad de México</option>';
					}
					if($estado==8){
						echo '<option value="8" selected>Coahuila</option>';
					}else{
						echo '<option value="8">Coahuila</option>';
					}
					if($estado==9){
						echo '<option value="9" selected>Colima</option>';
					}else{
						echo '<option value="9">Ciudad de Colima</option>';
					}
					if($estado==10){
						echo '<option value="10" selected>Durango</option>';
					}else{
						echo '<option value="10">Durango</option>';
					}
					if($estado==11){
						echo '<option value="11" selected>Estado de México</option>';
					}else{
						echo '<option value="11">Estado de México</option>';
					}
					if($estado==12){
						echo '<option value="12" selected>Guanajuato</option>';
					}else{
						echo '<option value="12">Guanajuato</option>';
					}
					if($estado==13){
						echo '<option value="13" selected>Guerrero</option>';
					}else{
						echo '<option value="13">Guerrero</option>';
					}
					if($estado==14){
						echo '<option value="14" selected>Hidalgo</option>';
					}else{
						echo '<option value="14">Hidalgo</option>';
					}
					if($estado==15){
						echo '<option value="15" selected>Jalisco</option>';
					}else{
						echo '<option value="15">Jalisco</option>';
					}
					if($estado==16){
						echo '<option value="16" selected>Michoacán/option>';
					}else{
						echo '<option value="16">Michoacán/option>';
					}
					if($estado==17){
						echo '<option value="17" selected>Morelos</option>';
					}else{
						echo '<option value="17">Morelos</option>';
					}
					if($estado==18){
						echo '<option value="18" selected>Nayarit</option>';
					}else{
						echo '<option value="18">Nayarit</option>';
					}
					if($estado==19){
						echo '<option value="19" selected>Nuevo León</option>';
					}else{
						echo '<option value="19">Nuevo León</option>';
					}
					if($estado==20){
						echo '<option value="20" selected>Oaxaca</option>';
					}else{
						echo '<option value="20">Oaxaca</option>';
					}
					if($estado==21){
						echo '<option value="21" selected>Puebla</option>';
					}else{
						echo '<option value="21">Puebla</option>';
					}
					if($estado==22){
						echo '<option value="22" selected>Querétaro</option>';
					}else{
						echo '<option value="22">Querétaro</option>';
					}
					if($estado==23){
						echo '<option value="23" selected>Quintana Roo	</option>';
					}else{
						echo '<option value="23">Quintana Roo	</option>';
					}
					if($estado==24){
						echo '<option value="24" selected>San Luis Potosí</option>';
					}else{
						echo '<option value="24">San Luis Potosí</option>';
					}
					if($estado==25){
						echo '<option value="25" selected>Sinaloa</option>';
					}else{
						echo '<option value="25">Sinaloa</option>';
					}
					if($estado==26){
						echo '<option value="26" selected>Sonora</option>';
					}else{
						echo '<option value="26">Sonora</option>';
					}
					if($estado==27){
						echo '<option value="27" selected>Tabasco</option>';
					}else{
						echo '<option value="27">Tabasco</option>';
					}
					if($estado==28){
						echo '<option value="28" selected>Tamaulipas</option>';
					}else{
						echo '<option value="28">Tamaulipas</option>';
					}
					if($estado==29){
						echo '<option value="29" selected>Tlaxcala</option>';
					}else{
						echo '<option value="29">Tlaxcala</option>';
					}
					if($estado==30){
						echo '<option value="30" selected>Veracruz</option>';
					}else{
						echo '<option value="30">Veracruz</option>';
					}
					if($estado==31){
						echo '<option value="31" selected>Yucatán</option>';
					}else{
						echo '<option value="31">Yucatán</option>';
					}
					if($estado==32){
						echo '<option value="32" selected>Zacatecas</option>';
					}else{
						echo '<option value="32">Zacatecas</option>';
					}
                echo '</select>';
					?>
              </div>
				<p>Si tu negocio esta en maps, pega el enlace aqui:</p>
				<div class="form-group mb-4">
					<?php
                echo '<input type="text" id="maps" name="maps" class="form-control" placeholder="Enlace" value="'.$gomaps.'"/>';
					?>
              </div>
				
              <div class="form-group mb-0">
                <button type="submit" class="btn btn-secondary" name="direccion">Cambiar</button>
              </div>
            </form>
                </div>
              </div>
            </div>
			  <!--Panel de Horarios-->
			  <div class="tab-pane fade" id="tab4" role="tabpanel" aria-labelledby="tab4-tab">
              <div class="media tm-media-2">
                <i class="fas fa-5x fa-clock mb-3 tm-text-wine tm-media-2-icon"></i>
                <div class="media-body tm-media-body-2">
                	<p>Horarios de apertura y cierre de tu negocio. Los clientes podran saber si tu negocio esta disponible los d&iacute;as y horas que desean.</p>
            <form action="#" method="post">
				<?php
				$filas = 0;
				$query = mysqli_query($conexion, 'SELECT * FROM horario WHERE correo="'.$correo.'"');
				$filas = $query->num_rows;
				if($filas == 0){ //El correo no esta registrado
					$edohorarios=0;
					echo '<div class="form-group mb-4">';
					
					echo 'Lunes:
					<select name="luna" class="tm-select" id="luna" required>';
					Horario(24);
					echo '</select>
					<select name="lunc" class="tm-select" id="lunc" required>';
					Horario(24);
					echo '</select>';
					
					echo 'Martes:
					<select name="mara" class="tm-select" id="mara" required>';
					Horario(24);
					echo '</select>
					<select name="marc" class="tm-select" id="marc" required>';
					Horario(24);
					echo '</select>';
					
					echo 'Miércoles:
					<select name="miea" class="tm-select" id="miea" required>';
					Horario(24);
					echo '</select>
					<select name="miec" class="tm-select" id="miec" required>';
					Horario(24);
					echo '</select>';	
					
					echo 'Jueves:
					<select name="juea" class="tm-select" id="juea" required>';
					Horario(24);
					echo '</select>
					<select name="juec" class="tm-select" id="juec" required>';
					Horario(24);
					echo '</select>';
					
					echo 'Viernes:
					<select name="viea" class="tm-select" id="viea" required>';
					Horario(24);
					echo '</select>
					<select name="viec" class="tm-select" id="viec" required>';
					Horario(24);
					echo '</select>';
					
					echo 'Sabado:
					<select name="saba" class="tm-select" id="saba" required>';
					Horario(24);
					echo '</select>
					<select name="sabc" class="tm-select" id="sabc" required>';
					Horario(24);
					echo '</select>';
					
					echo 'Domingo:
					<select name="doma" class="tm-select" id="doma" required>';
					Horario(24);
					echo '</select>
					<select name="domc" class="tm-select" id="domc" required>';
					Horario(24);
					echo '</select>';
					
					echo '</div>';
				}else{
					$edohorarios=1;
					for($x = 0; $x < $filas; $x++){
						$registro = $query -> fetch_object();
						echo '<div class="form-group mb-4">';
						if($registro->dia == 1){
							echo 'Lunes:
							<select name="luna" class="tm-select" id="luna" required>';
							Horario($registro->abre);
							echo '</select>
							<select name="lunc" class="tm-select" id="lunc" required>';
							Horario($registro->cierra);
							echo '</select>';
              				
						}else if($registro->dia == 2){
							echo 'Martes:
							<select name="mara" class="tm-select" id="mara" required>';
							Horario($registro->abre);
							echo '</select>
							<select name="marc" class="tm-select" id="marc" required>';
							Horario($registro->cierra);
							echo '</select>';
              				
						}else if($registro->dia == 3){
							echo 'Miércoles:
							<select name="miea" class="tm-select" id="miea" required>';
							Horario($registro->abre);
							echo '</select>
							<select name="miec" class="tm-select" id="miec" required>';
							Horario($registro->cierra);
							echo '</select>';
              				
						}else if($registro->dia == 4){
							echo 'Jueves:
							<select name="juea" class="tm-select" id="juea" required>';
							Horario($registro->abre);
							echo '</select>
							<select name="juec" class="tm-select" id="juec" required>';
							Horario($registro->cierra);
							echo '</select>';
              				
						}else if($registro->dia == 5){
							echo 'Viernes:
							<select name="viea" class="tm-select" id="viea" required>';
							Horario($registro->abre);
							echo '</select>
							<select name="viec" class="tm-select" id="viec" required>';
							Horario($registro->cierra);
							echo '</select>';
              				
						}else if($registro->dia == 6){
							echo 'Sabado:
							<select name="saba" class="tm-select" id="saba" required>';
							Horario($registro->abre);
							echo '</select>
							<select name="sabc" class="tm-select" id="sabc" required>';
							Horario($registro->cierra);
							echo '</select>';
              				
						}else if($registro->dia == 7){
							echo 'Domingo:
							<select name="doma" class="tm-select" id="doma" required>';
							Horario($registro->abre);
							echo '</select>
							<select name="domc" class="tm-select" id="domc" required>';
							Horario($registro->cierra);
							echo '</select>';
              				
						}
						echo '</div>';
					}
					$query -> close();
				}
				?>
				<div class="form-group mb-0">
                <button type="submit" class="btn btn-secondary" name="horarios">Cambiar</button>
              </div>
            </form>	
                </div>
              </div>
            </div>
			<!--Panel de entrega-->
			  <div class="tab-pane fade" id="tab5" role="tabpanel" aria-labelledby="tab5-tab">
              <div class="media tm-media-2">
                <i class="fas fa-5x fa-truck mb-3 tm-text-wine tm-media-2-icon"></i>
                <div class="media-body tm-media-body-2">
                	<p>¿Como entregas tu producto?. Las entregas y costos de envío de tu negocio se aplica solo en tu delegación o municipio.</p> 
            <form action="#" method="post">
               <div class="form-group mb-4">
				   
                <select name="entrega" class="tm-select" id="entrega" required>
					<?php
					if($entreg == 0){
					  echo '<option value="0" selected>Sin definir</option>';
				  	}else{
					  echo '<option value="0">Sin definir</option>';
				  	}
					if($entreg == 1){
					  echo '<option value="1" selected>Presencial</option>';
				  	}else{
					  echo '<option value="1">Presencial</option>';
				  	}
					if($entreg == 2){
					  echo '<option value="2" selected>Envío gratuito</option>';
				  	}else{
					  echo '<option value="2">Envío gratuito</option>';
				  	}
					if($entreg == 3){
					  echo '<option value="3" selected>Envío con costo adicional</option>';
				  	}else{
					  echo '<option value="3">Envío con costo adicional</option>';
				  	}
					if($entreg == 4){
					  echo '<option value="4" selected>Recoger en mostrador</option>';
				  	}else{
					  echo '<option value="4">Recoger en mostrador</option>';
				  	}
					if($entreg == 5){
					  echo '<option value="5" selected>Presencial / recoger en mostrador</option>';
				  	}else{
					  echo '<option value="5">Presencial / recoger en mostrador</option>';
				  	}
					if($entreg == 6){
					  echo '<option value="6" selected>Presencial / envío gratuito</option>';
				  	}else{
					  echo '<option value="6">Presencial / envío gratuito</option>';
				  	}
					if($entreg == 7){
					  echo '<option value="7" selected>Presencial / envío con costo adicional</option>';
				  	}else{
					  echo '<option value="7">Presencial / envío con costo adicional</option>';
				  	}
					?>
                </select>
              </div>
				
				<div class="form-group mb-0">
                <button type="submit" class="btn btn-secondary" name="envio">Cambiar</button>
              </div>
            </form>	
                </div>
              </div>
            </div>
			<!--Panel de Imagen-->
            <div class="tab-pane fade" id="tab6" role="tabpanel" aria-labelledby="tab4-tab">
              <div class="media tm-media-2">
                <i class="fas fa-5x fa-image mb-3 tm-text-wine tm-media-2-icon"></i>
                <div class="media-body tm-media-body-2">
					<p>Ayuda a tus clientes a reconocer tu negocio; sube un logo o imagen que represente tu restaurante.</p>
                  <form action="#" method="post" enctype="multipart/form-data">
				<div class="form-group mb-4">
				<p>Logo/Foto de tu negocio:</p>
                <input type="file" id="imagen" name="imagen" accept="image/*"class="form-control" onchange="validateFileType()" />
				<script type="text/javascript"> 
			function validateFileType(){ 
				var fileName = document.getElementById("fileName").value; 
				//hola.png
					 var idxDot = fileName.lastIndexOf(".") + 1; //posición del cursor despues del punto
					 var extFile = fileName.substr(idxDot, fileName.length).toLowerCase(); //png
					 if (extFile=="jpg" || extFile=="jpeg" || extFile=="png"){ 
					  //TO DO 
					 }else{ 
					  alert("Only jpg/jpeg and png files are allowed!"); 
					 } 
					} 
				</script> 
					</br>
					  </br>
				<p>La imagen no debe ser superior a 2Mb.</p>
				<p>Formatos permitidos: jpg, png y gif</p>
				<p>La imagen que sustituyas se eliminara del servidor al guardar. No podr&aacute;s recuperarlo despues.</p>
			</div>			
              
              <div class="form-group mb-0">
                <button type="submit" class="btn btn-secondary" name="logo">Guardar</button>
              </div>
            </form>
                </div>
              </div>
            </div>
			  <!--Panel de Contrasena-->
			  <div class="tab-pane fade" id="tab7" role="tabpanel" aria-labelledby="tab4-tab">
              <div class="media tm-media-2">
                <i class="fas fa-5x fa-key mb-3 tm-text-wine tm-media-2-icon"></i>
                <div class="media-body tm-media-body-2">
					<p>Evita cambiar tu contrase&ntilde;a continuamente. Al cambiar, tendr&aacute;s que volver a iniciar sesi&oacute;n.</p>
                 <form action="#" method="post">
					<div class="form-group mb-4">
						<input type="password" id="pass" name="old" class="form-control" placeholder="Contraseña anterior:" required />
					  </div>
						<div class="form-group mb-4">
						<input type="password" id="pass" name="new" class="form-control" placeholder="Nueva contraseña:" required/>
					  </div>
						<div class="form-group mb-4">
						<input type="password" id="reppass" name="rep" class="form-control" placeholder="Repetir contraseña:" required/>
					  </div>
					  <div class="form-group mb-0">
						<button type="submit" class="btn btn-secondary" name="cambio">Cambiar</button>
              </div>
            </form>
                </div>
              </div>
            </div>
			  
          </div>

        </div>
	<!--FIN de paneles de informacion-->
      </div>
<!--FIN de paneles con menu lateral-->

<!--Imagen con texto-->
      <div class="row">
        <div class="col-lg-12">
          <div class="tm-tag-line">
			  <?php
			  if($idplan == 1){
				  echo '<h2 class="tm-tag-line-title">
				  <a href="#" class="tm-text-white">Tu plan actual es: Gratuito</a></h2>';
			  }
			  ?>
			</div>
        </div>
      </div>
<!--Fin de imagen con texto-->
	
      <footer class="row tm-about-row">
        <div class="col-xl-12">
          <p class="text-center p-4">Copyright &copy; <span class="tm-current-year">2018</span> Quetzal Software 
          
          - Design: Tooplate & Quetzal Software</p>
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