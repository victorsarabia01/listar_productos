<?php
require 'config.php';
$database = new Database();
$conn = $database->getConnection();

$query = "SELECT id, nombre, descripcion, precio FROM productos";
$stmt = $conn->prepare($query);
$stmt->execute();

$productos = [];

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $row['acciones'] = '<a href="#" class="btn btn-warning btn-sm edit-btn rounded-pill"
        data-id="' . $row['id'] . '"
        data-nombre="' . $row['nombre'] . '"
        data-descripcion="' . $row['descripcion'] . '"
        data-precio="' . $row['precio'] . '"
        data-bs-toggle="modal" data-bs-target="#agregarModal">
        <i class="fa-solid fa-pencil-alt"></i> Editar
    </a>
    <a href="#" class="btn btn-danger btn-sm delete-btn rounded-pill" data-id="' . $row['id'] . '">
        <i class="fa-solid fa-trash"></i> Eliminar
    </a>';
    
    $productos[] = $row;
}

header('Content-Type: application/json');
echo json_encode(['data' => $productos]);
?>