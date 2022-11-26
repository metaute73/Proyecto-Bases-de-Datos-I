<?php
 
// Crear conexión con la BD
require('../config/conexion.php');

// Sacar la CP de la entidad
$reciboEliminar = $_POST["reciboEliminar"];
$bancoEliminar = $_POST["bancoEliminar"];

// Query SQL a la BD
$query = "DELETE FROM Listado_de_pago WHERE (recibo = '$reciboEliminar' AND banco = '$bancoEliminar')";

// Ejecutar consulta
$result = mysqli_query($conn, $query) or die(mysqli_error($conn));

if($result): 
    // Si fue exitosa, redirigirse de nuevo a la página de la entidad
    header ("Location: listadodepago.php");
else:
    echo "Ha ocurrido un error al eliminar este registro";
endif;
 
mysqli_close($conn);