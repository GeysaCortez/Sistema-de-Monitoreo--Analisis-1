<?php
session_start();

require_once("../config/conexion.php");
/** @var mysqli $conexion */
$id = $_GET['id'];

$sql = "SELECT * FROM camaras
WHERE id_camara='$id'";

$resultado = mysqli_query($conexion, $sql);

$camara = mysqli_fetch_assoc($resultado);

$zonas = mysqli_query(
    $conexion,
    "SELECT * FROM zonas"
);

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nombre = $_POST['nombre'];
    $ubicacion = $_POST['ubicacion'];
    $estado = $_POST['estado'];
    $ip = $_POST['direccion_ip'];
    if (
        !empty($ip) &&
        !filter_var(
            $ip,
            FILTER_VALIDATE_IP
        )
    ) {

        echo "
    <script>
    alert('IP inválida');
    window.history.back();
    </script>
    ";

        exit();
    }
    $fecha = $_POST['fecha_instalacion'];
    $id_zona = $_POST['id_zona'];
    $url_stream = $_POST['url_stream'];

    $sqlUpdate = "UPDATE camaras SET

    nombre='$nombre',
    ubicacion='$ubicacion',
    estado='$estado',
    direccion_ip='$ip',
    fecha_instalacion='$fecha',
    id_zona='$id_zona',
    url_stream='$url_stream'
    WHERE id_camara='$id'
    ";

    mysqli_query($conexion, $sqlUpdate);

    header("Location: listar.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Editar Cámara</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet">

</head>

<body class="bg-light">

    <div class="container mt-5">

        <div class="card shadow">

            <div class="card-body">

                <h2>Editar Cámara</h2>

                <form method="POST">

                    <input
                        class="form-control mb-3"
                        name="nombre"
                        value="<?php echo $camara['nombre']; ?>"
                        required>

                    <input
                        class="form-control mb-3"
                        name="ubicacion"
                        value="<?php echo $camara['ubicacion']; ?>"
                        required>

                    <input
                        class="form-control mb-3"
                        name="direccion_ip"
                        value="<?php echo $camara['direccion_ip']; ?>">

                    <input
                        class="form-control mb-3"
                        name="url_stream"
                        value="<?php echo $camara['url_stream']; ?>"
                        placeholder="URL transmisión">

                    <input
                        type="date"
                        class="form-control mb-3"
                        name="fecha_instalacion"
                        value="<?php echo $camara['fecha_instalacion']; ?>">

                    <select
                        class="form-control mb-3"
                        name="estado">

                        <option value="Activa"
                            <?php if ($camara['estado'] == "Activa") echo "selected"; ?>>
                            Activa
                        </option>

                        <option value="Inactiva"
                            <?php if ($camara['estado'] == "Inactiva") echo "selected"; ?>>
                            Inactiva
                        </option>

                    </select>

                    <select
                        class="form-control mb-3"
                        name="id_zona">

                        <?php while ($zona = mysqli_fetch_assoc($zonas)) { ?>

                            <option
                                value="<?php echo $zona['id_zona']; ?>"

                                <?php
                                if ($camara['id_zona'] == $zona['id_zona'])
                                    echo "selected";
                                ?>>

                                <?php echo $zona['nombre_zona']; ?>

                            </option>

                        <?php } ?>

                    </select>

                    <button class="btn btn-warning">
                        Actualizar
                    </button>

                    <a href="listar.php"
                        class="btn btn-secondary">
                        Volver
                    </a>

                </form>

            </div>

        </div>

    </div>

</body>

</html>