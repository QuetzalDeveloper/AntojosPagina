<?php
 
include('userConexion.php');
session_start();
 
if (isset($_POST['login'])) {
 
    $email = $_POST['email'];
    $password = $_POST['password'];
 
    $query = mysqli_query($conexion, "SELECT * FROM persona WHERE correo = '".$email."'");
    $filas = $query->num_rows;
    if ($filas == 0) {
        echo '<p class="error">El correo no está registrado</p>';
    } else {
        $result = mysqli_fetch_array($query);
        if (password_verify($password, $result['password'])) {
            echo '<p class="succes">Felicidades, iniciaste sesión</p>';
        } else {
            echo '<p class="error">Contraseña incorrecta</p>';
        }
    }
}
 
?>