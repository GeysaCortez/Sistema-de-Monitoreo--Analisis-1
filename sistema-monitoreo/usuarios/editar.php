<?php
session_start();

if (!isset($_SESSION['id_usuario'])) {
    header("Location: ../login.php");
    exit();
}

require_once("../config/conexion.php");
/** @var mysqli $conexion */
$id = $_GET['id'];

$sql = "SELECT * FROM usuarios
        WHERE id_usuario = '$id'";

$resultado = mysqli_query($conexion, $sql);

$usuario = mysqli_fetch_assoc($resultado);

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $cargo = $_POST['cargo'];
    $nombre_usuario = $_POST['usuario'];
    $password = $_POST['password'];
    $password = password_hash(
        $password,
        PASSWORD_DEFAULT
    );
    $estado = $_POST['estado'];
    $id_rol = $_POST['id_rol'];

    $sqlUpdate = "UPDATE usuarios SET

        nombre='$nombre',
        apellido='$apellido',
        cargo='$cargo',
        usuario='$nombre_usuario',
        password='$password',
        estado='$estado',
        id_rol='$id_rol'

        WHERE id_usuario='$id'
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
    <title>Editar Usuario</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet">
</head>

<body class="bg-light">

    <div class="container mt-5">

        <div class="card shadow">

            <div class="card-body">

                <h2 class="mb-4">
                    Editar Usuario
                </h2>

                <form method="POST">

                    <input
                        class="form-control mb-3"
                        name="nombre"
                        value="<?php echo $usuario['nombre']; ?>"
                        required>

                    <input
                        class="form-control mb-3"
                        name="apellido"
                        value="<?php echo $usuario['apellido']; ?>"
                        required>

                    <input
                        class="form-control mb-3"
                        name="cargo"
                        value="<?php echo $usuario['cargo']; ?>">

                    <input
                        class="form-control mb-3"
                        name="usuario"
                        value="<?php echo $usuario['usuario']; ?>"
                        required>

                    <input
                        type="text"
                        class="form-control mb-3"
                        name="password"
                        value="<?php echo $usuario['password']; ?>"
                        required>

                    <select
                        class="form-control mb-3"
                        name="estado">

                        <option value="Activo"
                            <?php
                            if ($usuario['estado'] == "Activo")
                                echo "selected";
                            ?>>
                            Activo
                        </option>

                        <option value="Inactivo"
                            <?php
                            if ($usuario['estado'] == "Inactivo")
                                echo "selected";
                            ?>>
                            Inactivo
                        </option>

                    </select>

                    <select
                        class="form-control mb-3"
                        name="id_rol">

                        <option value="1"
                            <?php
                            if ($usuario['id_rol'] == 1)
                                echo "selected";
                            ?>>
                            Administrador
                        </option>

                        <option value="2"
                            <?php
                            if ($usuario['id_rol'] == 2)
                                echo "selected";
                            ?>>
                            Operador
                        </option>

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