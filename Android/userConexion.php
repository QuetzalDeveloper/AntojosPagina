<?php
	$servidor = "localhost"; //Servidor MySQL
    $usuario = "id10300639_superuser";  //Usuario en la base de datos
    $password = "!ux)l-A--4eJH>33";     //Contraseña de la base de datos
    $base = "id10300639_antojos";  //Nombre de la base de datos

// Abrir conexión en el servidor. Parámetros: datos del servidor, user, pass

    $conexion = mysqli_connect($servidor, $usuario, $password);

//Preguntar si se realizó la conexión a la base de datos
    
    if(!$conexion){
        die('<strong>No se pudo conectar: </strong>'.mysql_error());
    }
    else{
        echo "Conectado satisfactoriamente <br/>";
    }

    //Seleccionar la base de datos a usar o trabajar
    
    mysqli_select_db($conexion, $base) or die(mysql_error($conexion));

?>