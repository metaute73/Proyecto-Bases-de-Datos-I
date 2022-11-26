<?php
 
// Crear conexión con la BD
require('../config/conexion.php');

// Sacar los datos del formulario. Cada input se identifica con su "name"
$fechapago = $_POST["fechapago"];
$recibo = $_POST["recibo"];
$banco = $_POST["banco"];

// Query SQL a la BD. Si tienen que hacer comprobaciones, hacerlas acá (Generar una query diferente para casos especiales)
$query = "INSERT INTO `Listado_de_pago`(`fecha_pago`, `recibo`, `banco`) VALUES ('$fechapago', '$recibo', '$banco')";

// Ejecutar consulta
$result = mysqli_query($conn, $query) or die(mysqli_error($conn));

// Redirigir al usuario a la misma pagina
if($result):
    // Si fue exitosa, redirigirse de nuevo a la página de la entidad
	header("Location: listadodepago.php");
else:
	echo "Ha ocurrido un error al crear el listado de pago";
endif;

mysqli_close($conn);