<?php
include 'db.php';  // Incluir la conexión a la base de datos

if (isset($_POST['distrito_id'])) {
    $distrito_id = $_POST['distrito_id'];

    // Consultar las zonas asociadas al distrito seleccionado
    $sql = "SELECT id, nombre FROM zona WHERE distrito_id = '$distrito_id'";
    $result = $conn->query($sql);

    $zonas = array();
    while ($row = $result->fetch_assoc()) {
        $zonas[] = $row;
    }

    // Devolver las zonas como JSON
    echo json_encode($zonas);
}
?>
