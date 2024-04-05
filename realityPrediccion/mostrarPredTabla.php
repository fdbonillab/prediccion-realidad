<?php
/// este pagina solo es un componente de otra y no funciona llamandola directamente
?>
        <div class="bgimg">
        <div style="text-align:right;"><a  href="logout.php" id="logout">Cerrar sesión</a></div>
        <h1>Estas fueron tus predicciones <?= $_SESSION['id_usuario']['nombre']?></h1>
      

            <?php
                //SELECT p.id_jugador,j.nombre,p.id_ranking, CASE WHEN re.id_jugador is null THEN 0 ELSE 1 END FROM jugador j,
                // `prediccion`p left join resultado_evento re on p.id_ranking = re.id_ranking where p.id_usuario = 5 and j.id = p.id_jugador; 
                $elQuery = "SELECT p.id_jugador,j.nombre,p.id_ranking, CASE WHEN re.id_jugador is null THEN 0 ELSE 1 END FROM jugador j,
                   `prediccion`p left join resultado_evento re on p.id_ranking = re.id_ranking where p.id_usuario =".$_SESSION['id_usuario']['id'].
                " and j.id = p.id_jugador and j.id_reality = ".$_GET['idReality'];
                $res2 = mysqli_query($db,$elQuery);
                //$queryResultArray2 = mysqli_fetch_array($res2);
                ?>
                <table width=50% border="1px" style="margin-left: auto;margin-right: auto;">
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
        </div>
