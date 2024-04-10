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
      error_log(" value guardar ".$value);
      $obj = json_decode($value);
      //error_log(" obj json ".$obj);
      if( $obj != null  ){
          ///print $obj->{'foo-bar'}; // 12345
          /// value guardar {id_ranking:1,id_jugador:20}
          $id_ranking =  $obj->{'id_ranking'};
          $id_jugador =  $obj->{'id_jugador'};
          $fecha = date('Y-m-d');
          error_log(" date guardar ".$fecha);
          if( $id_jugador != null && $id_ranking != null ){
            $sql = "INSERT INTO prediccion (id_usuario, id_jugador, id_ranking, fecha )
            VALUES ( $id_usuario,$id_jugador, $id_ranking, '$fecha'  )";
             error_log(" registro a guardar ".$sql );
            //error_log(" sql insert ".$sql);
            if ($db->query($sql) === TRUE) {
              //echo "record created successfully";
              //redirect('mostrarPrediccion.php');
              error_log(" registro guardado ");
            } else {
              echo "Error: " . $sql . "<br>" . $db->error;
            }
          }
        }
    }
    $i++;//// el indice afuera porque si no las posiciones del ranking quedan mal
}
redirect('mostrarPrediccion.php?idReality='.$_POST['idReality']);

function redirect($url) {
  header('Location: '.$url);
  die();
}



