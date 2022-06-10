<?php
session_start();
	include "../../BBDD/conexion.php";

	if (mysqli_connect_errno()) {
		echo json_encode(array('success' => 0, 'message' => 'Failed connection'));
		exit();
	} else {
		// Captura de los datos
		$dni = $_SESSION['dni'];
		$productos = $_POST['productos'];
		$cantidades = $_POST['cantidades'];
		$precios = $_POST['precios'];
		
		//recogemos el ultimo numero_pedido
		$consulta = "SELECT numero_pedido FROM pedidos ORDER BY numero_pedido DESC LIMIT 1";
		if ($result = mysqli_query($conn, $consulta)) {
			$numero_pedido = 0;
			while ($row = mysqli_fetch_array($result)) {
				$numero_pedido = $row['numero_pedido'];
			}
		} else {
			echo json_encode(array('success' => 0, 'message' => 'Error al recuperar pedidos en BBDD'));
		}
		
		$numero_pedido++;
		
		foreach($productos as $indice => $producto){
			// Instrucción SQL de inserción
			$sql = "INSERT INTO pedidos (dni,numero_pedido,producto,cantidad,precio_ud) 
			VALUES ('$dni',$numero_pedido,'$producto',$cantidades[$indice],$precios[$indice])";

			// Inserción y validación
			if (!mysqli_query($conn, $sql)) {
				// Zona de errores
				$error = 'Error!' . mysqli_errno($conn) . ": " . mysqli_error($conn);
				echo json_encode(array('success' => 0, 'message' => $error));
			}
		}
		$conn->close();
		echo json_encode(array('success' => 1));
	}
?>