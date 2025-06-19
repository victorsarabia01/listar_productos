<?php
require 'config.php'; // Conexión a la BD
header('Content-Type: application/json'); // Importante para devolver JSON

$database = new Database();
$conn = $database->getConnection();

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $query = "DELETE FROM productos WHERE id = :id";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);

    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'No se pudo eliminar el producto.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'ID no proporcionado.']);
}
?>