<?php
session_start();

require_once("../config/conexion.php");
/** @var mysqli $conexion */
$zonas = mysqli_query(
    $conexion,
    "SELECT * FROM zonas"
);

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nombre = $_POST['nombre'];
    $ubicacion = $_POST['ubicacion'];
    $estado = $_POST['estado'];
    $ip = $_POST['direccion_ip'];
    /*
VALIDAR IP
*/

    if (
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

    /*
VALIDAR CAMARA DUPLICADA
*/

    $verificar = mysqli_query(
        $conexion,

        "SELECT * FROM camaras
WHERE nombre='$nombre'"
    );

    if (mysqli_num_rows($verificar) > 0) {

        echo "
    <script>
    alert('La cámara ya existe');
    window.history.back();
    </script>
    ";

        exit();
    }

    $sql = "INSERT INTO camaras
    (
        nombre,
        ubicacion,
        estado,
        direccion_ip,
        fecha_instalacion,
        id_zona
        url_stream
    )

    VALUES

    (
        '$nombre',
        '$ubicacion',
        '$estado',
        '$ip',
        '$fecha',
        '$id_zona'
        '$url_stream'
    )";

    mysqli_query($conexion, $sql);

    header("Location: listar.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Agregar Cámara</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet">

</head>

<body class="bg-light">

    <div class="container mt-5">

        <div class="card shadow">

            <div class="card-body">

                <h2>Agregar Cámara</h2>

                <form method="POST">

                    <input
                        class="form-control mb-3"
                        name="nombre"
                        placeholder="Nombre"
                        required>

                    <input
                        class="form-control mb-3"
                        name="ubicacion"
                        placeholder="Ubicación"
                        required>

                    <input
                        class="form-control mb-3"
                        name="direccion_ip"
                        placeholder="Dirección IP">

                    <input
                        class="form-control mb-3"
                        name="url_stream"
                        placeholder="URL transmisiónEj: http://192.168.1.25:8080/video">

                    <input
                        type="date"
                        class="form-control mb-3"
                        name="fecha_instalacion">

                    <select
                        class="form-control mb-3"
                        name="estado">

                        <option>Activa</option>
                        <option>Inactiva</option>

                    </select>

                    <select
                        class="form-control mb-3"
                        name="id_zona"
                        required>

                        <option value="">
                            Seleccione zona
                        </option>

                        <?php while ($zona = mysqli_fetch_assoc($zonas)) { ?>

                            <option value="<?php echo $zona['id_zona']; ?>">

                                <?php echo $zona['nombre_zona']; ?>

                            </option>

                        <?php } ?>

                    </select>

                    <button class="btn btn-success">
                        Guardar
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