// acciones.js
// Este archivo maneja las acciones de agregar, editar y eliminar productos en la tabla
// Asegúrate de que jQuery y DataTables estén cargados en tu HTML antes de este script

//Aqui se carga el Datatables
$(document).ready(function () {
  $("#productosTable").DataTable({
    dom: '<"top"Bf><"bottom"l><"clear">rt<"row"<"col-md-6"i><"col-md-6 text-end"p>>',
  buttons: [
  {
    extend: 'excelHtml5',
    text: '<i class="fas fa-file-excel" style="color:#1D6F42;"></i> <span style="color:#1D6F42;">Excel</span>',
    className: 'btn btn-outline-light border border-success'
  },
  {
    extend: 'pdfHtml5',
    text: '<i class="fas fa-file-pdf" style="color:#C0392B;"></i> <span style="color:#C0392B;">PDF</span>',
    className: 'btn btn-outline-light border border-danger'
  },
  {
    extend: 'print',
    text: '<i class="fas fa-print" style="color:#2C3E50;"></i> <span style="color:#2C3E50;">Imprimir</span>',
    className: 'btn btn-outline-light border border-dark'
  }
],

    responsive: true,
    processing: true,
    serverSide: false,
    ajax: {
      url: "listar_productos.php",
      type: "GET",
    },
    pageLength: 10, // Establece el límite de 10 registros por página
    columns: [
      { data: "nombre" },
      { data: "descripcion" },
      { data: "precio" },
      { data: "acciones" },
    ],
    language: {
      url: "https://cdn.datatables.net/plug-ins/1.13.4/i18n/es-ES.json",
    },
    //dom: '<"top"f><"bottom"l><"clear">rt<"row"<"col-md-6"i><"col-md-6 text-end"p>>',
  });

  // Refrescar la tabla cada 2 minutos
  setInterval(function () {
    $("#productosTable").DataTable().ajax.reload(null, false);
  }, 120000);


// Captura el clic en el botón agregar

  $(document).on("click", ".edit-btn", function () {
    var id = $(this).data("id");
    var nombre = $(this).data("nombre");
    var descripcion = $(this).data("descripcion");
    var precio = $(this).data("precio");

    $("#productoId").val(id);
    $("#nombre").val(nombre);
    $("#descripcion").val(descripcion);
    $("#precio").val(precio);

    $("#modalTitle").text("Editar Producto");
    $("#submitBtn").text("Actualizar Producto");
  });

  $("#agregarModal").on("hidden.bs.modal", function () {
    $("#productoId").val("");
    $("#nombre").val("");
    $("#descripcion").val("");
    $("#precio").val("");
    $("#modalTitle").text("Agregar Nuevo Producto");
    $("#submitBtn").text("Registrar Producto");
  });

  $("#productoForm").on("submit", function (e) {
  e.preventDefault(); // Evita la recarga

  const formData = new FormData(this);
  const productoId = $("#productoId").val();
  const url = 'guardar_editar_productos.php';

  fetch(url, {
    method: "POST",
    body: formData
  })
    .then(response => response.json())
    .then(data => {
      if (data.success) {
        Swal.fire({
          icon: "success",
          title: productoId ? "Producto actualizado" : "Producto registrado",
          showConfirmButton: false,
          timer: 1500
        });

        $("#agregarModal").modal("hide");
        $('#productosTable').DataTable().ajax.reload(null, false);
      } else {
        Swal.fire({
          icon: "error",
          title: "Error",
          text: data.message || "No se pudo guardar el producto"
        });
      }
    })
    .catch(error => {
      console.error("Error:", error);
      Swal.fire({
        icon: "error",
        title: "Error inesperado",
        text: "Ocurrió un problema al procesar la solicitud."
      });
    });
});


// Captura el clic en el botón eliminar
document.addEventListener("click", function (event) {
  if (event.target.classList.contains("delete-btn")) {
    event.preventDefault();

    const productId = event.target.getAttribute("data-id");

    Swal.fire({
      title: '¿Estás seguro?',
      text: "Esta acción no se puede deshacer",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#d33',
      cancelButtonColor: '#3085d6',
      confirmButtonText: 'Sí, eliminar',
      cancelButtonText: 'Cancelar'
    }).then((result) => {
      if (result.isConfirmed) {
        // Enviar solicitud AJAX para eliminar
        fetch(`eliminar_productos.php?id=${productId}`, {
          method: 'GET'
        })
        .then(response => response.json())
        .then(data => {
          if (data.success) {
            Swal.fire(
              '¡Eliminado!',
              'El producto ha sido eliminado correctamente.',
              'success'
            ).then(() => {
              // Recargar tabla si usas DataTables
              $('#productosTable').DataTable().ajax.reload(null, false);
            });
          } else {
            Swal.fire(
              'Error',
              data.message || 'No se pudo eliminar el producto.',
              'error'
            );
          }
        })
        .catch(error => {
          console.error(error);
          Swal.fire(
            'Error',
            'Ocurrió un problema al procesar la solicitud.',
            'error'
          );
        });
      }
    });
  }
});

// Validación del formulario antes de enviar
  $("#submitBtn").click(function (event) {
    var nombre = $("#nombre").val().trim();
    var descripcion = $("#descripcion").val().trim();

    var regexTexto = /^[a-zA-ZÁ-ÿ\s]{1,100}$/; // Solo letras y espacios para "Nombre"
    var regexDescripcion = /^[a-zA-ZÁ-ÿ0-9\s]{1,150}$/; // Letras, números y espacios para "Descripción"

    if (!regexTexto.test(nombre)) {
      alert(
        "El nombre solo debe contener letras y espacios, y no puede superar los 100 caracteres."
      );
      event.preventDefault(); // Evita el envío del formulario si falla la validación
      return;
    }

    if (!regexDescripcion.test(descripcion)) {
      alert(
        "La descripción solo debe contener letras, números y espacios, y no puede superar los 150 caracteres."
      );
      event.preventDefault();
      return;
    }
  });
});
