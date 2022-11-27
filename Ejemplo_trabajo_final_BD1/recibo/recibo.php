<?php
include "../includes/header.php";
?>

<!-- TÍTULO. Cambiarlo, pero dejar especificada la analogía -->
<h1 class="mt-3">Entidad análoga a PELÍCULA (Recibo) </h1>
<hr>
<h4>Anotaciones</h4>
<ul>
    <li>Los costos de los subrecibos deben sumar el total del padre.</li>
    <li>La fecha de pago de los subrecibos no deben sobrepasar la fecha de pago del padre.</li>
    <li>Un subrecibos no puede tener subrecibos.</li>
</ul>

<!-- FORMULARIO. Cambiar los campos de acuerdo a su trabajo -->
<div class="formulario p-4 m-3 border rounded-3">

    <form action="recibo_insert.php" method="post" class="form-group">

        <div class="mb-3">
            <label for="codigo" class="form-label">Código</label>
            <input type="number" class="form-control" id="codigo" name="codigo" required>
        </div>

        <div class="mb-3">
            <label for="costo" class="form-label">Costo</label>
            <input type="number" class="form-control" id="costo" name="costo" required>
        </div>

        <div class="mb-3">
            <label for="fecha_pago_oportuno" class="form-label">Fecha</label>
            <input type="date" class="form-control" id="fecha_pago_oportuno" name="fecha_pago_oportuno" required>
        </div>

        <div class="mb-3">
            <label for="estado" class="form-label">Estado</label>
            <input type="text" class="form-control" id="estado" name="estado" required>
        </div>

       <!-- <div class="mb-3">
            <label for="subrecibo_de" class="form-label">Subrecibo</label>
            <input type="number" class="form-control" id="subrecibo_de" name="subrecibo_de">
        </div>-->
        <div class="mb-3">
            <label for="subrecibo_de" class="form-label">Subrecibo De</label>
            <select name="subrecibo_de" id="subrecibo_de" class="form-select">
                
                <!-- Option por defecto -->
                <option value="" selected disabled hidden></option>

                <?php
                // Importar el código del otro archivo
                require("recibo_select.php");
                
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
        <button type="submit" class="btn btn-primary">Agregar</button>

    </form>
    
</div>

<?php
// Importar el código del otro archivo
require("recibo_select.php");

// Verificar si llegan datos
if($resultadoRecibo and $resultadoRecibo->num_rows > 0):
?>

<!-- MOSTRAR LA TABLA. Cambiar las cabeceras -->
<div class="tabla mt-5 mx-3 rounded-3 overflow-hidden">

    <table class="table table-striped table-bordered">

        <!-- Títulos de la tabla, cambiarlos -->
        <thead class="table-dark">
            <tr>
                <th scope="col" class="text-center">Código</th>
                <th scope="col" class="text-center">Costo</th>
                <th scope="col" class="text-center">Fecha</th>
                <th scope="col" class="text-center">Estado</th>
                <th scope="col" class="text-center">Subrecibo de</th>
            </tr>
        </thead>

        <tbody>

            <?php
            // Iterar sobre los registros que llegaron
            foreach ($resultadoRecibo as $fila):
            ?>

            <!-- Fila que se generará -->
            <tr>
                <!-- Cada una de las columnas, con su valor correspondiente -->
                <td class="text-center"><?= $fila["codigo"]; ?></td>
                <td class="text-center"><?= $fila["costo"]; ?></td>
                <td class="text-center"><?= $fila["fecha_pago_oportuno"]; ?></td>
                <td class="text-center"><?= $fila["estado"]; ?></td>
                <td class="text-center"><?= $fila["subrecibo_de"]; ?></td>
                
                <!-- Botón de eliminar. Debe de incluir la CP de la entidad para identificarla -->
                <td class="text-center">
                    <form action="recibo_delete.php" method="post">
                        <input hidden type="number" name="codigoEliminar" value="<?= $fila["codigo"]; ?>">
                        <button type="submit" class="btn btn-danger">Eliminar</button>
                    </form>
                </td>

            </tr>

            <?php
            // Cerrar los estructuras de control
            endforeach;
            ?>

        </tbody>

    </table>
</div>

<?php
endif;

include "../includes/footer.php";
?>