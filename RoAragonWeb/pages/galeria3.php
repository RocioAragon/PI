<!doctype php>
<php lang="en">
<!--Rocío Aragón Escamilla
2 DAW-->

<head>
    <title>Galería Retrato</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <script type="text/javascript" src="../scripts/LightBoxGalerias.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="stylesheet" href="../style.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap CSS v5.0.2 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="../scripts/usuarios.js"></script>
</head>
<!DOCTYPE php>
<php lang="en">

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light py-3 fixed-top">
        <div class="container-fluid">
            <img src="../img/RoAragon.png" alt="" width="199" height="89">
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
                                echo "<a id='nombre_sesion' href=\"#\" data-toggle=\"dropdown\" class=\"nav-item nav-link dropdown-toggle mr-10\"> <b> <i class=\"fa fa-user bigicon\"> &nbsp;Bienvenido ".$_SESSION["nombre"]."</b></i></a>";
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
                                        <a href='PaginasUsuarios/interfazRegistro.php' class='float-right text-muted'> Registrarse </a>
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
                                            <li><a href='PaginasUsuarios/administrarUsuarios.php'>Gestión de usuarios</a></li>
                                            <li><a href='PaginasBlog/interfazAdministrarEntradas.php'>Entradas Blog</a></li>
                                            <li><a href='PaginasPedidos/verPedidos.php'>Ver pedidos</a></li>
                                            <li><a href='PaginasPedidos/controlPedidos.php'>Control de pedidos</a></li>
                                            </ul></div>";
                                    } else {
                                        echo "<div >
                                            <h5>Panel de Usuario</h5>
                                            <ul class='text-start'>
                                            <li><a href='PaginasUsuarios/interfazEditarUsuario.php'>Editar usuario</a></li>
                                            <li><a href='PaginasPedidos/verPedidos.php'>Compras realizadas</a></li>
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
    <div class="tituloContact">
        <br>
        <br>
        <hr>
        <br>
    </div>
    <div class="m-auto w-75">
        <div class="">
            <!-- Imagenes para abrir la galería -->
            <div class="fila">
                <div class="row">
                    <div class="galUno col-sm-12 col-md-6 col-lg-3  align-items-center justify-content-center">
                        <img src="Retrato/1.jpeg" onclick="abrirContenido();fotoActual(1)" class="fotoGaleria">
                    </div>

                    <div class="galUno col-sm-12 col-md-6 col-lg-3  align-items-center justify-content-center">
                        <img src="Retrato/2.JPG" onclick="abrirContenido();fotoActual(2)" class="fotoGaleria">
                    </div>

                    <div class="galUno col-sm-12 col-md-6 col-lg-3 align-items-center justify-content-center">
                        <img src="Retrato/3.jpg" onclick="abrirContenido();fotoActual(3)" class="fotoGaleria">
                    </div>

                    <div class="galUno col-sm-12 col-md-6 col-lg-3 align-items-center justify-content-center">
                        <img src="Retrato/4.jpeg" onclick="abrirContenido();fotoActual(4)" class="fotoGaleria">
                    </div>

                    <div class="galUno col-sm-12 col-md-6 col-lg-3 align-items-center justify-content-center">
                        <img src="Retrato/5.png" onclick="abrirContenido();fotoActual(5)" class="fotoGaleria">
                    </div>

                    <div class="galUno col-sm-12 col-md-6 col-lg-3 align-items-center justify-content-center">
                        <img src="Retrato/6.jpeg" onclick="abrirContenido();fotoActual(6)" class="fotoGaleria">
                    </div>

                    <div class="galUno col-sm-12 col-md-6 col-lg-3 align-items-center justify-content-center">
                        <img src="Retrato/7.jpeg" onclick="abrirContenido();fotoActual(7)" class="fotoGaleria">
                    </div>

                    <div class="galUno col-sm-12 col-md-6 col-lg-3 align-items-center justify-content-center">
                        <img src="Retrato/8.jpg" onclick="abrirContenido();fotoActual(8)" class="fotoGaleria">
                    </div>
                </div>
            </div>
        </div>

        <div id="miContenido" class="contenido">
            <span class="cerrarCursor" onclick="cerrarContenido()">&times;</span>
            <div class="contenidoFotoVertical">

                <div class="misFotos">
                    <div class="numeroDeFoto">1 / 8</div>
                    <img class="imgJS" src="Retrato/1.jpeg">
                </div>

                <div class="misFotos">
                    <div class="numeroDeFoto">2 / 8</div>
                    <img class="imgJS" src="Retrato/2.JPG" />
                </div>

                <div class="misFotos">
                    <div class="numeroDeFoto">3 / 8</div>
                    <img class="imgJS" src="Retrato/3.jpg" />
                </div>

                <div class="misFotos">
                    <div class="numeroDeFoto">4 / 8</div>
                    <img class="imgJS" class="imgJS" src="Retrato/4.jpeg" />
                </div>

                <div class="misFotos ">
                    <div class="numeroDeFoto">5 / 8</div>
                    <img class="imgJS " src="Retrato/5.png" style="width:100% ">
                </div>

                <div class="misFotos ">
                    <div class="numeroDeFoto">6 / 8</div>
                    <img class="imgJS " src="Retrato/6.jpeg">
                </div>

                <div class="misFotos ">
                    <div class="numeroDeFoto">7 / 8</div>
                    <img class="imgJS " src="Retrato/7.jpeg">
                </div>

                <div class="misFotos ">
                    <div class="numeroDeFoto">8 / 8</div>
                    <img class="imgJS " src="Retrato/8.jpg">
                </div>

                <!-- Controles de siguiente/anterior -->
                <a class="anterior" onclick="masFotos(-1) ">&#10094;</a>
                <a class="siguiente" onclick="masFotos(1) ">&#10095;</a>


            </div>
        </div>
    </div>

    <br>
    <br>
    <br>
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

</php>