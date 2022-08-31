<?php
	$servidor = "localhost"; 
    $usuario = "root";  
    $password = "";     
    $base = "antojos";  
    $conexion = mysqli_connect($servidor, $usuario, $password);
	mysqli_set_charset($conexion, "utf8");
    mysqli_select_db($conexion, $base) or die(mysql_error($conexion));
?>