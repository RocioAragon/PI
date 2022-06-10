<?php
//Declaracion datos de la Base de Datos
$servername = 'localhost';
$database = 'roaragonweb';
$username = 'root';
$password = '';

//Conexión base de datos
$conn = mysqli_connect($servername, $username, $password, $database);

//comprobar conexión correcta
if (!$conn) {
    die("Conexion fallida: " . mysqli_connect_error());
}//FinSi

?>