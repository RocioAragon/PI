<!DOCTYPE html>
<?php 
session_start(); 
if (isset($_POST["dni"]) && isset($_POST["pass"])) {
	include "../../BBDD/conexion.php";
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
<!--Rocío Aragón Escamilla
2 DAW-->
<head>
    <title>Ro Aragón Web Foto</title>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../style.css">
    <!-- Bootstrap CSS v5.0.2 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" 
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Varela+Round">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css"> 

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
	
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/jquery.validate.min.js"></script>
	
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
	
	<script src="scripts/login.js"></script>
</head>

<body>
    <div class="container">
        <!--MENÚ/BARRA DE NAVEGACIÓN-->
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
                    <a class="nav-link text-dark" aria-current="page" href="../../index.php">Home</a>
                    <a class="nav-link text-dark" href="../galeria.php">Galería</a>
                    <a class="nav-link text-dark" href="../Tienda.php">Tienda</a>
                    <a class="nav-link text-dark" href="../PaginasBlog/blog.php">Blog</a>
                    <a class="nav-link text-dark" href="../sobremi.php">Sobre Mí</a>
                    <a class="nav-link text-dark" href="../contacto.php">Contacto</a>
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
                                        <a href='interfazRegistro.php' class='float-right text-muted'> Registrarse </a>
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
                                            <li><a href='administrarUsuarios.php'>Gestión de usuarios</a></li>
                                            <li><a href='../PaginasBlog/interfazAdministrarEntradas.php'>Entradas Blog</a></li>
                                            <li><a href='../PaginasPedidos/verPedidos.php'>Ver pedidos</a></li>
                                            <li><a href='../PaginasPedidos/controlPedidos.php'>Control de pedidos</a></li>
                                            </ul></div>";
                                    } else {
                                        echo "<div >
                                            <h5>Panel de Usuario</h5>
                                            <ul class='text-start'>
                                            <li><a href='interfazEditarUsuario.php'>Editar usuario</a></li>
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

        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <div class="container">
        <h1 class="text-center">Registrar un nuevo usuario</h1>
        <?php
            if ($admin) {
                    echo '<br>';
                    echo "<p  class='text-center'>Introduzca los datos requeridos:</p>
                    <br>
                    <form  class='m-auto w-75' action='insertarUsuario.php' method='post'>
                           
                            <div class='form-group row'>
                                <label for='dni' class='col-sm-2 col-form-label'><b>DNI</b></label>
                                <div class='col-sm-10'>
                                    <input class='form-control' type='text' id='dni' name='dni' placeholder='00000000A' required>
                                </div>
                            </div>

                            <div class='form-group row'>
                                <label for='nombre' class='col-sm-2 col-form-label'><b>Nombre</b></label>
                                <div class='col-sm-10'>
                                    <input class='form-control' type='text' id='nombre' name='nombre' placeholder='' required>
                                </div>
                            </div>

                            <div class='form-group row'>
                                <label for='apellidos' class='col-sm-2 col-form-label'><b>Apellidos</b></label>
                                <div class='col-sm-10'>
                                    <input class='form-control' type='text' id='apellidos' name='apellidos' placeholder='' required>
                                </div>
                            </div>
                        

                            <div class='form-group row'>
                                <label for='contraseña' class='col-sm-2 col-form-label'><b>Contraseña</b></label>
                                <div class='col-sm-10'>
                                    <input class='form-control' type='text' id='contraseña' name='contraseña' placeholder=''>
                                </div>
                            </div>
                            
                        <div class='form-group row'>
                            <div class='col-sm-2'><b>Administrador  </b> </div>
                                <div class='col-sm-10'>
                                    <div class='form-check'>
                                        <input class='form-check-input' type='checkbox' id='administrador' name='administrador' checked>
                                        <label class='form-check-label' for='administrador'>
                                        Usuario Administrador
                                        </label>
                                 </div>
                                </div>
                        </div>


                        <div class='form-group row'>
                            <div class='col-sm-2'><b>Activación  </b> </div>
                                <div class='col-sm-10'>
                                    <div class='form-check'>
                                        <input class='form-check-input' type='checkbox' id='activado' name='activado' checked >
                                        <label class='form-check-label' for='activado'>
                                        Activar Usuario
                                        </label>
                                </div>
                            </div>
                        </div>

                        <br>

                        <div class='m-auto'>
                            <button class='btn btn-dark' type='submit' value='Registrar'>Registrar</button>
                        </div>
                    </form>
                <br>
                <br>
                <form class='m-auto w-25' action='administrarUsuarios.php'>
                    <input type='submit'class=\"btn btn-dark\" value='Volver al panel' />
                </form>";
            } else {
                echo "Acceso restringido";
            }

        ?>
        </div>
        </div>
        </div>
        </br>
        </br>
        </br>
        </br>
        </br>
    </div>
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