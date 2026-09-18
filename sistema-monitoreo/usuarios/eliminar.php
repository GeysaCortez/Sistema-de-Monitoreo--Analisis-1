<?php
session_start();

if (!isset($_SESSION['id_usuario'])) {
    header("Location: ../login.php");
    exit();
}

require_once("../config/conexion.php");
/** @var mysqli $conexion */
$id = $_GET['id'];

/*
NO BORRAR ADMIN PRINCIPAL
*/

if ($id == 1) {

    echo "
    <script>
    alert('No se puede eliminar el administrador principal');
    window.location='listar.php';
    </script>
    ";

    exit();
}

$sql = "DELETE FROM usuarios
WHERE id_usuario='$id'";

mysqli_query($conexion, $sql);

header("Location: listar.php");
exit();
?>