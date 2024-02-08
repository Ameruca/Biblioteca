<?php include("../template/cabecera.php"); ?>

<?php

$txtID = (isset($_POST['txtID'])) ? $_POST['txtID'] : "";
$txtNombre = (isset($_POST['txtNombre'])) ? $_POST['txtNombre'] : "";
$txtImagen = (isset($_FILES['txtImagen']['name'])) ? $_FILES['txtImagen']['name'] : "";
$txtGenero = (isset($_POST['txtGenero'])) ? $_POST['txtGenero'] : "";
$txtCantidad = (isset($_POST['txtCantidad'])) ? $_POST['txtCantidad'] : "";
$accion = (isset($_POST['accion'])) ? $_POST['accion'] : "";


include("../config/bd.php");



switch ($accion) {
    case "Agregar":
        $sentenciaSQL = $conexion->prepare("INSERT INTO libros (nombre, imagen, genero, cantidad) VALUES (:nombre, :imagen, :genero, :cantidad);");
        $sentenciaSQL->bindParam(':nombre', $txtNombre);

        $fecha = new DateTime();
        $nombreArchivo = ($txtImagen != "") ? $fecha->getTimestamp() . "_" . $_FILES["txtImagen"]["name"] : "imagen.jpg";

        $tmpImagen = $_FILES["txtImagen"]["tmp_name"];

        if ($tmpImagen != "") {

            move_uploaded_file($tmpImagen, "../../img/" . $nombreArchivo);
        }
        $sentenciaSQL->bindParam(':imagen', $nombreArchivo);
        $sentenciaSQL->bindParam(':genero', $txtGenero);
        $sentenciaSQL->bindParam(':cantidad', $txtCantidad);
        $sentenciaSQL->execute();
        header("Location:libros.php");
        break;

    case "Modificar":
        $sentenciaSQL = $conexion->prepare("UPDATE libros SET nombre=:nombre WHERE id_libro=:id_libro");
        $sentenciaSQL->bindParam(':nombre', $txtNombre);
        $sentenciaSQL->bindParam(':id_libro', $txtID);
        $sentenciaSQL->execute();

        if ($txtImagen != "") {

            $fecha = new DateTime();
            $nombreArchivo = ($txtImagen != "") ? $fecha->getTimestamp() . "_" . $_FILES["txtImagen"]["name"] : "imagen.jpg";
            $tmpImagen = $_FILES["txtImagen"]["tmp_name"];

            move_uploaded_file($tmpImagen, "../../img/" . $nombreArchivo);

            $sentenciaSQL = $conexion->prepare("SELECT imagen FROM libros WHERE id_libro=:id_libro");
            $sentenciaSQL->bindParam(':id_libro', $txtID);
            $sentenciaSQL->execute();
            $libro = $sentenciaSQL->fetch(PDO::FETCH_LAZY);

            if (isset($libro["imagen"]) && ($libro["imagen"] != "imagen.jpg")) {

                if (file_exists("../../img/" . $libro["imagen"])) {

                    unlink("../../img/" . $libro["imagen"]);
                }
            }

            $sentenciaSQL = $conexion->prepare("UPDATE libros SET imagen=:imagen WHERE id_libro=:id_libro");
            $sentenciaSQL->bindParam(':imagen', $nombreArchivo);
            $sentenciaSQL->bindParam(':id_libro', $txtID);
            $sentenciaSQL->execute();
        }
        $sentenciaSQL = $conexion->prepare("UPDATE libros SET genero=:genero WHERE id_libro=:id_libro");
        $sentenciaSQL->bindParam(':genero', $txtGenero);
        $sentenciaSQL->bindParam(':id_libro', $txtID);
        $sentenciaSQL->execute();

        $sentenciaSQL = $conexion->prepare("UPDATE libros SET cantidad=:cantidad WHERE id_libro=:id_libro");
        $sentenciaSQL->bindParam(':cantidad', $txtCantidad);
        $sentenciaSQL->bindParam(':id_libro', $txtID);
        $sentenciaSQL->execute();
        break;

    case "Cancelar":
        header("Location:libros.php");
        break;

    case "Seleccionar":

        $sentenciaSQL = $conexion->prepare("SELECT * FROM libros WHERE id_libro=:id_libro");
        $sentenciaSQL->bindParam(':id_libro', $txtID);
        $sentenciaSQL->execute();
        $libro = $sentenciaSQL->fetch(PDO::FETCH_LAZY);

        $txtNombre = $libro['nombre'];
        $txtImagen = $libro['imagen'];
        $txtGenero = $libro['genero'];
        $txtCantidad = $libro['cantidad'];
        break;

    case "Eliminar":
        $sentenciaSQL = $conexion->prepare("SELECT imagen FROM libros WHERE id_libro=:id_libro");
        $sentenciaSQL->bindParam(':id_libro', $txtID);
        $sentenciaSQL->execute();
        $libro = $sentenciaSQL->fetch(PDO::FETCH_LAZY);

        if (isset($libro["imagen"]) && ($libro["imagen"] != "imagen.jpg")) {

            if (file_exists("../../img/" . $libro["imagen"])) {

                unlink("../../img/" . $libro["imagen"]);
            }
        }

        $sentenciaSQL = $conexion->prepare("DELETE FROM libros WHERE id_libro=:id_libro");
        $sentenciaSQL->bindParam(':id_libro', $txtID);
        $sentenciaSQL->execute();
        header("Location:libros.php");
        break;
}

