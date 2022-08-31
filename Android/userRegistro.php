<?php
 
include('../userConexion.php');

if($_SERVER['REQUEST_METHOD']=='POST'){
	$email = $_POST['email'];
    $nombre = $_POST['nombre'];
    $telefono = $_POST['telefono'];
    $password = $_POST['password'];
    $password_hash = password_hash($password, PASSWORD_BCRYPT);
 
	
    $query = mysqli_query($conexion,"SELECT * FROM usuario WHERE correo= '".$email."'");
    $filas = $query->num_rows;
    if ( $filas > 0) {
        $response['success']=false;
		$response['message']="Correo ya registrado";
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
             $response['success']=false;
			 $response['message']="Error en el registro";
        }
        
        if ($result) {
            $response['success']=true;
			$response['message']="Registrado correctamente";
        } else {
            $response['success']=false;
			$response['message']="Error en el servidor";
        }
    }
}

echo json_encode();

?>