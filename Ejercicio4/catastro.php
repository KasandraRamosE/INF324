<?php
session_start();
include 'db.php';  // Incluir la conexión a la base de datos

// Verificar si el usuario está autenticado y tiene un `id_persona` en la sesión
if (!isset($_SESSION['id_persona'])) {
    header("Location: login.php");  // Redirigir al login si no hay un `id_persona` en la sesión
    exit();
}

// Obtener el `id_persona` desde la sesión
$id_persona = $_SESSION['id_persona'];
$properties = [];

// Consulta para obtener las propiedades asociadas a ese `id_persona`
$sql = "SELECT * FROM propiedad WHERE id_propietario='$id_persona'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $properties[] = $row;
    }
} else {
    $no_properties = true;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Consulta de Propiedades - HAM-LP</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        /* Imagen de Encabezado */
        .header-image {
            position: relative;
            width: 100%;
            height: 150px;
            background: url('imagenes/catastro.png') no-repeat center center;
            background-size: cover;
        }
        /* Posicionamiento del Botón */
        .btn-back {
            position: absolute;
            top: 20px;
            right: 20px;
            background: linear-gradient(90deg, #ff8f91 0%, #a78dff 100%);
            color: white;
            border: none;
            border-radius: 20px;
        }
        .form-control, .btn-primary {
            border-radius: 20px;
        }
        .table thead th {
            background-color: #343a40;
            color: white;
        }
        .table tbody tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        .btn-primary {
            background: linear-gradient(90deg, #ff8f91 0%, #a78dff 100%);
            border: none;
        }
        .container {
            max-width: 800px;
        }
        .btn-success {
            background: #28a745; /* Color verde */
            border: none;
            border-radius: 20px;
        }
        .hidden-form {
            display: inline;
        }
    </style>
</head>
<body>
    <!-- Imagen de Encabezado con Botón -->
    <div class="header-image">
        <a href="logout.php" class="btn btn-back">Cerrar Sesión</a>
    </div>

    <!-- Contenedor Principal -->
    <div class="container text-center p-4 shadow-lg rounded bg-white mt-4">
        <h3 class="mb-4">Propiedades Asociadas al ID de Usuario: <strong><?= $id_persona ?></strong></h3>

        <!-- Mensaje de No Resultados -->
        <?php if (isset($no_properties)) { ?>
            <div class="alert alert-danger mt-4" role="alert">
                No se encontraron propiedades asociadas a su cuenta.
            </div>
        <?php } ?>

        <!-- Tabla de Resultados -->
        <?php if (!empty($properties)) { ?>
            <h4 class="mt-5">Propiedades Asociadas</h4>
            <table class="table table-hover table-bordered mt-4">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Zona</th>
                        <th>Superficie</th>
                        <th>Distrito</th>
                        <th>Coordenadas</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($properties as $property) { ?>
                        <tr>
                            <td><?= $property['id'] ?></td>
                            <td><?= $property['zona'] ?></td>
                            <td><?= $property['superficie'] ?> m²</td>
                            <td><?= $property['distrito'] ?></td>
                            <td>(<?= $property['xini'] ?>, <?= $property['yini'] ?>) a (<?= $property['xfin'] ?>, <?= $property['yfin'] ?>)</td>
                            <td>
                                <!-- Formulario para enviar el ID de propiedad al servlet -->
                                <form action="http://localhost:8080/ejercicio4/servlet" method="post" class="hidden-form">
                                    <input type="hidden" name="id_catastro" value="<?= $property['id'] ?>">
                                    <button type="submit" class="btn btn-success btn-sm">Ver Impuestos</button>
                                </form>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        <?php } ?>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
