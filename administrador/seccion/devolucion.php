<?php
include("../config/bd.php");
	$date = date("Y-m-d", strtotime("+8 HOURS"));
    $id = $_POST['id'];
	$conexion->query("UPDATE prestamos SET estado = 'Devuelto' WHERE id = '$id'");
    echo '
			<script type = "text/javascript">
				alert("Libro regresado.");
				window.location = "libros.php";
			</script>
		';
	header('location: l_prestamos.php');
?>