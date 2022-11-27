<?php
include "../includes/header.php";
?>

<!-- TÍTULO. Cambiarlo, pero dejar especificada la analogía -->
<h1 class="mt-3">Entidad análoga a PROYECTO (LISTADO DE PAGO)</h1>

<!-- FORMULARIO. Cambiar los campos de acuerdo a su trabajo -->
<div class="formulario p-4 m-3 border rounded-3">

    <form action="listadodepago_insert.php" method="post" class="form-group">

        <div class="mb-3">
            <label for="fechapago" class="form-label">Fecha de pago</label>
            <input type="date" class="form-control" id="fechapago" name="fechapago" required>
        </div>
        
        <!-- Consultar la lista de recibos y desplegarlos -->
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
                <option value="<?= $fila["codigo"]; ?>"> - codigoRecibo <?= $fila["codigo"]; ?></option>

                <?php
                        // Cerrar los estructuras de control
                    endforeach;
                endif;
                ?>
            </select>
        </div>

        <!-- Consultar la lista de bancos y desplegarlos -->
        <div class="mb-3">
            <label for="banco" class="form-label">Banco</label>
            <select name="banco" id="banco" class="form-select">
                
                <!-- Option por defecto -->
                <option value="" selected disabled hidden></option>

                <?php
                // Importar el código del otro archivo
                require("../banco/banco_select.php");
                
                // Verificar si llegan datos
                if($resultadoBanco):
                    
                    // Iterar sobre los registros que llegaron
                    foreach ($resultadoBanco as $fila):
                ?>

                <!-- Opción que se genera -->
                <option value="<?= $fila["codigo"]; ?>"><?= $fila["nombre"]; ?> - codigoBanco: <?= $fila["codigo"]; ?></option>

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
require("listadodepago_select.php");
            
// Verificar si llegan datos
if($resultadoListadoPago and $resultadoListadoPago->num_rows > 0):
?>

<!-- MOSTRAR LA TABLA. Cambiar las cabeceras -->
<div class="tabla mt-5 mx-3 rounded-3 overflow-hidden">

    <table class="table table-striped table-bordered">

        <!-- Títulos de la tabla, cambiarlos -->
        <thead class="table-dark">
            <tr>
                <th scope="col" class="text-center">Fecha de creación</th>
                <th scope="col" class="text-center">Recibo</th> 
                <th scope="col" class="text-center">Banco</th>
            </tr>
        </thead>

        <tbody>

            <?php
            // Iterar sobre los registros que llegaron
            foreach ($resultadoListadoPago as $fila):
            ?>

            <!-- Fila que se generará -->
            <tr>
                <!-- Cada una de las columnas, con su valor correspondiente --> 
                <td class="text-center"><?= $fila["fechapago"]; ?></td>
                <td class="text-center">codigoRecibo: <?= $fila["recibo"]; ?></td>
                <td class="text-center">codigoBanco: <?= $fila["banco"]; ?></td>
                
                <!-- Botón de eliminar. Debe de incluir la CP de la entidad para identificarla -->
                <td class="text-center">
                    <form action="listadodepago_delete.php" method="post">
                        <input hidden type="text" name="reciboEliminar" value="<?= $fila["recibo"]; ?>">
                        <input hidden type="text" name="bancoEliminar" value="<?= $fila["banco"]; ?>">
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