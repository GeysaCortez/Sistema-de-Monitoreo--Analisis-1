<?php
session_start();

if (!isset($_SESSION['id_usuario'])) {
    header("Location: ../login.php");
    exit();
}

require_once("../config/conexion.php");
/** @var mysqli $conexion */
$id = $_GET['id'];

$sql = "DELETE FROM incidentes
WHERE id_incidente='$id'";

mysqli_query($conexion, $sql);

header("Location: listar.php");
exit();
?>