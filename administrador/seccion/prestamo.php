<?php include("../template/cabecera.php");
include("../config/bd.php");
$txtID = (isset($_POST['txtID'])) ? $_POST['txtID'] : "";
$nombreLibro = "";
$txtLector = (isset($_POST['id_lector'])) ? $_POST['id_lector'] : "";
$fecha = (isset($_POST['fecha_r'])) ? $_POST['fecha_r'] : "";
$accion = (isset($_POST['accion'])) ? $_POST['accion'] : "";


switch ($accion) {
    case "Prestar":
        $sentenciaSQL = $conexion->prepare("INSERT INTO prestamos (id_libro, id_lector, cantidad, fecha, estado) VALUES (:id_libro, :id_lector, '1', :fecha, 'Prestado');");
        $sentenciaSQL->bindParam(':id_libro', $txtID);
        $sentenciaSQL->bindParam(':id_lector', $txtLector);
        $sentenciaSQL->bindParam(':fecha', $fecha);
        $sentenciaSQL->execute();
        header("Location:prestamo.php");
        break;

    case "Seleccionar":

        $sentenciaSQL = $conexion->prepare("SELECT * FROM libros WHERE id_libro=:id_libro");
        $sentenciaSQL->bindParam(':id_libro', $txtID);
        $sentenciaSQL->execute();
        $libro = $sentenciaSQL->fetch(PDO::FETCH_LAZY);

        $nombreLibro = $libro['nombre'];
        break;

    case "Cancelar":
        header("Location:prestamo.php");
        break;
}

?>

<div class="col-md-4">
    <div class="card">
        <div class="card-header">
            <p style="text-align:center" class="lead">Datos del Prestamo</p>
        </div>

        <div class="card-body">
            <form method="POST" enctype="Multipart/Form-data">

                <div class="form-group">
                    <input type="Hidden" required readonly class="form-control" value="<?php echo $txtID; ?>" name="txtID" id="txtID" placeholder="ID del libro">
                </div>

                <div class="form-group">
                    <label for="txtID">Libro a Prestar</label>
                    <input type="text" required readonly class="form-control" value="<?php echo $nombreLibro; ?>" name="NombreLibro" id="NombreLibro" placeholder="Nombre del libro">
                </div>

                <div class="form-group">
                    <label for="txtNombre">Nombre del Lector</label>
                    </br>
                    <select name="id_lector" id="lector">
                        <option value="" selected="selected" disabled="disabled">Seleccione un Lector</option>
                        <?php
                        $sqllectores = $conexion->query("SELECT * FROM lectores ORDER BY nombre");
                        while ($lectores = $sqllectores->fetch(PDO::FETCH_LAZY)) {
                        ?>
                            <option value="<?php echo $lectores['id_lector'] ?>"><?php echo $lectores['nombre'] ?></option>
                        <?php
                        }
                        ?>
                    </select>
                </div>

                <div class="form-group">
                    <label>Fecha de Retorno</label>
                    <input type="date" name="fecha_r" value="fecha_r" class="form-control" />
                </div>

                <div class="btn-group-justified" role="group" aria-label="">
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <button type="submit" name="accion" value="Prestar" class="btn btn-success">Prestar</button>
                    <button type="submit" name="accion" value="Cancelar" <?php echo ($accion != "Seleccionar") ? "disabled" : ""; ?> class="btn btn-danger">Cancelar</button>
                </div>

            </form>


        </div>


    </div>
</div>

<div class="col-md-8">
    <table class="table table-bordered">
        <thead class="alert-success">
            <tr>
                <th style="text-align:center">Seleccionar</button>
                <th style="text-align:center">Nombre del libro</th>
                <th style="text-align:center">Genero de libro</th>
                <th style="text-align:center">Cantidad</th>
                <th style="text-align:center">Disponibles</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sqlLibros = $conexion->prepare("SELECT * FROM libros");
            $sqlLibros->execute();
            $listaLibros = $sqlLibros->fetchAll(PDO::FETCH_ASSOC);
            foreach ($listaLibros as $libros) { ?>
                <form method="POST">
                    <?php
                    $sqlPrestamos = $conexion->query("SELECT SUM(cantidad) as total FROM prestamos WHERE id_libro = '$libros[id_libro]' && estado = 'Prestado'");
                    $nuevaCan = $sqlPrestamos->fetch(PDO::FETCH_LAZY);
                    $total = $libros['cantidad'] - $nuevaCan['total'];

                    ?>
                    <tr>
                        <td>

                            <?php
                            if ($total == 0) {
                                echo "<label class = 'text-danger'>No Disponible</label>";
                            } else {
                                echo '<input type = "hidden" name = "txtID" value = "' . $libros['id_libro'] . '">
                                <button type="submit" name="accion" value="Seleccionar" class="btn btn-success">Seleccionar</button>';
                            }
                            ?>

                        </td>
                        <td><?php echo $libros['nombre'] ?></td>
                        <td style="text-align:center"><?php echo $libros['genero'] ?></td>
                        <td style="text-align:center"><?php echo $libros['cantidad'] ?></td>
                        <td style="text-align:center"><?php echo $total ?></td>
                    </tr>
                </form>
            <?php
            }
            ?>
        </tbody>
    </table>
</div>
<?php include("../template/pie.php"); ?>