<?php
include('conexion.php');
session_start();
if(isset($_POST['login'])){
	$email = $_POST['correo'];
	$contr = $_POST['contra'];
	$filas = 0;
	$query = mysqli_query($conexion, 'SELECT correo,password,status FROM negocio WHERE correo="'.$email.'"');
	$filas = $query->num_rows;
	if($filas == 0){ //El correo no esta registrado
		echo '<p class="error">El correo no esta registrado.  ¡¡Crea una cuenta gratis!!.</p>';
	}else{
		$result = mysqli_fetch_array($query);
		if(password_verify($contr, $result['password'])){
			if($result['status'] != 0){
				$_SESSION['correo'] = $email;
				echo '<script language="javascript">window.location.href="PrincipalNegocio.php"</script>';
			}else{	//La cuenta no esta activada
				echo '<p class="error">La cuenta no se ha activado. Verifica tu correo de confirmación.</p>';
			}
		}else{ //La contrasena es incorrecta
			echo '<p class="error">La contraseña es incorrecta.</p>';
		}
	}
}
?>
<!doctype html>
<html lang="es">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Antojos: Iniciar sesión</title>
<link rel="stylesheet" href="css/estiloIS.css" type="text/css" media="all" />   
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
	<div class="container">
  <div class="info">
    <h1>Antojos</h1><span>Negocio</span>
  </div>
</div>
<div class="form">
  <div class="thumbnail"><img src="img/logo.png"/></div>
  <form class="login-form" action="" name="iniciarsesion" method="post" >
    <input type="email" placeholder="Correo" name="correo"/>
    <input type="password" placeholder="Contraseña" name="contra"/>
    <button type="submit" class="btn btn-secondary" name="login">Iniciar sesión</button>
    <p class="message">¿No estás registrado? <a href="registrarnegocio.php">Crea un negocio</a></p>
  </form>
</div>
</body>
</html>