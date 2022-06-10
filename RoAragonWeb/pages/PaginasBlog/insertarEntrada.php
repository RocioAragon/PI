<!doctype html>
<?php 
session_start(); 
if (isset($_POST["dni"]) && isset($_POST["pass"])) {
	include "../BBDD/conexion.php";
	if (mysqli_connect_errno()) {
		echo 'Failed connection' . mysqli_connect_error();
		exit();
	} else {
		$dni = $_POST["dni"];
		$contrasenia = $_POST["pass"];
		$consulta = "SELECT activado, nombre, administrador, dni FROM usuarios WHERE dni='$dni' AND contrasenia='$contrasenia'";
		if(mysqli_query($conn, $consulta)){
			$row = mysqli_fetch_array(mysqli_query($conn, $consulta));
			if ($row != null) {                            ////////////////////////////// LOGIN CORRECTO
				session_id();
				// Variables de sesión
				if($row['activado']==1){
					$_SESSION["sesion_iniciada"] = true;
					$_SESSION["nombre"] = $row['nombre'];
					$_SESSION["activado"] = $row['activado'];
					$_SESSION["administrador"] = $row['administrador'];
					$_SESSION["dni"] = $row['dni'];
				}else{
					$_SESSION["nombre"] = $row['nombre'];
					$_SESSION["activado"] = $row['activado'];
					$noActivadoError = true;
				}
				
			} else {                                     ////////////////////////////// LOGIN INCORRECTO
				$loginError = true;
			}
		} else {                                     ////////////////////////////// LOGIN INCORRECTO
			$loginError = true;
		}
	}
	mysqli_close($conn);
}

if (isset($_POST['cierre'])) {
	$_SESSION["sesion_iniciada"] = false;
	session_destroy();
	header("Refresh:0");
}

?>
<html lang="en">
<head>
    <title>Ro Aragón Web</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="stylesheet" href="../../style.css">
	 <!-- Bootstrap CSS v5.0.2 -->
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css"
		integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Varela+Round">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css"> 
	
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
	<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
	
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/jquery.validate.min.js"></script>
	
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
	
	<script src="scripts/login.js"></script>
    <!--JAVASCRIPT-->
    
    <script src="../scripts/usuarios.js"></script>
    <script src="../scripts/carrito.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
  <body>
      
    <!-- Bootstrap JavaScript Libraries -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
  
    <nav class="navbar navbar-expand-lg navbar-light bg-light py-3 fixed-top">
        <div class="container-fluid">
            <img src="../../img/RoAragon.png" alt="" width="199" height="89">
            <br>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                  <span class="navbar-toggler-icon bg-light"></span>
                </button>
            <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                <div class="navbar-nav">
                    <a class="nav-link " href="">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</a>
                    <a class="nav-link text-dark" aria-current="page" href="../index.php">Home</a>
                    <a class="nav-link text-dark" href="galeria.php">Galería</a>
                    <a class="nav-link text-dark" href="Tienda.php">Tienda</a>
                    <a class="nav-link text-dark" href="PaginasBlog/blog.php">Blog</a>
                    <a class="nav-link text-dark" href="sobremi.php">Sobre Mí</a>
                    <a class="nav-link text-dark" href="contacto.php">Contacto</a>
                    <a class="nav-link " href="">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</a>
                    <a class="nav-link " href="">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</a>
                    <a class="nav-link " href="">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</a>
                    <a class="nav-link " href="">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</a>
                    <div class="navbar-nav action-buttons ml-auto">
                        <?php 
                            if(isset($_SESSION['sesion_iniciada'])){
                                echo "<a href=\"#\" data-toggle=\"dropdown\" class=\"nav-item nav-link dropdown-toggle mr-10\"> <b> <i class=\"fa fa-user bigicon\"> &nbsp;Bienvenido ".$_SESSION["nombre"]."</b></i></a>";
                            }else{
                                echo "<a href=\"#\" data-toggle=\"dropdown\" class=\"nav-item nav-link dropdown-toggle mr-10\"> <b> <i class=\"fa fa-user bigicon\"> &nbsp;Login</b></i></a>";
                            }
                        ?>
                        <div class="dropdown-menu login-form">
                            <?php
                                $admin = false;
                                function pintaFormulario(){
                                    echo "<form action='#' method='post'>
                                        <div class='form-group'>
                                            <label>DNI de Usuario</label>
                                            <input type='text' class='form-control' id='dni' name='dni' required='required'>
                                        </div>
                                        <div class='form-group'>
                                            <div class='clearfix'>
                                                <label>Contraseña</label>
                                            </div>
                                            <input type='password' id='pass' name='pass' class='form-control' required='required'>
                                        </div>
                                        <input type='submit' class='btn btn-primary btn-block' value='Login'>
                                        <br>
                                        <a href='../PaginasUsuarios/interfazRegistro.php' class='float-right text-muted'> Registrarse </a>
                                        <br>
                                    </form>";
                                }
                    
                                if (isset($_SESSION['sesion_iniciada'])) {
                                    if ($_SESSION["administrador"] == 1) { ////////////////////////////// ADMIN
                                        $admin = true;
                                    }
                                    if ($admin) {
                                        echo "<div >
                                            <h5>Panel de administración</h5>
                                            <ul class='text-start'>
                                            <li><a href='../PaginasUsuarios/administrarUsuarios.php'>Gestión de usuarios</a></li>
                                            <li><a href='interfazAdministrarEntradas.php'>Entradas Blog</a></li>
                                            <li><a href='../PaginasPedidos/verPedidos.php'>Ver pedidos</a></li>
                                            <li><a href='../PaginasPedidos/controlPedidos.php'>Control de pedidos</a></li>
                                            </ul></div>";
                                    } else {
                                        echo "<div >
                                            <h5>Panel de Usuario</h5>
                                            <ul class='text-start'>
                                            <li><a href='../PaginasUsuarios/interfazEditarUsuario.php'>Editar usuario</a></li>
                                            <li><a href='../PaginasPedidos/verPedidos.php'>Compras realizadas</a></li>
                                            </ul></div>";
                                    }
                                    echo "<form action='#' method='post'>"."
                                    <input class=\"button\" type='submit' name='cierre' value='Cerrar Sesión' style='margin-left:10%;padding-bottom:15%'/>
                                    </form>";
                                    // Botón de cerrar sesión y acción
                                    if (isset($_POST['cierre'])) {
                                        $_SESSION["sesion_iniciada"] = false;
                                        session_destroy();
                                        header("Refresh:0");
                                    }
                                } else {
                                    pintaFormulario();
                                    if(isset($noActivadoError)){
                                        echo "<div class=\"alert alert-warning\" role=\"alert\">Lo sentimos " . $_SESSION["nombre"] . ", tu usuario no está activado</div>";
                                        $_SESSION["sesion_iniciada"] = false;
                                        session_destroy();
                                    }
                                    if(isset($loginError)){
                                        echo "<div class=\"alert alert-danger\" role=\"alert\">Error de usuario. Inténtelo de nuevo.</div>";
                                    }
                                }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>
  </br>
  </br>
  </br>
  </br>
  </br>
  </br>
  </br>

  <?php
 //error_reporting(0);
 include "../../BBDD/conexion.php";
 //$sql="USE clubcartuja";

 //Recogida de datos
 $titulo=$_POST['titulo'];
 $noticia=$_POST['noticia'];
 $foto=$_POST['foto'];

