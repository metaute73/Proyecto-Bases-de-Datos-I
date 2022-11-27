<?php
 
// Crear conexión con la BD
require('../config/conexion.php');

// Sacar los datos del formulario. Cada input se identifica con su "name"
$fechapago = $_POST["fechapago"];
$recibo = $_POST["recibo"];
$banco = $_POST["banco"];

// Query SQL a la BD. Si tienen que hacer comprobaciones, hacerlas acá (Generar una query diferente para casos especiales)
$query = "INSERT INTO `Listado_de_pago`(`fechaPagoReal`, `codigoRecibo`, `codigoBanco`) VALUES ('$fechapago', '$recibo', '$banco')";

$query2 = "UPDATE recibo
SET estado = 'Pagado'
WHERE codigo = $recibo";

// Ejecutar consulta
$result = mysqli_query($conn, $query) or die(mysqli_error($conn));

$result2 = mysqli_query($conn, $query2) or die(mysqli_error($conn));

// Redirigir al usuario a la misma pagina
if($result and $result2):
    // Si fue exitosa, redirigirse de nuevo a la página de la entidad
	header("Location: listadodepago.php");
else:
	echo "Ha ocurrido un error al crear el listado de pago";
endif;

mysqli_close($conn);