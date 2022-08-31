<?php
 
include('userConexion.php');
session_start();
 
if (isset($_POST['registrar'])) {
 
    $email = $_POST['email'];
    $nombre = $_POST['nombre'];
    $telefono = $_POST['telefono'];
    $password = $_POST['password'];
    $password_hash = password_hash($password, PASSWORD_BCRYPT);
	
    $query = mysqli_query($conexion,"SELECT * FROM usuario WHERE correo= '".$email."'");
    $filas = $query->num_rows;
    if ( $filas > 0) {
        echo '<p class="error">La cuenta con este correo ya esta almacenado!</p>';
        $query -> close();
    }
    else{
        $query -> close();
       if($query = $conexion->prepare("INSERT INTO usuario(correo, nombre, telefono,estatus, password)
	   VALUES (?, ?, ?, 0, ?)")){
            $query->bind_Param('ssss', $email,$nombre,$telefono,$password_hash);
           $result = $query->execute();
       }
        else{
             $error = $conexion->errno . ' ' . $conexion->error;
            echo "Error> ".$error; // 1054 Unknown column 'foo' in 'field list'
        }
        
        if ($result) {
            echo '<p class="success">Tu registro ha sido exitoso!</p>';
        } else {
            echo '<p class="error">El servidor no está disponible</p>';
        }
    }
}

?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Documento sin título</title>
</head>

<body>
</body>
</html>