//Función para validar formulario.
 function validarFormulario($titulo, $noticia){
    //Entorno:
    $esValido=true;
    //Algortimo:
    echo "<ul>";

    //Comprobamos si el titulo está seteado o si es cadena vacía.
    if(!isset($titulo) || $titulo == "" ){
        $esValido=false;
        echo "<li  align=\"center\"> Se requiere un titulo para la noticia.</li>";
    }//FinSi

    //Comprobamos si la noticia está seteada o si es cadena vacía.
    if($noticia == "" ){
        $esValido=false;
        echo "<li  align=\"center\"> Se requiere un texto para la noticia.</li>";
    }//FinSi    

    echo "</ul>";

    return   $esValido;
}//FinFuncion

//Función para error en insercion.
function errorInsercion(){
    echo "<h3  align=\"center\"> No se ha podido realizar la inserción.</h3>";
}//FinFuncion  

 //Función para insertar.
 if(validarFormulario($titulo, $noticia)){
    $sql = "INSERT INTO entradas (titulo, contenido, foto) 
    VALUES ('$titulo', '$noticia', '$foto')";
}

//Comprobamos si la inserción ha ido bien o no.
if (mysqli_query($conn, $sql)) {
    echo "<br>";
    echo "<h3  align=\"center\"> Entrada insertada.</h3>";
} else {
    errorInsercion();
    //echo mysqli_errno($conn) . ": " . mysqli_error($conn). "\n";
}//FinSi

//Cerramos conexion
mysqli_close($conn); 
echo "<br>";
echo "<br>";
echo "<div class=\"text-center\">";
echo "<a href=\"interfazAdministrarEntradas.php\" style=\"color:white\"><button class='btn btn-dark'><p align=\"center\"> Volver al panel de Control</button></a>";
echo "</div>";
?>

</br>
  </br>
  </br>
  </br>
  </br>
  </br>
  </br>
  </br>
   <!--FOOTER-->
   <footer class="row bg-dark row justify-content-center align-items-center py-5  mt-auto" style="padding-left: 20px;">
        <br>
        <div class="col-lg-4 ">
            <p class="display-8 text-light text-muted "> REDES SOCIALES</p>
            <div class="row ">
                <i class="fa fa-instagram text-light text-muted ">&nbsp;&nbsp;Instagram</i>
                <br>
                <i class="fa fa-facebook text-light text-muted ">&nbsp;&nbsp;Facebook</i>
                <br>
                <i class="fa fa-twitter text-light text-muted "> &nbsp;&nbsp;Twitter</i>
            </div>
        </div>
        <div class="col-lg-4 ">
            <p class="titulo text-light text-muted "> CONTACTO </p>

            <p class="letra text-light text-muted "> roaragonfotografia@gmail.com</p>
            <p class="letra text-light text-muted ">600 00 00 00</p>
            <p class="letra text-light text-muted ">Sevilla, España</p>
        </div>
        <div class="col-lg-4 ">
            <p class="display-8 text-light text-muted "> PRIVACIDAD Y COOKIES</p>
            <p class="text-light text-muted ">Lorem ipsum dolor sit amet consectetur adipisicing elit. Amet blanditiis voluptatem reiciendis sint?.</p>
            <br>
        </div>
    </footer>

</body>
</html>