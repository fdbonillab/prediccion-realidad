<?php
    session_start();
    //phpinfo();
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
    //$idReality = $_GET('idReality');
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
        <script type="text/javascript">
            var arrFamosos = [];
            var arrFamososAux = [];
            var arrPrediccion = [];
            var indiceAux = 0;
            var constAsignar = "asignar";
            var arrElegido = [];
            function jsFunction(){
                alert(' por aki ');    
            }
            /// toco dejar los parametros al contrario por un error de formacion de cadena entre javascript y php
            /// hay q dejar de primeras la variable que se traida de php de otra forma se genera un string de paramatros erroneo
            function jsChangeArrayFamososOld( indice,thisValue ){
                //// indice es para ubicar en la tabla grand
                //// y thisValue es para saber la ubicacion del famoso elegido
                if( arrFamososAux === null ){
                    arrFamososAux = arrFamosos;
                }
                console.log(' thisValue de la lista '+thisValue);
                //console.log(selected.value);
                console.log(' length arr '+arrFamosos.length);
                //arrFamosos = arrFamosos.filter(thisValue);
                const index = arrFamosos.indexOf(thisValue);
                arrElegido[0] = arrFamosos[index][1];
                arrElegido[1] = arrFamosos[index][2];
                //const x = arrFamosos.splice(index, 1);
                console.log(' lenght arra '+arrFamosos.length);
                console.log(" indice para cambiar imagen en jsChange "+indice);
                //cambiarImagenFamoso(indice); //// se comenta porq esta opcion no es compatible con la ventana de confirmacion
                escogerImagenDialogo(indice);
            }
            function jsChangeArrayFamosos( indice ){
                //// indice es para ubicar en la tabla grand
                //// y thisValue es para saber la ubicacion del famoso elegido
                /// creo ahora thisValue va ser indiceAux y el indice de la lista q viene por parametro
                if( arrFamososAux === null ){
                    arrFamososAux = arrFamosos;
                }
                console.log(' length arr '+arrFamosos.length);
                //arrFamosos = arrFamosos.filter(thisValue);
                const index = arrFamosos.indexOf(indice);
                console.log(' indice de escogido '+indice+"  index para slice "+index);
                arrElegido[0] = arrFamosos[indice-1][0];
                arrElegido[1] = arrFamosos[indice-1][1];
                //// aki se estaba borrando de la lista el jugador q se haya elegido
                //const x = arrFamosos.splice(index, 1);
                console.log(' lenght arra '+arrFamosos.length);
                console.log(" indice para cambiar imagen en jsChange "+indice);
                //cambiarImagenFamoso(indice); //// se comenta porq esta opcion no es compatible con la ventana de confirmacion
                escogerImagenDialogo(indice);
            }
            function mostrarModal( indice ){
                var anchoDialogo = 300;
                var altoDialogo = 50;
                var dialog = document.getElementById('dialog1');
                console.log(' window height '+window.innerHeight+" dialog height "+dialog.offsetHeight);
                console.log(' window width '+window.innerWidth+" dialog width "+dialog.offsetWidth);
                dialog.style.top = ((window.innerHeight/2) - (altoDialogo*1.5))+'px';
                dialog.style.left = ((window.innerWidth/2) - (anchoDialogo/2))+'px';
                //dialog.style.width = 50%;
                indiceAux = indice;
                agregarOpcionesLista(arrFamosos,document.getElementsByName('selectFamosoDialogo')[0]);
                dialog.showModal();
            }
            function mostrarModalGuardar( ){
                var anchoDialogo = 300;
                var altoDialogo = 50;
                var dialog = document.getElementById('dialogGuardar');
                console.log(' window height '+window.innerHeight+" dialog height "+dialog.offsetHeight);
                console.log(' window width '+window.innerWidth+" dialog width "+dialog.offsetWidth);
                dialog.style.top = ((window.innerHeight/2) - (altoDialogo*1.5))+'px';
                dialog.style.left = ((window.innerWidth/2) - (anchoDialogo/2))+'px';
              
                dialog.showModal();
            }
            /// en cerrarModal es donde se asignan las cosas en la tabla principal
            function cerrarModal( strAsignar ){
                if( strAsignar && strAsignar === "asignar" ){
                    ///indiceAux es el q lleva el indice de la tabla grande  para no tener q llevarlo y traerlo desde la emergente
                    cambiarImagenFamoso(indiceAux);
                    console.log(' lenght arr antes '+arrFamosos.length);
                    console.log( arrFamosos);
                    const x = arrFamosos.splice(getIndiceArrByIdElegido(arrElegido[0]), 1);
                    console.log(' lenght arr despues '+arrFamosos.length);
                    console.log( arrFamosos);
                }
                var dialog = document.getElementById('dialog1');
                dialog.close();
                reiniciarDialogo();
            }
            function getIndiceArrByIdElegido( idBdJugador ){
                var indiceEncontrado = -1;
                for(var i = 0; i < arrFamosos.length; i++) {
                    if( arrFamosos[i][0] == idBdJugador ){
                        indiceEncontrado = i;
                    }
                }
                console.log(' idbdjugador '+idBdJugador+' indiceEncontrado '+indiceEncontrado);
                return indiceEncontrado;
            }
            function cerrarModalGuardar(  ){
                document.getElementById('dialogGuardar').close();
            }
            function cambiarImagenFamoso(indice){
                //// esto es lo q se cambia en la tabla grande
                $('img')[indice-1].src = "getImage.php?id="+arrElegido[0];////"img/nakamura.jpg";
                document.getElementById("labelJugador"+[indice]).innerText = arrElegido[1];
                //document.getElementById("open-modal"+[indice]).disabled = true;
                document.getElementById("open-modal"+[indice]).style.display="none";
                arrPrediccion[indice] = '{"id_ranking":'+indice+',"id_jugador":'+arrElegido[0]+'}';
                document.getElementById("idPrediccion").value = JSON.stringify(arrPrediccion);
                console.log(" indice para cambiar imagen "+indice);
            }
            ///// esta funcion no es llamada en ningun lado
            /*function cambiarLabelFamoso(indice){
                //$('img')[indice-1].src = "img/nakamura.jpg";
                document.getElementById("labelJugador"+[indice-1]).value = arrElegido[1];
                arrPrediccion[indice] = '{"id_ranking":'+indice+',"id_jugador":'+arrElegido[0]+'}';
                console.log(" indice para cambiar imagen "+indice);
            }*/
            function escogerImagenDialogo(indice){
                /// indice es el id desde la base de datos
                //document.getElementById("imgDialogo").src = "img/nakamura.jpg";}
                //<img src="getImage.php?id=1" width="175" height="200" />
                /// no puedo traer esta image por el indice primero tengo que tranformar que id correponde a ese
                /// indice porq los id quedaron con huecos y pueden quedar con huecos o no empezar desde 1 si pongo mas 
                /// de un reality en la misma tabla
                var idBaseDatos = arrFamosos[indice-1][0];
                console.log(" id para consultar desde array en bd "+idBaseDatos+" indice de lista "+indice);
                document.getElementById("imgDialogo").src = "getImage.php?id="+idBaseDatos;
                //<img src="getImage.php?id=1" width="175" height="200" />
            }
            function reiniciarDialogo(){
                document.getElementById("imgDialogo").src = null;
                document.getElementsByName('selectFamosoDialogo')[0].value = null;
            }
            function agregarOpcionesLista(options, select ){
                ///// no poner el id q trae de la base de datos por que puede q no queden consecutivos
                //// y falle como en este caso que hay un id 23 pero la consulta solo devuelve 21 filas
                //// incluso hay un id 29
                select.innerHTML = "";
                var el = document.createElement("option");
                    //style="background-image:url(1stimage.gif);
                    el.textContent = "...";
                    el.value = 0;/// la posicion y no el id de la base de datos
                    //el.style.backgroundImage = "url('folder/nakamura.jpg')"; 
                    select.appendChild(el);
                for(var i = 0; i < options.length; i++) {
                    var id = options[i][0];
                    var opt = options[i][1];
                    var el = document.createElement("option");
                    //style="background-image:url(1stimage.gif);
                    el.textContent = opt;
                    el.value = i+1;/// la posicion y no el id de la base de datos
                    //el.style.backgroundImage = "url('folder/nakamura.jpg')"; 
                    select.appendChild(el);
                }
            }
            function addInput(val) {
                var input = document.createElement('input');
                input.setAttribute('name', 'QR Code URL');
                input.setAttribute('type', 'hidden');
                input.setAttribute('value', val);
                // Append this element to the form
                document.getElementById('dialog1').appendChild(input);  
            }
            function getArrayPrediccion(){
                return arrPrediccion;
            }
            function cancelForm(){
                return false;
            }
            function cambiarIdioma( elIdioma ){
                //alert(' por aki ');    
                if( elIdioma === 'ingles' ){
                    document.getElementById('idTextoPorFavorRegistrate').innerHTML= "Please register or login with your account";
                    document.getElementById('idLoginAnchor').innerHTML= "Login";
                    document.getElementById('idSingupAnchor').innerHTML= "Signup";
                } else if( elIdioma == 'espanol') {
                    document.getElementById('idTextoPorFavorRegistrate').innerHTML= "Por favor, regístrate o accede con tu cuenta";
                    document.getElementById('idLoginAnchor').innerHTML= "Acceder";
                    document.getElementById('idSingupAnchor').innerHTML= "Registrarse";
                }
            } 
        </script>
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
    <?php if(isset($_SESSION['id_usuario'])) { 
         $elQuery = "select count(1) as conteo from prediccion where id_usuario =".$_SESSION['id_usuario']['id'];
            $resPrediccion = mysqli_query($db,$elQuery);
            $resCount=mysqli_fetch_assoc($resPrediccion);
            if( $resCount['conteo'] == 0 ){ ?>
                <div>Logueado con éxito!</div> 
                <div class="bgimg" >Bienvenido 
                <span id="lg-correo"> <?= $_SESSION['id_usuario']['nombre'] ?> </span>
                
                <div style="text-align:right;"><a  href="logout.php" id="logout">Cerrar sesión</a></div>
                <?php if( $_GET['idReality'] == 1 ) { ?>
                    <h1>Haz tus  predicciones sobre la casa de los famosos colombia.</h1>
                <?php } else if( $_GET['idReality'] == 2 ) { ?>
                    <h1>Haz tus  predicciones sobre la casa de los famosos 4 telemundo.</h1>
                <?php } ?>    

            <?php
                $res2 = mysqli_query($db,"SELECT * FROM ranking where id_reality = ".$_GET['idReality']);
                //// se trato de hacer con el estado activo pero ese no me da el ranking en el q salieron de la competicion
                $resEliminados = mysqli_query($db,"SELECT id,nombre,descripcion FROM jugador where activo = 0 and id_reality = ".$_GET['idReality']);
                $arrayElim2 = array();
                if ($resEliminados) {
                    while ($rowEliminados = mysqli_fetch_row($resEliminados)) {
                        $arrayElim2[] = $rowEliminados;
                    }
                }
                //print_r($arrayElim2);
                //$queryResultArray2 = mysqli_fetch_array($res2);
                ?>
                <table width=50% border="1px" style="margin-left: auto;margin-right: auto;">
                <tr>
                    <th>Puesto</th>
                    <th>Famoso</th>
                    <th>Seleccionar</th>
                </tr>
                <?php
                /// esto tambien muestra el array en la pagina
                //error_log(" resultado ".print_r($res2));
                /*foreach($queryResultArray2 as $row)
                {
                    ?><tr>
                    <?= $row ?>
                    </tr><?php
                }*/
                if ($res2) {
                    ///// HAYYYYYYY que optimizar las iteraciones de esto porque con una es suficiente y se estan haciendo 20,
                    //// aunque como pasa del lado del servidor de pronto en realidad no hay problema
                    ///// me toco meter una variable global para saber que ya se borraron los elementos del arreglo
                    $borradosYa = false;
                    while ($row = mysqli_fetch_row($res2)) {
                       //print("Name: ".$row[0]."\n");
                       //print("Age: ".$row[1]."\n");
                       /// pendiente poner el nombre del jugador elegido debajo de la foto y usando rowspan 
                       //https://codepen.io/vilcu/pen/ZQwdGQ para hacer carrusel de imagenes
                       //// lo que tengo que tener en cuenta aki es resultado_evento para tener el id del jugador eliminado y en q
                       /// posicion quedo eliminado
                       ?><tr><td rowspan="2"><p style="font-size:40px">
                       <?= $row[1] ?></p></td>
                    
                       <?php if(estaEnEliminados($row[1],$arrayElim2,$db)) {?>
                       <td><img src="getImage.php?id=<?= getJugadorByRanking($row[1],$db)?>"; width="100px" height="100px"/></td>
                       <tr><td> <?= getNombreJugadorById(getJugadorByRanking($row[1],$db),$db) ?> </td></tr>
                       <?php } else { ?>
                       <td><img src="img/personaInterrogacion.jpg" width="100px" height="100px"/></td>
                       <?php }?>
                       <td rowspan="2">
                            <?php  $res3 = mysqli_query($db,"SELECT id,nombre,descripcion,activo FROM jugador where activo = 1 and id_reality = ".$_GET['idReality']);
                                    if ($res3) {
                                        $array = array();
                                        $arrayEliminados = array();
                                        while ($rowCopy = mysqli_fetch_row($res3)) {
                                            $array[] = $rowCopy;
                                        }
                                        $index = 0;
                                        foreach($array as $fila)
                                        {
                                           // print_r($fila);
                                           
                                           if($fila[3] == 0 && !$borradosYa){
                                             //$arrayEliminados.array_push($fila);
                                             error_log(' fila [3]'.$fila[3].' index '.$index);
                                             $array = borrarElementoArray($fila,$array);
                                           }     
                                           $index++;
                                        }
                                        $borradosYa = true;
                                        ?>
                                        <script type="text/javascript">
                                            arrFamosos = [1,2,3];//JSON.parse('<?= json_encode($array); ?>');
                                            arrFamosos = JSON.parse('<?= json_encode($array); ?>');
                                            arrSession = JSON.parse('<?= json_encode($_SESSION); ?>');
                                        </script>
                                        <?php if(!estaEnEliminados($row[1],$arrayElim2,$db)) { ?>
                                        <button class="modal__button" id="<?= "open-modal".$row[1]?>" onclick=mostrarModal(<?= $row[1] ?>)>
                                                Seleccionar
                                            </button>
                                        <?php } ?>
                                          <!-- <button type="button" onclick=mostrarModal() >Click Me!</button> -->
                                         <?php
                                    }
                            ?>
                       </td>
                       </tr><tr><td id="<?= "labelJugador".$row[1]?>"></td></tr>                      
                       <?php
                    } ?>
                    <!-- toca hacer una emergente aca para confirmar antes de guardar y decirle q despues de aceptar no se puede
                    modificar, bueno para mi al menos en esta version -->
                <!-- DIALOGOOOOOOOOOOOOOOOOOOOOOOOOO GUARDARRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRR-->
                <tr><td></td><td><button style="width:200px;height:50px"onclick="mostrarModalGuardar()">Guardar</button><td></td></tr>
                <tr><td>&nbsp;</td></tr>
                <tr><td>&nbsp;</td></tr>
                </table>
                <?php
                    }
                } else {
                    //redirect('mostrarPrediccion.php');  
                    error_log(' get id_reality '.$_GET['idReality']); 
                    $_SESSION['id_reality'] = $_GET['idReality'];
                    require_once 'mostrarPredTabla.php';
                }
             
            
                
            ?>
           
                      
                <dialog id="dialogGuardar">
                    <div>
                        <table width="350px" height ="50px">
                                <tr><td colspan="4"><p>Esta seguro de la prediccion? luego no se puede modificar </p></td></tr> 
                                <tr><td colspan="2">
                                    <form action="guardarPronostico2.php" method="post">
                                            <input type="hidden" id="id_usuario" name="id_usuario" value=<?= $_SESSION['id_usuario']['id']?> >
                                            <input type="hidden" id="idPrediccion" name="arr_prediccion" value="getArrayPrediccion()" >
                                            <input type="hidden" id="id_ranking" name="id_ranking" value="1" >
                                            <input type="hidden" id="idReality" name="idReality" value="<?= $_GET['idReality']?>" >
                                            <input type="submit" value="Guardar" />
                                            <button type="Cancelar" onclick="window.location='https://prediccionescasa.000webhostapp.com';return false;">Cancel</button>
                                            
                                    </form>
                                </tr>
                        </table>
                    </div>
                </dialog>
                    

            <!-- DIALOGOOOOOOOOOOOOOOOOOOOOOOOOOOO por aki-->
            <dialog id="dialog1">
                <div id="divDialog" width="300px">
                        <table width="300px" height ="50px">
                            <tr><td colspan="4"><p>Por favor, escoja el famoso para la posicion del ranking elegida </p></td></tr> 
                            <tr>
                            <td colspan="2"><img id= "imgDialogo" width="100px" height="100px"/></td>    
                            <td colspan="2">
                                <select name="selectFamosoDialogo" onchange=jsChangeArrayFamosos(this.value)>
                                    <option>...</option>
                                </select>

                            </td></tr> 
                            <tr><td></td><td>
                            <script type="text/javascript">
                                 var constAsignar = "asignar"; </script>
                                    <button onclick=cerrarModal(constAsignar)>Aceptar</button>
                                </td>    
                               <td> <button onclick=cerrarModal()>Cancelar</button></td>
                            <td></td></tr> 
                        </table>
                    <div>
                 
            </dialog>
            <p style="margin-bottom:3cm;"></p>
        </div>
    <?php } else { ?>
    <div class="bgimg">
    <div style="text-align:right;">
            <a href="javascript:cambiarIdioma('ingles')" id="cambiarIngles">English</a>
            <a href="javascript:cambiarIdioma('espanol')" id="cambiarEspañol">Español</a>
            </div>
    <h1 id="idTextoPorFavorRegistrate" >Por favor, regístrate o accede con tu cuenta</h1>

    <div id="enlaces">
        <a id="idLoginAnchor" href="login.php">Login</a>
        <a id="idSingupAnchor" href="singup.php">Registrarse</a>
    </div>
    </div>
   
    <!-- fin seccion popup -->
    <?php }  
    ///// FUNCIONES PHP
       function redirect($url) {
            header_remove();
            header('Location: '.$url);
            die();
        }
        function estaEnEliminados($id,$arr,$db ) {
            //// esta pasando la posicion dentro de la tabla grande osea el ranking
            ///// lo q tengo q pasar ....
           // require __DIR__ . '/getRankingJugador.php';
           //$id_jugador = include 'getRankingJugador.php?id_jugador=28';
           $id_jugador = getRankingJugador3($id,$db);
           error_log(' encontrado eliminado '.$id_jugador);
           if( $id_jugador){
            error_log(' retornando true ');
            return true;
           } else {
            error_log(' retornando false ');
            return false; 
           }
        }
        function borrarElementoArray($fila,$arr){
            error_log(' search array '.array_search($fila, $arr));
            if(($key = array_search($fila, $arr)) !== false) {
                unset($arr[$key]);
            }
            //error_log(' array recortado '.($arr.length));
            return $arr;
        }
        ///// se trato de hacer esta funcion a parte en otro archivo pero dio un poco de errores
        function getRankingJugador3($id_ranking,$db){
            //// voy a poner estado activo = 0 haber si se arregla lo de q este mostrando los eliminados del reality de colombia
            error_log(' id_ranking en getranking 3 :: '.$id_ranking);
            $sql = "SELECT id_jugador FROM resultado_evento, jugador j WHERE id_ranking =$id_ranking and j.id_reality = ".$_GET['idReality']." 
            and activo = 0 and id_jugador = j.id";
            $result = mysqli_query($db,$sql);
            $resRank=mysqli_fetch_assoc($result);
            if($resRank){
                return $resRank['id_jugador'];
            }
        }
        function getJugadorByRanking($id_ranking,$db){
            error_log(' id_ranking en getranking '.$id_ranking);
            $sql = "SELECT id_jugador FROM resultado_evento, jugador j WHERE id_ranking =$id_ranking and j.id_reality = ".$_GET['idReality']." 
            and activo = 0 and id_jugador = j.id";
            $result = mysqli_query($db,$sql);
            $resRank=mysqli_fetch_assoc($result);
            if($resRank){
                return $resRank['id_jugador'];
            }
        }
        function getNombreJugadorById($id_jugador,$db){
            $sql = "SELECT nombre FROM jugador j WHERE id = ".$id_jugador;
            $result = mysqli_query($db,$sql);
            $resRank=mysqli_fetch_assoc($result);
            if($resRank){
                return $resRank['nombre'];
            }
        }
    ?>
    <?php require_once 'includes/footer.php' ?>