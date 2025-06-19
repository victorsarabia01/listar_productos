<?php
require 'config.php';
$database = new Database();
$conn = $database->getConnection();

// Validar que se recibió la búsqueda
if (isset($_POST['valorBusqueda'])) {
    $valor = trim($_POST['valorBusqueda']);

    $query = "SELECT COUNT(*) FROM productos WHERE nombre = :nombre";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(":nombre", $valor);
    $stmt->execute();

    $existe = $stmt->fetchColumn();

    if ($existe > 0) {
        echo "<span class='text-danger'>⚠️ El producto ya está registrado.</span>";
        echo "<script>document.getElementById('registro').disabled = true;</script>";
    } else {
        echo "<span class='text-success'>✔️ Nombre disponible.</span>";
        echo "<script>document.getElementById('registro').disabled = false;</script>";
    }
}
?>