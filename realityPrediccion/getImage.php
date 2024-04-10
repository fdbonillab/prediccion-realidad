<?php
require_once 'includes/conexion.php';
///$result = mysqli_execute_query($link, $sql, [$_GET['id']]);
$id = $_GET['id'];
$sql = "SELECT imagen FROM jugador WHERE id =$id ";
$result = mysqli_query($db, $sql);
$image = mysqli_fetch_column($result);
header("Content-type: image/jpeg");
echo $image;
