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
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <div class="container text-center">
            <h1>Editar usuario</h1>
            <?php
            include "../../BBDD/conexion.php";

            if (mysqli_connect_errno()) {
                echo 'Failed connection' . mysqli_connect_error(); //Fallo en conexión
                exit();
            } else {
                // Captura de los datos
                if (isset($_POST['activado'])) {
                    $activado = 1;
                } else {
                    $activado = 0;
                }
                $dni = $_POST['dni'];
                $nombre = $_POST['nombre'];
                $apellidos = $_POST['apellidos'];
                $contraseña = $_POST['contraseña'];
                if (isset($_POST['administrador'])) {
                    $administrador = 1;
                } else {
                    $administrador = 0;
                }
                $dniAntiguo = $_POST['dniAntiguo'];

                // Instrucción SQL de inserción
                $sql = "UPDATE usuarios set  dni='$dni', nombre='$nombre', apellidos='$apellidos',
        activado=$activado, administrador=$administrador, contrasenia='$contraseña'
        where dni='$dniAntiguo'";

                // Update y validación
                if (
                    strlen($nombre) <= 50 && strlen($apellidos) <= 100 && $nombre != '' && $apellidos != '' &&
                    $contraseña != '' && preg_match('/^[0-9]{8}[A-Z]{1}$/', $dni) == 1 && $conn->query($sql) === TRUE
                ) {
					echo "Usuario modificado con éxito.<br><br>";
					if($admin){
						echo ("<form action='administrarUsuarios.php'><input type='submit' class=\"btn btn-dark\" value='Volver al panel'/></form>");
					} else {
						echo ("<form action='interfazEditarUsuario.php'><input type='submit' class=\"btn btn-dark\" value='Volver'/></form>");
                    }
                    
                } else {
                    // Zona de errores
                    echo "Error. No se ha podido realizar la operación debido a: <br><br>";
                    if (strlen($nombre) > 50) {
                        echo ("<li>El nombre ha excedido el límite de caracteres (50).</li>");
                    }
                    if (strlen($apellidos) > 100) {
                        echo ("<li>El campo de apellidos ha excedido el límite de caracteres (100).</li>");
                    }
                    if ($nombre == '' || $apellidos == '' || $contraseña == '') {
                        echo ("<li>Todos los campos deben rellenarse.</li>");
                    }
                    if (!preg_match('/^[0-9]{8}[A-Z]{1}$/', $dni) == 1) {
                        echo ("<li>El formato del DNI debe ser 12345678A.</li>");
                    }
                    if (mysqli_errno($conn) == 1062) {
                        // Controla que no pueda meterse el mismo DNI
                        // mediante el error 1062 de clave primaria de la base de datos
                        echo ("<li>El DNI introducido ya existe en la base de datos</li>");
                    }
					
                    echo "<br>";

                    ////////////// Debug de errores de la base de datos //////////////
                    // 
                    // Mantener comentado para la experiencia de usuario 
                    // echo mysqli_errno($conn) . ": " . mysqli_error($conn). "\n";
                    //
                    //////////////////////////////////////////////////////////////////

                    echo ("<button onclick='javascript:history.go(-1)' class='btn btn-dark'>Volver atrás</button>");
                }
                $conn->close();
            }
            ?>
        </div>
     
</body>

</html>