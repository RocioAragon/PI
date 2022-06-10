<!DOCTYPE html>
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

        <?php
        include "../../BBDD/conexion.php";

        if (mysqli_connect_errno()) {
            echo 'Failed connection' . mysqli_connect_error(); //Fallo en conexión
            exit();
        } else {
            $dni = $_POST['dni'];
            $nombre = $_POST['nombre'];
            $apellidos = $_POST['apellidos'];
            $contrasenia = $_POST['contraseña'];



            // Instrucción SQL de inserción
            $sql = "INSERT INTO usuarios (dni,nombre,apellidos,activado,administrador,contrasenia) 
        VALUES ('$dni','$nombre','$apellidos',0 ,0, '$contrasenia')";

            // Inserción y validación 
            if (
                strlen($nombre) <= 50 && strlen($apellidos) <= 100 && $nombre != '' && $apellidos != '' &&
                $contrasenia != '' && preg_match('/^[0-9]{8}[A-Z]{1}$/', $dni) == 1 && $conn->query($sql) === TRUE
            ) {
                echo "<div class='text-center'>";
                echo "<br><br><h2>Te has registrado con éxito.</h2><br><br><div class='form-check'>
                    <p>Un administrador deberá activar tu cuenta después del registro. Por favor, sea paciente.</p>
                    </div>
                    <br>
                    <br>
                    <br>";
                echo "<form action='../../index.php'><input type='submit' class=\"btn btn-dark\" value='Volver a la página principal'/></form>";
                echo "<br>";
                echo "</div>";
            } else {
                // Zona de errores
                echo ("<br><br><br></br>");
                echo ("<h3>Error. No se ha podido realizar la operación debido a: </h3></br></br>");
                if (strlen($nombre) > 50) {
                    echo ("<li>El nombre ha excedido el límite de caracteres (50).</li>");
                }
                if (strlen($apellidos) > 100) {
                    echo ("<li>El campo de apellidos ha excedido el límite de caracteres (100).</li>");
                }
                if ($nombre == '' || $apellidos == '' || $contrasenia == '') {
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
                echo "<br>";

                ////////////// Debug de errores de la base de datos //////////////
                // 
                // Mantener comentado para la experiencia de usuario 
                // echo mysqli_errno($conn) . ": " . mysqli_error($conn). "\n";
                //
                //////////////////////////////////////////////////////////////////
                echo ("<div class='text-center'>");
                echo ("<a onclick='javascript:history.go(-1)'><button class=\"btn btn-dark\">Volver atrás</button></a>");
                echo ("</div>");
                echo ("<br>");
                echo ("<br>");
                echo ("<br>");
            }
            $conn->close();
        }
        ?>

        </br>
        </br>
        </br>
        </br>
        </br>
    </div>
    <footer class="row bg-dark row justify-content-center align-items-center py-4">
        <br>
        <div class="col-lg-4 ">
            <p class="display-8 text-light text-muted"> REDES SOCIALES</p>
            <div class="row">
                <i class="fa fa-instagram text-light text-muted ">&nbsp;&nbsp;Instagram</i>
                <br>
                <i class="fa fa-facebook text-light text-muted ">&nbsp;&nbsp;Facebook</i>
                <br>
                <i class="fa fa-twitter text-light text-muted "> &nbsp;&nbsp;Twitter</i>
            </div>
        </div>
        <div class="col-lg-4 ">
            <p class="titulo text-light text-muted "> CONTACTO </p>

            <p class="letra text-light text-muted "> clubcartuja@gmail.com</p>
            <p class="letra text-light text-muted ">600 00 00 00</p>
            <p class="letra text-light text-muted ">Sevilla, España</p>
        </div>
        <div class="col-lg-4 ">
            <p class="display-8 text-light text-muted "> PRIVACIDAD Y COOKIES</p>
            <p class="text-light text-muted ">Lorem ipsum dolor sit amet consectetur adipisicing elit. Amet blanditiis voluptatem reiciendis sint? Sint quibusdam ratione culpa.Ipsum sed nisi saepe.</p>

        </div>
    </footer>
</body>

</html>