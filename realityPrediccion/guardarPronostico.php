<?php
require_once 'includes/conexion.php';
///$result = mysqli_execute_query($link, $sql, [$_GET['id']]);
$id_usuario = $_POST['id_usuario'];
$id_jugador = $_POST['id_jugador'];
$id_ranking = $_POST['id_ranking'];

//$sql = "insert into jugador  WHERE id =$id ";
//$result = mysqli_query($db, $sql);
//$image = mysqli_fetch_column($result);

error_log(' id_usuario '.$id_usuario.' id_jugador '.$id_jugador.' id_ranking '.$id_ranking);

$sql = "INSERT INTO prediccion (id_usuario, id_jugador, id_ranking )
VALUES ( 1, $id_jugador, $id_ranking )";

if ($db->query($sql) === TRUE) {
  echo "record created successfully";
} else {
  echo "Error: " . $sql . "<br>" . $db->error;
}
