<?php
session_start();
require_once 'includes/conexion.php';


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
    <title>Predicciones todos</title>

    <link rel="stylesheet" href="css/styles.css">
       <!-- hacer q este estilo funcione desde la carpeta de css  -->
       <style type="text/css">
            .bgimg {
                <?php if ( $_GET['idReality'] == 1 ) {?>
                    background-image: url('img/casa-de-los-famosos.webp');
                <?php }  else if( $_GET['idReality'] == 2 ) {?>
                    background-image: url('img/casaFamososTelemundo.jpg');
                <?php }  else if( $_GET['idReality'] == 3 ) {?>
                    background-image: url('img/torneoCandidatos.jpg');
                <?php } ?>
                color: white;
            }
        </style>
</head>
<body>
<div class="bgimg">
        <?php require_once 'includes/cabecera.php' ?>
        <div style="text-align:right;"><a  href="logout.php" id="logout">Cerrar sesión</a></div>
        <h1>Puntos de las predicciones de todos los usuarios </h1>

            <?php
                //SELECT p.id_jugador,j.nombre,p.id_ranking, CASE WHEN re.id_jugador is null THEN 0 ELSE 1 END FROM jugador j,
                // `prediccion`p left join resultado_evento re on p.id_ranking = re.id_ranking where p.id_usuario = 5 and j.id = p.id_jugador; 
                $elQuery = " SELECT p.id_usuario, u.nombre,sum(CASE WHEN re.id_jugador is null THEN 0 ELSE 1 END) from 
                jugador j, usuario u, `prediccion`p left join resultado_evento re on p.id_ranking = re.id_ranking
                 where j.id = p.id_jugador and u.id = p.id_usuario and j.id_reality = ".$_GET['idReality']." 
                 GROUP by p.id_usuario order by 3 desc;  ";
                $res2 = mysqli_query($db,$elQuery);
                //$queryResultArray2 = mysqli_fetch_array($res2);
                ?>
                <table width=50% border="1px" style="margin-left: auto;margin-right: auto;">
                <tr>
                    <th>Puesto</th>
                    <th>usuario</th>
                    <th>Puntos</th>
                </tr>
                <?php
                 //error_log(" query ".$elQuery);
                 //error_log(" resultado ".print_r($res2));
                 if ($res2) {
                    $rank = 1;
                    while ($row = mysqli_fetch_row($res2)) {
                        $nombre = $row[1];
                        $puntos = $row[2];  
                        $idUsuario = $row[0];
                        $idReality = $_GET['idReality'];
                        error_log(" idReality ".$idReality);
                        $urlPrediccionUsuario = "mostrarPrediccion.php?idReality=".$idReality;
                        error_log(" urlprediccion ".$urlPrediccionUsuario);
                        $urlPrediccionUsuario = $urlPrediccionUsuario."&idUsuario=".$idUsuario;
                        error_log(" urlprediccion ".$urlPrediccionUsuario);
                       ?><tr><td >
                       <?= $rank ?></td>
                       <td><a  href="<?=$urlPrediccionUsuario?>" >
                       <?= $nombre ?> </a> </td>
                       <td> <?= $puntos ?> </td></tr>
                 <?php $rank++;} } ?></table>
        </div>   
    <?php require_once 'includes/footer.php' ?>