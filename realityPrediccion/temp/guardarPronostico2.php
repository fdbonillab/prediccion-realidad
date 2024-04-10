<?php
require_once 'includes/conexion.php';
///$result = mysqli_execute_query($link, $sql, [$_GET['id']]);
$id_usuario = $_POST['id_usuario'];
$arrPrediccion = json_decode($_POST['arr_prediccion']);
$id_ranking = $_POST['id_ranking'];

//$sql = "insert into jugador  WHERE id =$id ";
//$result = mysqli_query($db, $sql);
//$image = mysqli_fetch_column($result);


//error_log(' id_usuario '.$id_usuario.' arrPrediccion '.print_r($arrPrediccion).' id_ranking '.$id_ranking);
$i = 1; /* for illustrative purposes only */
foreach ($arrPrediccion as $value) {
 // echo "Current value of \$a: $value.\n";
    ////// se supone que todos los valores deben venir llenos pero para hacer pruebas de varios registros tocara asi
    if( $value != null && $value != '' ){
      $sql = "INSERT INTO prediccion (id_usuario, id_jugador, id_ranking )
      VALUES ( $id_usuario, $value, $i )";
      //error_log(" sql insert ".$sql);
      if ($db->query($sql) === TRUE) {
        //echo "record created successfully";
        redirect('mostrarPrediccion.php');
      } else {
        echo "Error: " . $sql . "<br>" . $db->error;
      }
    }
    $i++;//// el indice afuera porque si no las posiciones del ranking quedan mal
}

function redirect($url) {
  header('Location: '.$url);
  die();
}



