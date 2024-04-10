<?php
    session_start();
    //phpinfo();
    error_log(' get idReality '.$_GET['idReality']);
    require_once 'includes/conexion.php';

    // Si existe la sesion el email dentro de la sesión id_usuario se realiza la consulta a la base de datos

    /// ***********************************PENDIENTES***********************************************
    /// traer el label debajo de la imagen del jugador escogido en la tabla grande.  hecho
    /// insertar las imagenes de los jugadores en la base de datos y traerlas para mostrar en el popup y en la tabla grande 
    /// guardar la prediccion q se ha hecho en la intermedia a ver q problemas salen
    
    if(isset($_SESSION['id_usuario']['email'])){
        $email = $_SESSION['id_usuario']['email'];

        $sql = "SELECT * FROM usuario WHERE correo = '$email'";
        $login = mysqli_query($db, $sql);

        $usuario = mysqli_fetch_assoc($login);
    }
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario de registro y acceso</title>

    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/styles2.css">
</head>
<body>
    <?php require_once 'includes/cabecera.php' ?>
           <!--=============== MAIN JS ===============-->
        <script src="js/main.js"></script>
        <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
        <script type="text/javascript"> </script>
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

    <!-- Mensaje que se muestra en caso de que exista la sesión -->
        <div class="bgimg">
            <?php 
            $idUsuario = $_GET['idUsuario'];
            $nombreUsuario = $_SESSION['id_usuario']['nombre'];
            if( $idUsuario != null){
                $sqlUsuario = "SELECT nombre FROM `usuario` where id = ".$_GET['idUsuario'];
                $resUsuario = mysqli_query($db, $sqlUsuario);
                $nombreUsuario = mysqli_fetch_row($resUsuario)[0];?>
                <h1>Estas fueron las predicciones de <?= $nombreUsuario?></h1>
                <?php
            } else {?>
                <h1>Estas fueron tus predicciones <?= $nombreUsuario?></h1>
                <?php
            }
            ?>
       
      

            <?php
                
                $idUsuarioSession = $_SESSION['id_usuario']['id'];
                if( $idUsuario == null){
                    $idUsuario = $idUsuarioSession;
                }
                //SELECT p.id_jugador,j.nombre,p.id_ranking, CASE WHEN re.id_jugador is null THEN 0 ELSE 1 END FROM jugador j,
                // `prediccion`p left join resultado_evento re on p.id_ranking = re.id_ranking where p.id_usuario = 5 and j.id = p.id_jugador; 
                $elQuery = "SELECT p.id_jugador,j.nombre,p.id_ranking, CASE WHEN re.id_jugador is null THEN 0 ELSE 1 END FROM jugador j,
                   `prediccion`p left join resultado_evento re on p.id_ranking = re.id_ranking where p.id_usuario =".$idUsuario.
                " and j.id = p.id_jugador and j.id_reality = ".$_GET['idReality'];
                $res2 = mysqli_query($db,$elQuery);
                //$queryResultArray2 = mysqli_fetch_array($res2);
                ?>
                <table width=50% border="1px" >
                <tr>
                    <th>Puesto</th>
                    <th>Famoso</th>
                    <th>Puntos</th>
                </tr>
                <?php
                 //error_log(" query ".$elQuery);
                 //error_log(" resultado ".print_r($res2));
                 if ($res2) {
                    $totalPuntos = 0;
                    while ($row = mysqli_fetch_row($res2)) {
                       ?><tr><td rowspan="2"><p style="font-size:40px">
                       <?= $row[2] ?></p></td>
                       <td><img src="getImage.php?id=<?=$row[0]?>" width="100px" height="100px"/></td><td rowspan="2"><?= $row[3]?></td></tr>
                       <tr><td> <?= $row[1]?> </td></tr>
                 <?php $totalPuntos+=$row[3];} } ?><tr><td><p style="font-size:40px"> Total puntos </p></td>
                 <td colspan="2"><p style="font-size:40px"><?= $totalPuntos?></p></td></tr></table>
                 <!-- para q se vea la fila de total -->
                 <p style="margin-bottom:3cm;"></p>

        </div>
    <?php require_once 'includes/footer.php' ?>