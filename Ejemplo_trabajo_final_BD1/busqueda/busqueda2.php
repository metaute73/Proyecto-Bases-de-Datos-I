<?php
include "../includes/header.php";
?>

<!-- TÍTULO. Cambiarlo, pero dejar especificada la analogía -->
<h1 class="mt-3">Búsqueda 2</h1>

<p class="mt-3">
    Dos números enteros n1 y n2, n1 ≥ 0, n2 > n1. Se debe mostrar el nit y el 
    nombre de todas las empresas que han revisado entre n1 y n2 proyectos
    (intervalo cerrado [n1, n2]).
</p>

<!-- FORMULARIO. Cambiar los campos de acuerdo a su trabajo -->
<div class="formulario p-4 m-3 border rounded-3">

    <!-- En esta caso, el Action va a esta mismo archivo -->
    <form action="busqueda2.php" method="post" class="form-group">
        <div class="mb-3">
            <label for="recibo" class="form-label">Recibo</label>
            <select name="recibo" id="recibo" class="form-select">
                
                <!-- Option por defecto -->
                <option value="" selected disabled hidden></option>

                <?php
                // Importar el código del otro archivo
                require("../recibo/recibo_select.php");
                
                // Verificar si llegan datos
                if($resultadoRecibo):
                    
                    // Iterar sobre los registros que llegaron
                    foreach ($resultadoRecibo as $fila):
                ?>

                <!-- Opción que se genera -->
                <option value="<?= $fila["codigo"]; ?>"> codigo de recibo padre: <?= $fila["codigo"]; ?></option>

                <?php
                        // Cerrar los estructuras de control
                    endforeach;
                endif;
                ?>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Buscar</button>

    </form>
    
</div>

<?php
// Dado que el action apunta a este mismo archivo, hay que hacer eata verificación antes
if ($_SERVER['REQUEST_METHOD'] === 'POST'):

    // Crear conexión con la BD
    require('../config/conexion.php');

    $recibo = $_POST["recibo"];

    // Query SQL a la BD -> Crearla acá (No está completada, cambiarla a su contexto y a su analogía)
    
    $query2 = "SELECT R.subrecibo_de AS recibo,R.codigo as subrecibos, 
    RA.costo, RA.fecha_pago_oportuno, RA.estado 
    FROM recibo R INNER JOIN (recibo RA) ON R.subrecibo_de = RA.codigo 
    WHERE R.subrecibo_de = '$recibo'";

    $resultado2 = mysqli_query($conn, $query2) or die(mysqli_error($conn));

    mysqli_close($conn);

    if($resultado2 and $resultado2->num_rows > 0):
?>

<!-- MOSTRAR LA TABLA. Cambiar las cabeceras -->
<div class="tabla mt-5 mx-3 rounded-3 overflow-hidden">

    <table class="table table-striped table-bordered">

        <!-- Títulos de la tabla, cambiarlos -->
        <thead class="table-dark">
            <tr>
                <th scope="col" class="text-center">Recibo</th>
                <th scope="col" class="text-center">Subrecibos</th>
                <th scope="col" class="text-center">Costo</th>
                <th scope="col" class="text-center">Fecha</th>
                <th scope="col" class="text-center">Estado</th>
            </tr>
        </thead>

        <tbody>

            <?php
            // Iterar sobre los registros que llegaron
            foreach ($resultado2 as $fila):
            ?>

            <!-- Fila que se generará -->
            <tr>
                <!-- Cada una de las columnas, con su valor correspondiente -->
                <td class="text-center"><?= $fila["recibo"]; ?></td>
                <td class="text-center"><?= $fila["subrecibos"]; ?></td>
                <td class="text-center"><?= $fila["costo"]; ?></td>
                <td class="text-center"><?= $fila["fecha_pago_oportuno"]; ?></td>
                <td class="text-center"><?= $fila["estado"]; ?></td>
            </tr>

            <?php
            // Cerrar los estructuras de control
            endforeach;
            ?>

        </tbody>

    </table>
</div>

<!-- Mensaje de error si no hay resultados -->
<?php
else:
?>

<div class="alert alert-danger text-center mt-5">
    No se encontraron resultados para esta consulta
</div>

<?php
    endif;
endif;

include "../includes/footer.php";
?>