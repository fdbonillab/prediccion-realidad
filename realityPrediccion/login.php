<?php

// Necesario iniciar la sesion antes de crearla (linea 23)
session_start();

require_once 'includes/conexion.php';

if(!empty($_POST['email']) && !empty($_POST['password'])){
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM usuario WHERE correo = '$email'";
    $login = mysqli_query($db, $sql);

    $usuario = mysqli_fetch_assoc($login);
    //echo("mensaje1");
    //phpinfo();
    // Comprobacion de la contraseña introducida por el usuario y la almacenada en la base de datos
    if( $usuario && count($usuario) ){
        $verify = password_verify($password, $usuario['contraseña']);
        //error_log("mensaje 22 ".print_r($usuario));
        //echo("mensaje 3 ".$verify);
        $mensaje = "";
         // Si los resultados (count) son mayores a cero y la contraseña se verifica ...
        if(count($usuario) > 0 && $verify){
            // Almacenamos a ese nuevo usuario en una sesion activa para que navegue
            $_SESSION['id_usuario'] = $usuario;
            header('Location: index.php');
        }else{
            $mensaje = "Lo sentimos, sus datos son incorrectos";
        }
    } else{
        $mensaje = "Lo sentimos, sus datos son incorrectos";
    }
}
?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accede con tu cuenta</title>

    <link rel="stylesheet" href="css/styles.css">
       <!-- hacer q este estilo funcione desde la carpeta de css  -->
       <style type="text/css">
            .bgimg {
                <?php ?>
                background-image: url('img/casaFamososNeutro.jpg');
                <?php ?>
                color: white;
            }
            a:link, a:visited {
            color: white;
            size: 20px;
            padding: 15px 25px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            }
        </style>
</head>
<body>
<script type="text/javascript">
        function cambiarIdioma( elIdioma ){
            if( elIdioma === 'ingles' ){
                document.getElementById('idIniciarSession').innerHTML= "login";
                document.getElementById('id_email').innerHTML= "email";
                document.getElementById('id_pass').innerHTML= "password";
                document.getElementById('enviar').value= "enter";
                
                          
            } else if( elIdioma == 'espanol') {
                document.getElementById('idIniciarSession').innerHTML= "Iniciar sessión";
                document.getElementById('id_email').innerHTML= "correo";
                document.getElementById('id_pass').innerHTML= "Contraseña";
                document.getElementById('enviar').value= "Entrar!";
            } 
        }
  </script>
    <?php require_once 'includes/cabecera.php' ?>

    <!-- Mensaje a imprimir en caso de que de error el login -->
    <div class="bgimg">
    <div style="text-align:right;">
            <a href="javascript:cambiarIdioma('ingles')" id="cambiarIngles">English</a>
            <a href="javascript:cambiarIdioma('espanol')" id="cambiarEspañol">Español</a>
            </div>
    <?php if(!empty($mensaje)) : ?>
        <p id="error"> <?= $mensaje ?> </p>
    <?php endif; ?>

    <h1 id="idIniciarSession" >Iniciar sesión</h1>
    <span>o <a href="singup.php">Registrarse</a></span>

    <form id="login" action="login.php" method="POST">
        <label for="email" id="id_email">Email</label>
        <input type="email" name="email" placeholder="Introduce tu email">
        <label for="password" id="id_pass">Contraseña</label>
        <input type="password" name="password" placeholder="Introduce tu contraseña">

        <input type="submit" id="enviar" value="Entrar!">    
    </form>
    </div>
    <?php require_once 'includes/footer.php' ?>