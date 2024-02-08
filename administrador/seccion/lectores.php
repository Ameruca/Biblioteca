<?php include("../template/cabecera.php"); ?>

<?php

$txtID = (isset($_POST['txtID'])) ? $_POST['txtID'] : "";
$txtNombre = (isset($_POST['txtNombre'])) ? $_POST['txtNombre'] : "";
$txtCedula = (isset($_POST['txtCedula'])) ? $_POST['txtCedula'] : "";
$accion = (isset($_POST['accion'])) ? $_POST['accion'] : "";

include("../config/bd.php");



switch ($accion) {
    case "Agregar":
        $sentenciaSQL = $conexion->prepare("INSERT INTO lectores (nombre, cedula) VALUES (:nombre, :cedula);");
        $sentenciaSQL->bindParam(':nombre', $txtNombre);
        $sentenciaSQL->bindParam(':cedula', $txtCedula);
        $sentenciaSQL->execute();
        header("Location:lectores.php");
        break;

    case "Modificar":
        $sentenciaSQL = $conexion->prepare("UPDATE lectores SET nombre=:nombre WHERE id_lector=:id_lector");
        $sentenciaSQL->bindParam(':nombre', $txtNombre);
        $sentenciaSQL->bindParam(':id_lector', $txtID);
        $sentenciaSQL->execute();
        $sentenciaSQL = $conexion->prepare("UPDATE lectores SET cedula=:cedula WHERE id_lector=:id_lector");
        $sentenciaSQL->bindParam(':cedula', $txtCedula);
        $sentenciaSQL->bindParam(':id_lector', $txtID);
        $sentenciaSQL->execute();
        header("Location:lectores.php");
        break;

    case "Cancelar":
        header("Location:lectores.php");
        break;

    case "Seleccionar":

        $sentenciaSQL = $conexion->prepare("SELECT * FROM lectores WHERE id_lector=:id_lector");
        $sentenciaSQL->bindParam(':id_lector', $txtID);
        $sentenciaSQL->execute();
        $lector = $sentenciaSQL->fetch(PDO::FETCH_LAZY);

        $txtNombre = $lector['nombre'];
        $txtCedula = $lector['cedula'];
        break;

    case "Borrar":
        $sentenciaSQL = $conexion->prepare("DELETE FROM lectores WHERE id_lector=:id_lector");
        $sentenciaSQL->bindParam(':id_lector', $txtID);
        $sentenciaSQL->execute();
        header("Location:lectores.php");
        break;
}

$sentenciaSQL = $conexion->prepare("SELECT * FROM lectores");
$sentenciaSQL->execute();
$listaLectores = $sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);


?>


<div class="col-md-4">


    <div class="card">
        <div class="card-header">
        <p style="text-align:center" class="lead">Datos del Lector</p>
        </div>

        <div class="card-body">
            <form method="POST" enctype="Multipart/Form-data">

                <div class="form-group" >
                    <label for="txtID" >ID del Lector:</label>
                    <input type="text" required readonly class="form-control" value="<?php echo $txtID; ?>" name="txtID" id="txtID" placeholder="ID">
                </div>

                <div class="form-group">
                    <label for="txtNombre">Nombre del Lector:</label>
                    <input type="text" required class="form-control" value="<?php echo $txtNombre; ?>" name="txtNombre" id="txtNombre" placeholder="Nombre del Lector">
                </div>

                <div class="form-group">
                    <label for="txtCedula">Cedula del Lector:</label>
                    <input type="number" required class="form-control" value="<?php echo $txtCedula; ?>" name="txtCedula" id="txtCedula" placeholder="Cedula del Lector">
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
<div class="col-md-7">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th style="text-align:center">ID</th>
                <th style="text-align:center">Nombre</th>
                <th style="text-align:center">Cedula</th>
                <th style="text-align:center">Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($listaLectores as $lectores) { ?>
                <tr>
                    <td><?php echo $lectores['id_lector']; ?> </td>
                    <td><?php echo $lectores['nombre']; ?> </td>
                    <td><?php echo $lectores['cedula']; ?> </td>
                    <td>

                        <form method="post">
                            <input type="hidden" name="txtID" id="txtID" value="<?php echo $lectores['id_lector']; ?>" />

                            <input type="submit" name="accion" value="Seleccionar" class="btn btn-primary" />

                            <input type="submit" name="accion" value="Borrar" class="btn btn-danger" />

                        </form>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>


<?php include("../template/pie.php"); ?>