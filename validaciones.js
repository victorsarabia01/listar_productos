function buscarReg() {
  var buscar = $("#nombre").val();
  console.log(buscar);

  if (buscar !== "") {
    $.post("buscar_registro_producto.php", { valorBusqueda: buscar }, function (mensaje) {
      $("#verificarRegistro").html(mensaje);

      // Verifica si el mensaje contiene la advertencia de duplicado
      if (mensaje.includes("ya está registrado")) {
        $("#submitBtn").prop("disabled", true);
      } else {
        $("#submitBtn").prop("disabled", false);
      }
    });
  } else {
    $("#verificarRegistro").html('');
    $("#submitBtn").prop("disabled", false);
  }
}