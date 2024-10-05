<?php
session_start();
if (!isset($_SESSION['usuario']) || !isset($_SESSION['id_admin'])) {
    header("Location: login.php");
    exit();
}

include 'db.php';  // Incluir la conexión a la base de datos

// Obtener el `id_admin` desde la sesión
$id_admin = $_SESSION['id_admin'];

// Procesar el formulario al enviar
if (isset($_POST['add_persona'])) {
    $ci = $_POST['ci'];
    $nombre = $_POST['nombre'];
    $paterno = $_POST['paterno'];
    $materno = $_POST['materno'];
    $usuario = $_POST['usuario'];
    $contraseña = $_POST['contraseña'];  // La contraseña no será cifrada en esta versión
    $id_admi = $id_admin;  // Asignar el id del administrador actual

    // Insertar persona en la tabla `persona` con referencia al `id_admi`
    $sql = "INSERT INTO persona (ci, nombre, paterno, materno, usuario, contraseña, id_admi) 
            VALUES ('$ci', '$nombre', '$paterno', '$materno', '$usuario', '$contraseña', '$id_admi')";
    
    if ($conn->query($sql) === TRUE) {
        $success = "Nueva persona registrada exitosamente.";

        // Obtener el ID de la persona recién creada para asociar la propiedad
        $id_persona = $conn->insert_id;

        // Agregar información de la propiedad (si se ha ingresado)
        if (!empty($_POST['id']) && !empty($_POST['zona']) && !empty($_POST['xini']) && !empty($_POST['yini']) && !empty($_POST['xfin']) && !empty($_POST['yfin']) && !empty($_POST['superficie']) && !empty($_POST['distrito'])) {
            $id = $_POST['id'];
            $zona = $_POST['zona'];
            $xini = $_POST['xini'];
            $yini = $_POST['yini'];
            $xfin = $_POST['xfin'];
            $yfin = $_POST['yfin'];
            $superficie = $_POST['superficie'];
            $distrito = $_POST['distrito'];

            // Insertar la propiedad con `id_propietario` haciendo referencia al `id_persona`
            $property_sql = "INSERT INTO propiedad (id, zona, xini, yini, xfin, yfin, superficie, distrito, id_propietario) 
                             VALUES ('$id', '$zona', '$xini', '$yini', '$xfin', '$yfin', '$superficie', '$distrito', '$id_persona')";

            if ($conn->query($property_sql) === TRUE) {
                $success .= " y propiedad registrada correctamente.";
            } else {
                $error = "Error al registrar la propiedad: " . $conn->error;
            }
        }
    } else {
        $error = "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Agregar Nuevo Usuario y Propiedad - HAM-LP</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .form-container {
            max-width: 900px;
            margin: 50px auto;
            padding: 20px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        .btn-back {
            background: #a78dff;
            color: white;
            border: none;
            border-radius: 20px;
        }
        .btn-add {
            background: #00e1ea;
            color: white;
            border: none;
            border-radius: 20px;
        }
        .section-title {
            background: #f2f2f2;
            padding: 10px;
            border-radius: 10px;
            text-align: center;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="form-container">
            <h2 class="text-center mb-4">Agregar Nuevo Usuario y Propiedad</h2>
            
            <!-- Mensaje de Éxito/Error -->
            <?php if (isset($success)) { ?>
                <div class="alert alert-success text-center">
                    <?= $success; ?>
                </div>
            <?php } ?>
            <?php if (isset($error)) { ?>
                <div class="alert alert-danger text-center">
                    <?= $error; ?>
                </div>
            <?php } ?>

            <!-- Formulario de Agregar Usuario y Propiedad -->
            <form method="POST" action="">
                <div class="row">
                    <!-- Columna de Información del Usuario -->
                    <div class="col-md-6">
                        <h4 class="section-title">Información del Usuario</h4>
                        <div class="mb-3">
                            <label for="ci" class="form-label">CI</label>
                            <input type="text" class="form-control" name="ci" id="ci" required>
                        </div>
                        <div class="mb-3">
                            <label for="nombre" class="form-label">Nombre</label>
                            <input type="text" class="form-control" name="nombre" id="nombre" required>
                        </div>
                        <div class="mb-3">
                            <label for="paterno" class="form-label">Apellido Paterno</label>
                            <input type="text" class="form-control" name="paterno" id="paterno" required>
                        </div>
                        <div class="mb-3">
                            <label for="materno" class="form-label">Apellido Materno</label>
                            <input type="text" class="form-control" name="materno" id="materno" required>
                        </div>
                        <div class="mb-3">
                            <label for="usuario" class="form-label">Usuario</label>
                            <input type="text" class="form-control" name="usuario" id="usuario" required>
                        </div>
                        <div class="mb-3">
                            <label for="contraseña" class="form-label">Contraseña</label>
                            <input type="password" class="form-control" name="contraseña" id="contraseña" required>
                        </div>
                    </div>

                    <!-- Columna de Información de la Propiedad -->
                    <div class="col-md-6">
                        <h4 class="section-title">Información de la Propiedad</h4>
                        <div class="mb-3">
                            <label for="id" class="form-label">ID de Catastro</label>
                            <input type="text" class="form-control" name="id" id="id">
                        </div>
                        <div class="mb-3">
                            <label for="distrito" class="form-label">Distrito</label>
                            <select class="form-control" name="distrito" id="distrito">
                                <option value="">Seleccione un distrito</option>
                                <?php
                                // Obtener todos los distritos de la base de datos
                                $sql = "SELECT id, nombre FROM distrito";
                                $result = $conn->query($sql);
                                while ($row = $result->fetch_assoc()) {
                                    echo "<option value='" . $row['id'] . "'>" . $row['nombre'] . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="zona" class="form-label">Zona</label>
                            <select class="form-control" name="zona" id="zona">
                                <option value="">Seleccione una zona</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="xini" class="form-label">X Inicial</label>
                            <input type="text" class="form-control" name="xini" id="xini">
                        </div>
                        <div class="mb-3">
                            <label for="yini" class="form-label">Y Inicial</label>
                            <input type="text" class="form-control" name="yini" id="yini">
                        </div>
                        <div class="mb-3">
                            <label for="xfin" class="form-label">X Final</label>
                            <input type="text" class="form-control" name="xfin" id="xfin">
                        </div>
                        <div class="mb-3">
                            <label for="yfin" class="form-label">Y Final</label>
                            <input type="text" class="form-control" name="yfin" id="yfin">
                        </div>
                        <div class="mb-3">
                            <label for="superficie" class="form-label">Superficie</label>
                            <input type="text" class="form-control" name="superficie" id="superficie">
                        </div>
                    </div>
                </div>

                <!-- Botón de Registrar Usuario y Propiedad -->
                <div class="d-grid mt-4">
                    <button type="submit" name="add_persona" class="btn btn-add">Registrar Usuario y Propiedad</button>
                </div>
            </form>

            <!-- Botón de Regreso al Panel de Administración -->
            <div class="text-center mt-3">
                <a href="admin.php" class="btn btn-back">Volver al Panel de Administración</a>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
<script>
document.getElementById('distrito').addEventListener('change', function() {
    var distrito_id = this.value;

    // Limpiar el campo de zona antes de hacer la solicitud AJAX
    var zonaSelect = document.getElementById('zona');
    zonaSelect.innerHTML = '<option value="">Seleccione una zona</option>';

    if (distrito_id) {
        // Realizar la solicitud AJAX
        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'zonas.php', true);
        xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

        // Definir lo que sucederá cuando la solicitud tenga éxito
        xhr.onload = function() {
            if (this.status === 200) {
                var zonas = JSON.parse(this.responseText);
                zonas.forEach(function(zona) {
                    var option = document.createElement('option');
                    option.value = zona.id;
                    option.textContent = zona.nombre;
                    zonaSelect.appendChild(option);
                });
            }
        };

        // Enviar la solicitud con el id del distrito
        xhr.send('distrito_id=' + distrito_id);
    }
});
</script>

</html>
