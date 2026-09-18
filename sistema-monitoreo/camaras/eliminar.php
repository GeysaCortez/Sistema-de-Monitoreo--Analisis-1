<?php
session_start();

require_once("../config/conexion.php");
/** @var mysqli $conexion */
$id = $_GET['id'];

$sql = "DELETE FROM camaras
WHERE id_camara='$id'";

mysqli_query($conexion, $sql);

header("Location: listar.php");
exit();
?>