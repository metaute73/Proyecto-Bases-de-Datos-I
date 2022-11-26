<?php
 
// Crear conexión con la BD
require('../config/conexion.php');

// Sacar los datos del formulario. Cada input se identifica con su "name"
$codigo = $_POST["codigo"];
$costo = $_POST["costo"];
$fecha = $_POST["fecha_pago_oportuno"];
$estado = $_POST["estado"];
$subrecibo = $_POST["subrecibo_de"];
// Query SQL a la BD. Si tienen que hacer comprobaciones, hacerlas acá (Generar una query diferente para casos especiales)
if ($subrecibo == ''):
    $query = "INSERT INTO `recibo`(`codigo`,`costo`, `fecha_pago_oportuno`,`estado`,`subrecibo_de` ) VALUES ('$codigo', '$costo', '$fecha', '$estado', null)";
else:
    $query = "INSERT INTO `recibo`(`codigo`,`costo`, `fecha_pago_oportuno`,`estado`,`subrecibo_de` ) VALUES ('$codigo', '$costo', '$fecha', '$estado', '$subrecibo')";
endif;
// Ejecutar consulta
$result = mysqli_query($conn, $query) or die(mysqli_error($conn));

// Redirigir al usuario a la misma pagina
if($result):
    // Si fue exitosa, redirigirse de nuevo a la página de la entidad
	header("Location: recibo.php");
else:
	echo "Ha ocurrido un error al crear la persona";
endif;

mysqli_close($conn);