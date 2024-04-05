

<?php

require_once 'includes/conexion.php';
//session_start();
$mensaje = "";

if(!empty($_POST['email']) && !empty($_POST['password'])){
    $nombre = $_POST['nombre'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Cifrado de contraseña por cuatro pasos
    $password_segura = password_hash($password, PASSWORD_BCRYPT, ['cost'=>4]);

    // Creamos la consulta del nuevo usuario
    $sql = "INSERT INTO usuario (id,nombre,correo,contraseña ) VALUES(null, '$nombre', '$email', '$password_segura')";

    // Guardamos a ese nuevo usuario en la base de datos
    $guardar = mysqli_query($db, $sql);

    // Si la consulta ha tenido éxito mostramos el mensaje, en caso contrario se muestra el error
    if($guardar){
        $mensaje = "Registrado con éxito";
    }else{
        $mensaje = "Ha ocurrido un error al registrarse";
    }
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario de registro</title>

    <link rel="stylesheet" href="css/styles.css">
       <!-- hacer q este estilo funcione desde la carpeta de css  -->
       <style type="text/css">
            .bgimg {
                background-image: url('img/ver-futuro1.jpg');
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
    <div class="bgimg">

    <?php require_once 'includes/cabecera.php' ?>

    <!-- Mostramos el mensaje creado anteriormente en caso de éxito o error -->
    <?php if(!empty($mensaje)) : ?>
        <p id="s-exito"> <?= $mensaje ?> </p> <!-- Necesario usar la forma de <.?.= para mostrar el contenido de una variable -->
    <?php endif; ?>
    <script type="text/javascript">
           function cambiarIdioma( elIdioma ){
                //alert(' por aki ');    
                if( elIdioma === 'ingles' ){
                    document.getElementById('idTextoCandidatos').innerHTML= "Chess tournament candidates";
                } else if( elIdioma == 'espanol') {
                    document.getElementById('idTextoCandidatos').innerHTML= "Torneo de candidatos de ajedrez";
                }
            } 
    </script>
    <div >
        <div class="bgimg">
            <div style="text-align:right;">
            <a href="javascript:cambiarIdioma('ingles')" id="cambiarIngles">English</a>
            <a href="javascript:cambiarIdioma('espanol')" id="cambiarEspañol">Español</a>
            <a  href="logout.php" id="logout">Cerrar sesión</a></div>
            <p style="font-size:20px"><a href="indexColombia.php">Casa de los famosos colombia</a></p>
            <p style="font-size:20px"><a href="indexTelemundo.php">Casa de los famosos telemundo</a></p>
            <p style="font-size:20px"><a id="idTextoCandidatos" href="indexChessCandidates.php">Chess tournament candidates</a></p>
            </div>
    </div>
    </div>    
    <?php require_once 'includes/footer.php' ?>