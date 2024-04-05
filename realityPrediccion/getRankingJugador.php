<?php

///$result = mysqli_execute_query($link, $sql, [$_GET['id']]);

//print_r($resRank);
echo getRankingJugador( $id_jugador = $_GET['id_jugador']);

function getRankingJugador($id_jugador){
    require_once 'includes/conexion.php';
    $sql = "SELECT id_ranking FROM resultado_evento WHERE id_jugador =$id_jugador ";
    $result = mysqli_query($db, $sql);
    $resRank=mysqli_fetch_assoc($result);
    return $resRank['id_ranking'];
}
function getRankingJugador2($id_jugador,$db){
    $sql = "SELECT id_ranking FROM resultado_evento WHERE id_jugador =$id_jugador ";
    $result = mysqli_query($db, $sql);
    $resRank=mysqli_fetch_assoc($result);
    return $resRank['id_ranking'];
}