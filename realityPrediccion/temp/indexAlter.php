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
                $('dialog')[0].showModal();
            }
            /// en cerrarModal es donde se asignan las cosas en la tabla principal
            function cerrarModal( strAsignar ){
                if( strAsignar && strAsignar === "asignar" ){
                    ///indiceAux es el q lleva el indice de la tabla grande  para no tener q llevarlo y traerlo desde la emergente
                    cambiarImagenFamoso(indiceAux);
                }
                $('dialog')[0].close();
                reiniciarDialogo();
            }
            function cambiarImagenFamoso(indice){
                //// esto es lo q se cambia en la tabla grande
                $('img')[indice-1].src = "getImage.php?id="+arrElegido[0];////"img/nakamura.jpg";
                document.getElementById("labelJugador"+[indice]).innerText = arrElegido[1];
                console.log(" indice para cambiar imagen "+indice);
            }
            function cambiarLabelFamoso(indice){
                //$('img')[indice-1].src = "img/nakamura.jpg";
                document.getElementById("labelJugador"+[indice-1]).value = arrElegido[1];
                arrPredicion[indice] = arrElegido[0];
                console.log(" indice para cambiar imagen "+indice);
            }
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
        </script>

    <!-- Mensaje que se muestra en caso de que exista la sesión -->
    <?php if(isset($_SESSION['id_usuario'])) { ?>
        <div class="lg-exito">Bienvenido 
        <span id="lg-correo"> <?= $_SESSION['id_usuario']['nombre'] ?> </span>
        Logueado con éxito!
        <a href="logout.php" id="logout">Cerrar sesión</a>
        <h1>haz tus  predicciones perro. no se que mas texto poner aki</h1>
      
<!--
            <table>
                    <tr>
                        <th>Puesto</th>
                        <th>Jugador</th>
                    </tr>
                    <tr>
                        <td>1</td>
                        <td>jugador 1</td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>jugador 2</td>
                    </tr>
            </table> -->
            <?php
                $res2 = mysqli_query($db,"SELECT * FROM ranking");
                //$queryResultArray2 = mysqli_fetch_array($res2);
                ?>
                <table width=50% border="1px" >
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
                    while ($row = mysqli_fetch_row($res2)) {
                       //print("Name: ".$row[0]."\n");
                       //print("Age: ".$row[1]."\n");
                       /// pendiente poner el nombre del jugador elegido debajo de la foto y usando rowspan 
                       //https://codepen.io/vilcu/pen/ZQwdGQ para hacer carrusel de imagenes
                       ?><tr><td rowspan="2">
                       <?= $row[1] ?></td>
                       <td><img src="img/personaInterrogacion.jpg" width="100px" height="100px"/></td>
                       <td rowspan="2">
                            <?php  $res3 = mysqli_query($db,"SELECT id,nombre,descripcion,activo FROM jugador");
                                    if ($res3) {
                                        $array = array();
                                        while ($rowCopy = mysqli_fetch_row($res3)) {
                                            $array[] = $rowCopy;
                                        }?>
                                        <script type="text/javascript">
                                            arrFamosos = [1,2,3];//JSON.parse('<?= json_encode($array); ?>');
                                            arrFamosos = JSON.parse('<?= json_encode($array); ?>');
                                            arrSession = JSON.parse('<?= json_encode($_SESSION); ?>');
                                        </script>
                                        <button class="modal__button" id="open-modal" onclick=mostrarModal(<?= $row[1] ?>)>
                                                Seleccionar
                                            </button>
                                          <!-- <button type="button" onclick=mostrarModal() >Click Me!</button> -->
                                         <?php
                                    }
                            ?>
                       </td>
                       </tr><tr><td id="<?= "labelJugador".$row[1]?>"></td></tr>                      
                       <?php
                    }
                 }
                
                
            ?>
            <!-- toca hacer una emergente aca para confirmar antes de guardar y decirle q despues de aceptar no se puede
                modificar, bueno para mi al menos en esta version -->
            <tr><td></td><td><button onclick="guardarPronostico.php">Guardar</button><td></td><td></td></tr>
            </table>
                       
                       <form action="guardarPronostico2.php" method="post">
                            <input type="hidden" id="id_usuario" name="id_usuario" value=<?= $_SESSION['id_usuario']['id']?> >
                            <input type="hidden" id="idPrediccion" name="arr_prediccion" value=arrPrediccion >
                            <input type="hidden" id="id_ranking" name="id_ranking" value="1" >
                            <label for="POST-name">Nombre:</label>
                            <input id="POST-name" type="text" name="name" />
                            <input type="submit" value="Save" />
                      </form>
                      &nbsp;
                       &nbsp;
                       &nbsp;
                       &nbsp;
                       &nbsp;

            <!-- DIALOGOOOOOOOOOOOOOOOOOOOOOOOOOOO por aki-->
            <dialog id="dialog1">
                <div id="divDialog" width="300px">
                        <table width="300px" height ="50px">
                            <tr><td colspan="4"><p>Por favor perro escoja el famoso para la posicion del ranking elegida </p></td></tr> 
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
        </div>
    <?php } else { ?>

    <h1>Por favor, regístrate o accede con tu cuenta</h1>

    <div id="enlaces">
        <a href="login.php">Login</a>
        <a href="singup.php">Registrarse</a>
    </div>
    <!-- seccion para popup -->
    <div class="modal__container" id="modal-container">
                <div class="modal__content">
                    <div class="modal__close close-modal" title="Close">
                        <i class='bx bx-x'></i>
                    </div>

                    <img src="assets/img/star-trophy.png" alt="" class="modal__img">

                    <h1 class="modal__title">Good Job!</h1>
                    <p class="modal__description">Click the button to close</p>

                    <button class="modal__button modal__button-width">
                        View status
                    </button>

                    <button class="modal__button-link close-modal">
                        Close
                    </button>
                </div>
    </div>
   
    <!-- fin seccion popup -->
    <?php }  ?>
    <?php require_once 'includes/footer.php' ?>