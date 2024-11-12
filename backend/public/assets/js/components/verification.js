function verificarYEnviar(action) {
  const formId = `#formulario${action === 'edit' ? 'Actualizar' : 'Crear'}`; // Obtener el ID del formulario según el tipo de acción
  // Obtener el formulario por su ID
  const form = document.querySelector(formId);
  // Verificar si el formulario es válido
  if (form.()) {
      // Si es válido, ejecutar el código AJAX correspondiente a la acción
      if (action === "create") {
          enviarFormularioCreate();
      } else if (action === "edit") {
          enviarFormularioEdit();
      }
  } else {
      // Si no es válido, mostrar mensajes de validación o realizar alguna acción
      // Puedes mostrar mensajes de error o resaltar los campos requeridos no completados, por ejemplo.
      console.log("El formulario no es válido");
  }
}


// Función para verificar la validación antes de ejecutar el servicio AJAX
function ejecutarValidacion(servicio, formulario, url) {
  const button = $(servicio);
  button.prop("disabled", true);

  if (formulario.checkValidity()) {
    const formData = new FormData(formulario);
    formData.forEach((valor, clave) => {
      console.log(clave, valor);
    });

    $.ajax({
      url: url,
      method: "POST",
      data: formData,
      processData: false,
      contentType: false,
      success: function (res) {
        console.log({ res });
        showNotification("success");
        formulario.reset();
        resetModal(buttonsModal.idCreateModal);
      },
      error: function (err) {
        console.log(err);
        resetModal(buttonsModal.idCreateModal);
        showNotification("error", err.responseJSON.message);
      },
    });
  } else {
    $("#mensaje_error").html("<p>error</p>");
    button.prop("disabled", false);
  }
}