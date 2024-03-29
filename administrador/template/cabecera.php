<?php
session_start();
if (!isset($_SESSION['usuario'])) {
  header("Location:../index.php");
} else {

  if ($_SESSION['usuario'] == "ok") {
    $nombreUsuario = $_SESSION["nombreUsuario"];
  }
}
?>
<!doctype html>
<html lang="en">

<head>
  <title>Sistema de Inventario</title>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="../../css/footer.css">
  <link rel="stylesheet" href="../../css/vista.css">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

</head>

<body>

  <?php $url = "http://" . $_SERVER['HTTP_HOST'] . "/pagina%20web" ?>

  <nav class="navbar navbar-expand navbar-light bg-light">
    <div class="nav navbar-nav">
      <a class="nav-item nav-link active" href="#">Sistema de Inventario <span class="sr-only">(current)</span></a>
      <a class="nav-item nav-link" href="<?php echo $url; ?> /administrador/seccion/inicio.php">Inicio</a>
      <a class="nav-item nav-link" href="<?php echo $url; ?> /administrador/seccion/libros.php">Lista de Libros</a>
      <a class="nav-item nav-link" href="<?php echo $url; ?> /administrador/seccion/lectores.php">Lista de Lectores</a>
      <a class="nav-item nav-link" href="<?php echo $url; ?> /administrador/seccion/prestamo.php">Crear Prestamo</a>
      <a class="nav-item nav-link" href="<?php echo $url; ?> /administrador/seccion/l_prestamos.php">Lista de Prestamos</a>
      <a class="nav-item nav-link" href="<?php echo $url; ?> /administrador/seccion/cerrar.php">Salir</a>

    </div>
  </nav>


  <div class="container">
    <br />
    <div class="row">