<?php

//$server = 'localhost:3308';
$server = 'localhost';
$username = 'id21926015_admin';
$password = 'Once123456.';
$database = 'id21926015_prediccion';

$db = mysqli_connect($server, $username, $password, $database);

// Comprobacion de conexión satisfactoria o no
try{
    $con = new PDO("mysql:host=$server;dbname=$database;", $username, $password);
} catch(PDOException $e){
    die('Conexion fallida: '. $e->getMessage());

}

// Codificación de caracteres a uft8
mysqli_query($db, "SET NAMES 'utf8");