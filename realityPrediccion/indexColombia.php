 <?php

require_once 'includes/conexion.php';

$mensaje = "";

$_SESSION['idReality'] = 1;
error_log(' session_id_realilty '.$_SESSION['idReality']);
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
                background-image: url('img/casa-de-los-famosos.webp');
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

    
    <div >
        <div class="bgimg">
            <div style="text-align:right;"><a  href="logout.php" id="logout">Cerrar sesión</a></div>
            <p style="font-size:20px"><a href="misPredicciones.php?idReality=1">Mis predicciones</a></p>
            <p style="font-size:20px"><a href="prediccionesTodos.php?idReality=1">Todas las predicciones</a></p>
            </div>
    </div>
    </div>    
    <?php require_once 'includes/footer.php' ?>