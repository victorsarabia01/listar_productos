<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>CRUD con Bootstrap 5</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/datatables.net-bs5/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/datatables.net-bs5/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link href="style.css" rel="stylesheet">
</head>

<style>
    table.dataTable thead {
        background-color: #198754;
        color: white;
    }
    .table-striped tbody tr:nth-of-type(odd) {
        background-color: #f2f2f2;
    }
</style>
<body>

    <div class="container mt-5">
    <h1 class="text-center display-4 fw-bold text-success">
    Listando Productos <small class="text-muted">| Gestión Inteligente</small>
    </h1>

    <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#agregarModal">
    <i class="fa-solid fa-save"></i> Agregar
    </button>

    <table id="productosTable" class="table table-hover nowrap" style="width:100%;">
        <thead class="thead-dark">
      <tr class="table-dark">
                
                <th>Nombre</th>
                <th>Descripción</th>
                <th>Precio</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php
            require 'config.php';
            $database = new Database();
            $conn = $database->getConnection();

            $query = "SELECT * FROM productos";
            $stmt = $conn->prepare($query);
            $stmt->execute();

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                echo "<tr>";
                
                echo "<td>{$row['nombre']}</td>";
                echo "<td>{$row['descripcion']}</td>";
                echo "<td>{$row['precio']} Bs</td>";
echo '<td>
    <a href="#" class="btn btn-warning btn-sm edit-btn rounded-pill"
        data-id="' . $row['id'] . '"
        data-nombre="' . $row['nombre'] . '"
        data-descripcion="' . $row['descripcion'] . '"
        data-precio="' . $row['precio'] . '"
        data-bs-toggle="modal" data-bs-target="#agregarModal">
        <i class="fa-solid fa-pencil-alt"></i> Editar
    </a>

    <a href="#" class="btn btn-danger btn-sm delete-btn rounded-pill" data-id="' . $row['id'] . '">
        <i class="fa-solid fa-trash"></i> Eliminar
    </a>
</td>';
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>
</div>



<!-- Modal para Agregar/Editar Producto -->
<div class="modal fade" id="agregarModal" tabindex="-1" aria-labelledby="agregarModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle">Agregar Nuevo Producto</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <form method="POST" action="guardar.php">
                <div class="modal-body">
                    <input type="hidden" name="id" id="productoId">
                    <div class="mb-3">
                        <label class="form-label">Nombre:</label>
                        <input type="text" name="nombre" id="nombre" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Descripción:</label>
                        <textarea name="descripcion" id="descripcion" class="form-control" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Precio:</label>
                        <input type="number" name="precio" id="precio" class="form-control" step="0.01" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success" id="submitBtn">Registrar Producto</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </form>
        </div>
    </div>
</div>



<script>
    $(document).ready(function() {
        var tabla = $('#productosTable').DataTable({
            language: {
                url: "https://cdn.datatables.net/plug-ins/1.13.4/i18n/es-ES.json"
            },
            dom: '<"top"f><"bottom"l><"clear">rt<"row"<"col-md-6"i><"col-md-6 text-end"p>>'
        });

    });
</script>

<script>
    $(document).ready(function() {
        $('.edit-btn').click(function() {
            var id = $(this).data('id');
            var nombre = $(this).data('nombre');
            var descripcion = $(this).data('descripcion');
            var precio = $(this).data('precio');

            $('#productoId').val(id);
            $('#nombre').val(nombre);
            $('#descripcion').val(descripcion);
            $('#precio').val(precio);

            $('#modalTitle').text("Editar Producto");
            $('#submitBtn').text("Actualizar Producto");
        });

        $('#agregarModal').on('hidden.bs.modal', function () {
            $('#productoId').val('');
            $('#nombre').val('');
            $('#descripcion').val('');
            $('#precio').val('');
            $('#modalTitle').text("Agregar Nuevo Producto");
            $('#submitBtn').text("Registrar Producto");
        });
    });
</script>

<script>
    // Captura el clic en el botón eliminar
document.addEventListener("click", function (event) {
    if (event.target.classList.contains("delete-btn")) {
        event.preventDefault(); // Evita que el enlace redirija de inmediato

        let productId = event.target.getAttribute("data-id");

        let confirmacion = confirm("¿Estás seguro de que quieres eliminar este producto?");
        if (confirmacion) {
            window.location.href = "eliminar.php?id=" + productId; // Redirige a eliminar.php
        }
    }
});
</script>



</body>
</html>