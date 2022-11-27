<?php
include "../includes/header.php";
?>

<!-- TÍTULO. Cambiarlo, pero dejar especificada la analogía -->
<h1 class="mt-3">Búsqueda 2</h1>

<p class="mt-3">
    Seleccione o ingrese el código de su recibo, y se mostrará la siguiente información: el
    código, costo, fecha de pago oportuno y si es subrecibo de otros o tiene subrecibos, en caso 
    de que no sea ningno de los casos pasados, se mostrará la información de el mismo y si no existe
    se mostrará el respectivo mensaje. 
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
                <option value="<?= $fila["codigo"]; ?>"> Código de recibo: <?= $fila["codigo"]; ?></option>

                <?php
                        // Cerrar los estructuras de control
                    endforeach;
                endif;
                ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="recibo2" class="form-label">Código de recibo - Manual</label>
            <input type="number" class="form-control" id="recibo2" name="recibo2" >
        </div>

        <button type="submit" class="btn btn-primary">Buscar</button>

    </form>
    
</div>

<?php
// Dado que el action apunta a este mismo archivo, hay que hacer eata verificación antes
if ($_SERVER['REQUEST_METHOD'] === 'POST'):

    // Crear conexión con la BD
    require('../config/conexion.php');


    $recibo="";

    if($_POST["recibo2"]==""):
        $recibo=$_POST["recibo"];
    else:
        $recibo = $_POST["recibo2"];
    endif;
    

    // Query SQL a la BD -> Crearla acá (No está completada, cambiarla a su contexto y a su analogía)
    $query = "SELECT subrecibo_de, codigo FROM recibo WHERE codigo = '$recibo'";
    $resultado = mysqli_query($conn, $query) or die(mysqli_error($conn));
    //mysqli_close($conn);

    if($resultado and $resultado->num_rows > 0):
        

        foreach ($resultado as $fila):
            
            if ($fila["subrecibo_de"] == ""):
            
                $query2 = "SELECT R.subrecibo_de AS recibo,R.codigo as subrecibos, 
                RA.costo, RA.fecha_pago_oportuno, RA.estado 
                FROM recibo R INNER JOIN (recibo RA) ON R.subrecibo_de = RA.codigo 
                WHERE R.subrecibo_de = '$recibo'";

                $resultado2 = mysqli_query($conn, $query2) or die(mysqli_error($conn));

                #mysqli_close($conn);

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

                elseif($fila["codigo"]>0):
                    
                    $query2 = "SELECT * FROM recibo WHERE codigo = '$recibo'";
                    $resultado2 = mysqli_query($conn, $query2) or die(mysqli_error($conn));
                    mysqli_close($conn);

                    ?>
                
                    <!-- MOSTRAR LA TABLA. Cambiar las cabeceras -->
                    <div class="tabla mt-5 mx-3 rounded-3 overflow-hidden">

                        <table class="table table-striped table-bordered">

                            <!-- Títulos de la tabla, cambiarlos -->
                            <thead class="table-dark">
                                <tr>
                                    <th scope="col" class="text-center">Recibo</th>                                
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
                                    <td class="text-center"><?= $fila["codigo"]; ?></td>                                
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

                    <?php

                else:
                    ?>

                    <div class="alert alert-danger text-center mt-5">
                        No se encontraron resultados para esta consulta
                    </div>

                    <?php
                endif;

            elseif($resultado and $resultado->num_rows > 0):
                
                $query3 = "SELECT * FROM recibo WHERE codigo = '$recibo'";

                $resultado3 = mysqli_query($conn, $query3) or die(mysqli_error($conn));

                mysqli_close($conn);

                if($resultado3 and $resultado3->num_rows > 0):
                    ?>

                    <!-- MOSTRAR LA TABLA. Cambiar las cabeceras -->
                    <div class="tabla mt-5 mx-3 rounded-3 overflow-hidden">

                        <table class="table table-striped table-bordered">

                            <!-- Títulos de la tabla, cambiarlos -->
                            <thead class="table-dark">
                                <tr>
                                    <th scope="col" class="text-center">Recibo</th>
                                    <th scope="col" class="text-center">Costo</th>
                                    <th scope="col" class="text-center">Fecha</th>
                                    <th scope="col" class="text-center">Estado</th>
                                    <th scope="col" class="text-center">Subrecibo de</th>
                                </tr>
                            </thead>

                            <tbody>

                                <?php
                                // Iterar sobre los registros que llegaron
                                foreach ($resultado3 as $fila):
                                ?>

                                <!-- Fila que se generará -->
                                <tr>
                                    <!-- Cada una de las columnas, con su valor correspondiente -->
                                    <td class="text-center"><?= $fila["codigo"]; ?></td>
                                    <td class="text-center"><?= $fila["costo"]; ?></td>
                                    <td class="text-center"><?= $fila["fecha_pago_oportuno"]; ?></td>
                                    <td class="text-center"><?= $fila["estado"]; ?></td>
                                    <td class="text-center"><?= $fila["subrecibo_de"]; ?></td>
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
        endforeach;
        
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