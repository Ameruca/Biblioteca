<?php include("../template/cabecera.php"); ?>


<div class="col-md-12">
    <div class="jumbotron">

        <h1 style="text-align:center" class="display-3">Sistema de Inventario de Biblioteca </h1>
        <br />
        <hr class="my-2">
        <p style="text-align:center" class="lead">Adminsitracion de prestamos de libros, inventario de libros y lista de lectores</p>
        <hr class="my-2">
    </div>
</div>

<div class="col-md-3">
    <div class="card">
            <a style="display: flex;  align-items: center; justify-content: center;" class="btn btn-primary btn-lg" href="libros.php" role="button">Inventario de Libros</a>
    </div>
</div>

<div class="col-md-3">
    <div class="card">
            <a style="display: flex;  align-items: center; justify-content: center;" class="btn btn-primary btn-lg" href="lectores.php" role="button">Lista de Lectores</a>
    </div>
</div>

<div class="col-md-3">
    <div class="card">
            <a style="display: flex;  align-items: center; justify-content: center;" class="btn btn-primary btn-lg" href="prestamo.php" role="button">Crear Prestamo</a>
    </div>
</div>

<div class="col-md-3">
    <div class="card">
            <a style="display: flex;  align-items: center; justify-content: center;" class="btn btn-primary btn-lg" href="l_prestamos.php" role="button">Lista de Prestamo</a>
    </div>
</div>

<?php include("../template/pie.php"); ?>