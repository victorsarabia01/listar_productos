<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Listar Productos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/datatables.net-bs5/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/datatables.net-bs5/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">

    <script type="text/javascript" src="acciones.js"></script>
    <script type="text/javascript" src="validaciones.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" type="text/css" href="style.css">


    <!-- DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css">

<!-- jQuery y DataTables JS -->
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

<!-- Extensiones de Buttons -->
<script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<style>
    .logo-header {
  position: absolute;
  top: 10px;
  left: 20px;
  z-index: 1000;
}

.logo {
  height: 50px;
  width: auto;
  border-radius: 20%;

}
</style>

<body>

<header class="logo-header">
  <img src="img/logo.jpg" alt="Logo de la empresa" class="logo">
</header>

    <div class="container mt-5">
        <h1 class="text-center display-4 fw-bold text-success">
            Listando Productos <small class="text-muted">| Gestión Inteligente</small>
        </h1>

        <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#agregarModal">
            <i class="fa-solid fa-save"></i> Agregar
        </button>
<br>
<br>
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
                <th></th>
                <th></th>
                <th></th>
                <th></th>
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
                <form method="POST" id="productoForm" action="">
                    <div class="modal-body">
                        <input type="hidden" name="id" id="productoId">
                        <div class="mb-3">
                            <label class="form-label">Nombre:</label>
                            <input type="text" name="nombre" id="nombre" onKeyUp="buscarReg();"  class="form-control" required
                                maxlength="100" pattern="[A-Za-zÁ-ÿ\s]+" title="Solo letras y espacios, máximo 100 caracteres">
                            <div id="verificarRegistro"></div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Descripción:</label>
                            <textarea name="descripcion" id="descripcion" class="form-control" required
                                maxlength="150" pattern="[A-Za-zÁ-ÿ\s]+" title="Solo letras y espacios, máximo 150 caracteres"></textarea>
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

</body>

</html>