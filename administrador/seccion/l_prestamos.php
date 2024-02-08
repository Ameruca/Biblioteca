<?php include("../template/cabecera.php");
include("../config/bd.php");
$devolucion = $conexion->prepare("SELECT * FROM prestamos WHERE estado = 'Prestado'");
$devolucion->execute();
$listaDevolucion = $devolucion->fetchAll(PDO::FETCH_ASSOC);
?>


<table style="background-color: white;" id="tabla" class="table table-bordered">
    <thead class="alert-success">
        <tr>
            <th style="text-align:center">Estudiante</th>
            <th style="text-align:center">Titulo del libro</th>
            <th style="text-align:center">Estado</th>
            <th style="text-align:center">Fecha Devolución</th>
            <th style="text-align:center">Acción</th>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach ($listaDevolucion as $devolucion) {
        ?>
            <tr>
                <td style="text-align:center">
                    <?php
                    $sql = $conexion->query("SELECT * FROM lectores WHERE id_lector = '$devolucion[id_lector]'");
                    $lector = $sql->fetch(PDO::FETCH_LAZY);
                    echo $lector['nombre'];
                    ?>
                </td>
                <td>
                    <?php
                    $sql = $conexion->query("SELECT * FROM libros WHERE id_libro = '$devolucion[id_libro]'");
                    $libro =  $sql->fetch(PDO::FETCH_LAZY);
                    echo $libro['nombre'];
                    ?>
                </td>
                <td style="text-align:center"><?php echo $devolucion['estado'] ?></td>
                <td style="text-align:center"><?php echo date("d-m-Y", strtotime($devolucion['fecha'])) ?></td>
                <td>
                    <form method="POST" action="devolucion.php" enctype="multipart/form-data">
                        <div class="form-group pull-right">
                            <input type="hidden" name="id" value="<?php echo $devolucion['id']; ?>" />
                            
                            <input type="submit" name="devolver" value="Devolver" class="btn btn-primary" />
                        </div>
                    </form>
                </td>
            </tr>
        <?php
        }
        ?>
    </tbody>
</table>



<?php include("../template/pie.php"); ?>