$sentenciaSQL = $conexion->prepare("SELECT * FROM libros");
$sentenciaSQL->execute();
$listaLibros = $sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);


?>


<div class="col-md-4">
    <div class="card">
        <div class="card-header">
            <p style="text-align:center" class="lead">Datos del Libro</p>
        </div>

        <div class="card-body">
            <form method="POST" enctype="Multipart/Form-data">

                <div class="form-group">
                    <label for="txtID">ID del Libro</label>
                    <input type="text" required readonly class="form-control" value="<?php echo $txtID; ?>" name="txtID" id="txtID" placeholder="ID">
                </div>

                <div class="form-group">
                    <label for="txtNombre">Nombre del Libro</label>
                    <input type="text" required class="form-control" value="<?php echo $txtNombre; ?>" name="txtNombre" id="txtNombre" placeholder="Nombre del Libro">
                </div>

                <div class="form-group">
                    <label for="txtNombre">Imagen del Libro</label>

                    <br />

                    <?php if ($txtImagen != "") { ?>
                        <img class="img-thumbnail rounded" src="../../img/<?php echo $txtImagen; ?>" width="100" alt="" srcset=""></td>
                    <?php }
                    ?>

                    <input type="file" class="form-control" name="txtImagen" id="txtImagen" placeholder="Imagen del Libro">
                </div>

                <div class="form-group">
                    <label for="txtGenero">Genero del Libro</label>
                    <input type="text" required class="form-control" value="<?php echo $txtGenero; ?>" name="txtGenero" id="txtGenero" placeholder="Genero">
                </div>

                <div class="form-group">
                    <label for="txtCantidad">Cantidad de Ejemplares</label>
                    <input type="number" required class="form-control" value="<?php echo $txtCantidad; ?>" name="txtCantidad" id="txtCantidad" placeholder="Cantidad">
                </div>


                <div class="btn-group-justified" role="group" aria-label="">
                    &nbsp;&nbsp;&nbsp;
                    <button type="submit" name="accion" <?php echo ($accion == "Seleccionar") ? "disabled" : ""; ?> value="Agregar" class="btn btn-success">Agregar</button>

                    <button type="submit" name="accion" <?php echo ($accion != "Seleccionar") ? "disabled" : ""; ?> value="Modificar" class="btn btn-warning">Modificar</button>

                    <button type="submit" name="accion" <?php echo ($accion != "Seleccionar") ? "disabled" : ""; ?> value="Cancelar" class="btn btn-info">Cancelar</button>

                </div>

            </form>


        </div>


    </div>

</div>
<div class="col-md-8">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th style="text-align:center">ID</th>
                <th style="text-align:center">Nombre de libro</th>
                <th style="text-align:center">Imagen</th>
                <th style="text-align:center">Categoria</th>
                <th style="text-align:center">Cantidad</th>
                <th style="text-align:center">Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($listaLibros as $libro) { ?>
                <tr>
                    <td><?php echo $libro['id_libro']; ?> </td>
                    <td><?php echo $libro['nombre']; ?> </td>
                    <td>

                        <img src="../../img/<?php echo $libro['imagen']; ?>" width="50" alt="" srcset="">
                    </td>
                    <td style="text-align:center"><?php echo $libro['genero']; ?> </td>
                    <td style="text-align:center"><?php echo $libro['cantidad']; ?> </td>



                    <td>

                        <form method="post">
                            <div class="d-flex">
                                <input type="hidden" name="txtID" id="txtID" value="<?php echo $libro['id_libro']; ?>" />

                                <input type="submit" name="accion" value="Seleccionar" class="btn btn-primary" />

                                <input type="submit" name="accion" value="Eliminar" class="btn btn-danger" />
                            </div>
                        </form>
                    </td>

                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>


<?php include("../template/pie.php"); ?>