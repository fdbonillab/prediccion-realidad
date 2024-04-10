<?php

require_once 'includes/conexion.php';

$mensaje = "";
$registroExitoso = false;

if(!empty($_POST['email']) && !empty($_POST['password'])){
    $nombre = $_POST['nombre'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Cifrado de contraseña por cuatro pasos
    $password_segura = password_hash($password, PASSWORD_BCRYPT, ['cost'=>4]);

    // Creamos la consulta del nuevo usuario
    $sql = "INSERT INTO usuario (id,nombre,correo,contraseña ) VALUES(null, '$nombre', '$email', '$password_segura')";

    // Guardamos a ese nuevo usuario en la base de datos
    $guardar = mysqli_query($db, $sql);

    // Si la consulta ha tenido éxito mostramos el mensaje, en caso contrario se muestra el error
    if($guardar){
        $mensaje = "Registrado con éxito";
        $registroExitoso = true;
    }else{
        $mensaje = "Ha ocurrido un error al registrarse";
    }
}

?>

<!DOCTYPE html>
<html>
<style>
body {font-family: Arial, Helvetica, sans-serif;}
* {box-sizing: border-box;}

/* Full-width input fields */
input[type=text], input[type=password] {
  width: 100%;
  padding: 15px;
  margin: 5px 0 22px 0;
  display: inline-block;
  border: none;
  background: #f1f1f1;
}

/* Add a background color when the inputs get focus */
input[type=text]:focus, input[type=password]:focus {
  background-color: #ddd;
  outline: none;
}

/* Set a style for all buttons */
button {
  background-color: #04AA6D;
  color: white;
  padding: 14px 20px;
  margin: 8px 0;
  border: none;
  cursor: pointer;
  width: 100%;
  opacity: 0.9;
}

button:hover {
  opacity:1;
}

/* Extra styles for the cancel button */
.cancelbtn {
  padding: 14px 20px;
  background-color: #f44336;
}

/* Float cancel and signup buttons and add an equal width */
.cancelbtn, .signupbtn {
  float: left;
  width: 50%;
}

/* Add padding to container elements */
.container {
  padding: 16px;
}

/* The Modal (background) */
.modal {
  display: none; /* Hidden by default */
  position: fixed; /* Stay in place */
  z-index: 1; /* Sit on top */
  left: 0;
  top: 0;
  width: 100%; /* Full width */
  height: 100%; /* Full height */
  overflow: auto; /* Enable scroll if needed */
  background-color: #474e5d;
  padding-top: 50px;
}

/* Modal Content/Box */
.modal-content {
  background-color: #fefefe;
  margin: 5% auto 15% auto; /* 5% from the top, 15% from the bottom and centered */
  border: 1px solid #888;
  width: 80%; /* Could be more or less, depending on screen size */
}

/* Style the horizontal ruler */
hr {
  border: 1px solid #f1f1f1;
  margin-bottom: 25px;
}
 
/* The Close Button (x) */
.close {
  position: absolute;
  right: 35px;
  top: 15px;
  font-size: 40px;
  font-weight: bold;
  color: #f1f1f1;
}

.close:hover,
.close:focus {
  color: #f44336;
  cursor: pointer;
}

/* Clear floats */
.clearfix::after {
  content: "";
  clear: both;
  display: table;
}

/* Change styles for cancel button and signup button on extra small screens */
@media screen and (max-width: 300px) {
  .cancelbtn, .signupbtn {
     width: 100%;
  }
}
.bgimg {
    background-image: url('img/casaFamososNeutro.jpg');
    color: white;
}
a:link, a:visited {
    color: white;
    size: 20px;
    padding: 15px 25px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
}
</style>
<script type="text/javascript">
        function cambiarIdioma( elIdioma ){
                        //alert(' por aki ');    
                        if( elIdioma === 'ingles' ){
                          ////// para INGLESSSS
                           if( document.getElementById('idPorfavorRellene') ){
                            document.getElementById('idPorfavorRellene').innerHTML= "Please fill this form to create an account.";
                            document.getElementById('idRegistrar').innerHTML= "signup";
                            document.getElementById('labelName').innerHTML= "name";
                            document.getElementById('labelEmail').innerHTML= "email";
                            document.getElementById('labelPassword').innerHTML= "password";
                            document.getElementById('labelRepPass').innerHTML= "repeat password";
                            document.getElementById('idPoliticaPrivacidad').innerHTML= "By creating the account you agree to our privacy policy";
                            document.getElementById('labelRepPass').innerHTML= "repeat password";
                           } else {
                            document.getElementById('idAcceder').innerHTML= "Access";
                            document.getElementById('s-exito').innerHTML= "Succeful registration";
                           }
                           

                            
                           //By creating the account you agree to our privacy policy
                           
                            //document.getElementById('idSingupAnchor').innerHTML= "Signup";
                        } else if( elIdioma == 'espanol') {
                          ////// para ESPAÑOOOOOL
                          if( document.getElementById('idPorfavorRellene') ){
                            document.getElementById('idPorfavorRellene').innerHTML= "Por favor llene este formulario para crear una cuenta.";
                            document.getElementById('idRegistrar').innerHTML= "Registrar";
                            document.getElementById('labelName').innerHTML= "nombre";
                            document.getElementById('labelEmail').innerHTML= "correo";
                            document.getElementById('labelPassword').innerHTML= "password";
                            document.getElementById('labelRepPass').innerHTML= "repetir password";
                            document.getElementById('idPoliticaPrivacidad').innerHTML= "Al crear la cuenta esta de acuerdo con nuestra politica de privacidad";
                           } else {
                            document.getElementById('idAcceder').innerHTML= "Acceder";
                            document.getElementById('s-exito').innerHTML= "Registrado con éxito";
                           } 
                           
                        }
          } 
  </script>
<body>
<div class="bgimg">
          <div style="text-align:right;">
            <a href="javascript:cambiarIdioma('ingles')" id="cambiarIngles">English</a>
            <a href="javascript:cambiarIdioma('espanol')" id="cambiarEspañol">Español</a>
            </div>
    <!-- Mostramos el mensaje creado anteriormente en caso de éxito o error -->
    <?php if(!empty($mensaje)) : ?>
        <p id="s-exito" style="font-size:40px"> <?= $mensaje ?> </p> <!-- Necesario usar la forma de <.?.= para mostrar el contenido de una variable -->
    <?php endif; ?>

    <div  style="text-align: center;">
    <?php if(!$registroExitoso){?>
    <h1 id="idRegistrar">Registrar</h1>
    <?php } else {?>
    <span><h1><a id="idAcceder" href="login.php">Acceder</a></h1></span>
    <?php } ?>
    </div>
    <!-- se cacharreo una forma de ver el boton de aceptar/entrar mas centrado pero se empeora todo cuando la ventana 
    es pequeña como de un movil, los campos de texto no se ven para poder digitar el nombre, el correo, el texto en general
        -->
        <?php if(!$registroExitoso){?>       
            <div>
            <form class="modal-content"  action="singup.php" method="POST">
                <div class="container bgimg">
                  <p id="idPorfavorRellene" >Por favor llene este formulario para crear una cuenta.</p>
                  <hr>

                  <label id="labelName"for="name"><b>nombre</b></label>
                  <input type="text" placeholder="Enter name" name="nombre" required>
                  
                  <label id="labelEmail" for="email"><b>Email</b></label>
                  <input type="text" placeholder="Enter Email" name="email" required>

                  <label id="labelPassword" for="psw"><b>Password</b></label>
                  <input type="password" placeholder="Ingrese Password" name="password" required>

                  <label id="labelRepPass" for="psw-repeat"><b>Repeat Password</b></label>
                  <input type="password" placeholder="Repetir Password" name="psw-repeat" required>
                  
                  <p id="idPoliticaPrivacidad">Al crear la cuenta esta de acuerdo con nuestra politica de privacidad <a href="politicaPrivacidad.php" style="color:dodgerblue">Politica de privacidad</a></p>

                  <div class="clearfix">
                    <button id="buttonAceptar" type="submit" class="signupbtn">Aceptar</button>
                  </div>
                </div>
              </form>
            </div>
<?php } ?>

<script>
// Get the modal
var modal = document.getElementById('id01');

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
  if (event.target == modal) {
    modal.style.display = "none";
  }
}
</script>
<?php require_once 'includes/footer.php' ?>
</body>
</html>
